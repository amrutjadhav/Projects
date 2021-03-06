<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{	
		//echo "Coming Soon";
		try{
      		 DB::connection()->getDatabaseName();
      		 //Session::set('locale' , 'es');
      
       		$post = Post::get();
			$cats = Category::orderBy('order_type')->get();
			$noti_post = Post::orderBy(DB::raw('RAND()'))->where('is_approved',1)->first();
			$post_test = Post::count();
			// i++ page count
			counter('home');
			return View::make('index')->with('posts',$post)->with('noti_post',$noti_post)->with('cats',$cats)->with('post_test',$post_test);
        }

        catch(Exception $e){
       		return Redirect::route('install');
        }

	}

	public function selectCat($id)
	{
		$cats = Category::orderBy('order_type')->get();
		$posts = "SELECT * from posts where category LIKE '%$id%'";
		$post = DB::select(DB::raw($posts));
		if($post)
		{
			return View::make('category')->withCategory_id($id)->with('cats',$cats);
		}
		else
		{
			return Redirect::route('home');
		}

	}

	public function single($id,$data)
	{
		$segment = $data;

		$publisher_image = "";

		$cats = Category::orderBy('order_type')->get();
		$post_details = Post::where('link',$segment)->where('is_approved',1)->first();
		$related = Post::rand()->take(3)->get();

		if($post_details)
		{	
			if($publisher = Publisher::find($post_details->publisher_id))
			{ 
				$publisher_image = $publisher->image;
			}

			counter($segment);

			return View::make('single-post')
						->withRelated($related)
						->with('publisher_image',$publisher_image)
						->withPost($post_details)
						->with('cats',$cats);
		}
		else
		{
			return Redirect::route('home');
		}
		
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::route('login');
	}

	public function login(){
		return View::make('login');
	}

	public function processLogin()
	{
		$validator = Validator::make(array(
			'email' => Input::get('email'),
			'password' => Input::get('password')),
			array('email' => 'required',
				'password' => 'required'));
		$email = Input::get('email');
		$password = Input::get('password');
		if($validator->fails())
		{
			$errors = $validator->messages()->all();
			return Redirect::back()->with('flash_errors',$errors);
		}
		else
		{
			if (Auth::attempt(array('email' => $email, 'password' => $password)))
			{
				$user = Auth::user();
				if($user->role_id == 2)
				{
					return Redirect::route('adminDashboard');
				}
				elseif($user->role_id == 1)
				{
					if($user->is_activated == 1)
					{
						return Redirect::route('moderateDashboard');
					}
					else
					{
						return Redirect::back()->with('flash_error',tr('login_error'));
					}
				}
				elseif($user->role_id == 3)
				{
					if($user->is_activated == 1)
					{
						return Redirect::route('contributorDashboard');
					}
					else
					{
						return Redirect::back()->with('flash_error',tr('login_error'));
					}
				}
				else
				{
					return Redirect::back()->with('flash_error',tr('went_wrong'));
				}
			}
			else
			{
				return Redirect::back()->with('flash_error',tr('login_email_password_error'));
			}
		}
	}

	public function processForgotpassword(){
		$email = Input::get('email');

		$validator = Validator::make(
			array(
				'email' => $email,
			), array(
				'email' => 'required|email',
			)
		);

		if ($validator->fails())
		{
			$error_messages = $validator->messages()->all();
			return Redirect::back()->with('flash_errors',$error_messages);
		}
		else
		{
			$user = User::where('email',$email)->first();
			if(!$user)
			{
				return Redirect::back()->with('flash_errors', tr('forgot_password_error'));
			}

			$new_password = time();
			$new_password .= rand();
			$new_password = sha1($new_password);
			$new_password = substr($new_password, 0, 8);
			$user->password = Hash::make($new_password);

			$subject = "Your New Password";
			$email_data['name'] = $user->author_name;
			$email_data['password'] = $new_password;
			$email_data['email'] = $user->email;
			$user->save();

			if($user)
			{
				Mail::send('emails.newmoderator', array('email_data' => $email_data), function ($message) use ($email, $subject) {
					$message->to($email)->subject($subject);
				});
				return Redirect::back()->with('flash_success',tr('forgot_password_success'));
			}else{
				return Redirect::back()->with('flash_errors',tr('went_wrong'));
			}
		}
	}

	public function forgot_password()
	{
		return View::make('forgot_password');
	}

	public function ajax_loading()
	{
		$offset = is_numeric(Input::get('offset')) ? Input::get('offset') : die();
        $postnumbers = is_numeric(Input::get('number')) ? Input::get('number') : die();
        $q = Input::get('query');


        Log::info('num'. $q);
        Log::info('offset'. $offset);

        $query = "";

        if($q == ""){
        $query = Post::orderBy('created_at','desc')->distinct()->where('is_approved',1)->limit($postnumbers)->offset($offset)->get();
        }elseif($q != ""){
        $query = Post::orderBy('created_at','desc')->distinct()->where('is_approved',1)->where('title','like', '%'.$q.'%')->orWhere('des','like', '%'.$q.'%')->limit($postnumbers)->offset($offset)->get();
        }
        $data = $query;


        foreach ($data as $post) {
        	$append = "";
				$cat_name = $post->share_cat;

				if($publisher = Publisher::find($post->publisher_id)) {
					$publisher_name = $publisher->name;
					$publisher_image = $publisher->image;
				} else {
					$publisher_name = "";
					$publisher_image = "";
				}

				if($cat_name == ""){
					$cat_name = "news";
				}
                $fb = route("shareLink",array("id" => $cat_name,"data" => $post->link));
                $twitter = route("shareLink",array("id" => $cat_name,"data" => $post->link));

          $append ='<div class="col m6 s12 l4">
                          <div class="single-post card animated zoomIn">
                              <div class="card-image">
                                <a href="javascript:void(0);"><img src="'.$post->image.'" style="
    position: relative;
"></a>
 <span class="card-title"><em class="time-ago right">'.$post->created_at->diffForHumans().'</em></span>
                              </div>
                              <div class="card-content">
                                <b style="    font-size: large;    font-family: sans-serif;">'.$post->title.'</b> <hr>
                               <p class="text-justify">'.$post->des.'</p>';

                                      $append .='</div>
                              <div class="card-action text-center">

                                <a target="_blank" href="http://www.facebook.com/sharer.php?u='.$fb.'" class="full waves-effect waves-light btn light-blue darken-4"><i class="fa fa-facebook left$
                                <a target="_blank" href="http://twitter.com/share?text='.$post->title.'...&url='.$twitter.'" class="full waves-effect waves-light btn no-right-mar light-blue acce$
                                <a target="_blank" href="'.$post->url.'" target="_blank" class="full-btn waves-effect waves-light btn no-right-mar mat-clr">Read More </a>

                              </div>


                          </div>
                      </div>';

                         echo $append;

        }
	}

	public function ajax_loading_category()
	{
		$offset = is_numeric(Input::get('offset')) ? Input::get('offset') : die();
        $postnumbers = is_numeric(Input::get('number')) ? Input::get('number') : die();
        $id = Input::get('category_id');

        Log::info('num'. $postnumbers);
        Log::info('offset'. $offset);

        $query = Post::orderBy('created_at','desc')->distinct()->where('is_approved',1)->where('category', 'LIKE', '%'.$id.'%')->limit($postnumbers)->offset($offset)->get();
        
        $data = $query;

        foreach ($data as $post) {
        	$append = "";
				$cat_name = $post->share_cat;
				if($publisher = Publisher::find($post->publisher_id)) {
					$publisher_name = $publisher->name;
					$publisher_image = $publisher->image;
				} else {
					$publisher_name = "";
					$publisher_image = "";
				}

                $fb = route("shareLink",array("id" => $cat_name,"data" => $post->link));
                $twitter = route("shareLink",array("id" => $cat_name,"data" => $post->link));
        	$append = '<div class="col m6 s12 l4">
		          <div class="single-post card animated zoomIn">

		              <div class="card-image">
		                <a href="javascript:void(0);"><img src="'.$post->image.'"></a>
		                <span class="card-title">'.$post->title.'<em class="time-ago right">'.$post->created_at->diffForHumans().'</em></span>
		              </div>
		              <div class="card-content">
		               <p class="text-justify">'.$post->des.'</p>';

		               if($publisher_image) 
		               {
			               $append .= '<div class="au-btm">
				               
					               <div class="au-left">
					               <a href="'.$post->url.'" target="_blank">
					               	<img src="'.$publisher_image.'">
					               	 </a>
					               </div>
				              
							</div>';
						}
			              $append .='</div>
			            

		             	<div class="card-action text-center">

		                <a target="_blank" href="http://www.facebook.com/sharer.php?u='.$fb.'" class="full waves-effect waves-light btn light-blue darken-4"><i class="fa fa-facebook left"></i>Share on Facebook</a>
		                <a target="_blank" href="http://twitter.com/share?text='.$post->title.'...&url='.$twitter.'" class="full waves-effect waves-light btn no-right-mar light-blue accent-3"><i class="fa fa-twitter left"></i>Share on Twitter</a>
		                <a target="_blank" href="'.$post->url.'" target="_blank" class="full-btn waves-effect waves-light btn no-right-mar mat-clr">Read More </a>

		              </div>
		             
		              
		          </div>  	
		      </div>';

		      echo $append;

        }
	}

		public function install()
	{
		try{
	      DB::connection()->getDatabaseName();
	      
			$count = User::where('role_id',2)->count();
			if($count == 0){
	    		return View::make('install');
	    	}else{
	    		return Redirect::to('/');
	    	}
    	}

    	catch(Exception $e){
       		return View::make('install');
        }
    }

    public function install_submit()
    {
        $username = Input::get('username');
        $password = Input::get('password');
        $admin_username = Input::get('admin_username');
        $admin_password = Input::get('admin_password');
        $sitename = Input::get('sitename');
        $database_name = Input::get('database_name');
        $picture = Input::file('picture');
        $timezone = Input::get('timezone');
        $database_host = Input::get('database_host');


        $validator = Validator::make(
            array(
                'password' => $password,
                'username' => $username,
                'database_name' => $database_name,
                'admin_username' => $admin_username,
                'admin_password' => $admin_password,
                'sitename' => $sitename,
                'picture' => $picture,
                'timezone' => $timezone,
                'database_host' => $database_host
                
            ), array(
                'password' => '',
                'username' => 'required',
                'sitename' => 'required',
                'database_name' => 'required',
                'admin_password' => 'required',
                'admin_username' => 'required',
                'timezone' => 'required',
                'picture' => 'mimes:png,jpg',
                'database_host' => 'required',
            )
        );

        if ($validator->fails())
        {
            $error_messages = $validator->messages()->all();
            return Redirect::back()->with('flash_errors',$error_messages);
        }
        else
        {
            $file_name = time();
            $file_name .= rand();
            if(Input::hasFile('picture'))
            {
            	$ext = Input::file('picture')->getClientOriginalExtension();
	            Input::file('picture')->move(public_path() . "/uploads", $file_name . "." . $ext);
	            $local_url = $file_name . "." . $ext;
	            $s3_url = URL::to('/') . '/uploads/' . $local_url;
            }

            Setting::set('sitename',$sitename);
            Setting::set('footer',"Powered by Appoets");
            Setting::set('username',$username);
            Setting::set('password',$password);
            Setting::set('database_name',$database_name);
            Setting::set('timezone',$timezone);
            Setting::set('logo',$s3_url);
            Setting::set('database_host',$database_host);

            import_db($username,$password,'localhost',$database_name);

            $admin = new User;
            $admin->email = $admin_username;
            $admin->is_activated = 1;
            $admin->password = Hash::make($admin_password);
            $admin->author_name = "Admin";
            $admin->role_id = 2;
            $admin->save();

            // Default publisher

            $publisher = new Publisher;
            $publisher->name = Input::get('sitename');
            if(Input::hasFile('picture'))
            {
            	$publisher->image = Setting::get('logo');
            }
            $publisher->save();

            // Default category

            $category = new Category;
            $category->name = "Uncategory";
            if(Input::hasFile('picture'))
            {
            	$category->pics = Setting::get('logo');
            }
            $category->save();

            return Redirect::to('/');
        }
    }

	public function shareLink($id,$data)
	{

		$segment = $data;
		$cats = Category::orderBy('order_type')->get();
		$post_details = Post::where('link',$segment)->where('is_approved',1)->first();
		$related = Post::orderByRaw("RAND()")->where('is_approved',1)->take(2)->get();

		if($post_details)
		{
			if($publisher = Publisher::find($post_details->publisher_id)) 
            {
                $publisher_name = $publisher->name;
                $publisher_image = $publisher->image;
            } else {
                $publisher_name = "";
                $publisher_image = "";
            }

			counter($segment);

			return View::make('single-post')
				->withRelated($related)
				->with('publisher_image' , $publisher_image)
				->withPost($post_details)
				->with('cats',$cats);
		}
		else
		{
			return Redirect::route('home');
		}
	}

}
