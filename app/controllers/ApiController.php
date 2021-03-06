<?php

class ApiController extends \BaseController
{

	public function getCategory()
	{
		$category = Category::orderBy('order_type')->get();
		if ($category) {
			$response_array = array('success' => true, 'category' => $category);
		} else {
			$response_array = array('success' => false, 'error_msg' => "no data");
		}
		return Response::json($response_array);
	}

	public function postDetails()
	{
		$posts = Post::where('is_approved', 1)->get();
		$datas = array();
		foreach ($posts as $post) {
			$cat_name = $post->share_cat;
			$link = URL::to('/') . '/read/' . $cat_name . '/' . $post->link;
			$data = array();
			$data['title'] = $post->title;
			$data['description'] = $post->des;
			$data['url'] = $post->url;
			$data['image'] = $post->image;
			$data['share_link'] = $link;
			array_push($datas, $data);
		}
		$response_array = array('success' => true, 'posts' => $datas);

		return Response::json($response_array);
	}

	public function getPostCat()
	{
		$cat = Input::get('category');
		$take = Input::get('take');
		$skip = Input::get('skip');

		$validator = Validator::make(
			array(
				'take' => $take,
				'skip' => $skip,
			), array(
				'take' => 'required|integer',
				'skip' => 'required|integer',
			)
		);

		if ($validator->fails()) {
			$error_messages = $validator->messages()->all();
			$response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages);
			$response_code = 200;
		} else {
			if (!$cat) {
				$posts = Post::where('is_approved', 1)->take($take)->skip($skip)->orderBy('created_at', 'desc')->get();
				$counts = Post::where('is_approved', 1)->count();
				$datas = array();
				foreach ($posts as $post) {

					if($publisher = Publisher::find($post->publisher_id)) {
						$publisher_name = $publisher->name;
						$publisher_image = $publisher->image;
					} else {
						$publisher_name = "";
						$publisher_image = "";
					}

					$cat_name = $post->share_cat;
					$link = URL::to('/'). '/read/' . $cat_name . '/' . $post->link;
					$data = array();
					$data['id'] = $post->id;
					$data['title'] = $post->title;
					$data['description'] = $post->des;
					$data['url'] = $post->url;
					$data['image'] = $post->image;
					$data['time'] = $post->created_at->diffForHumans();
					$data['share_link'] = $link;
					$data['publisher_image'] = $publisher_image;
					$data['publisher_name'] = $publisher_name;

					array_push($datas, $data);
				}
				$response_array = array('success' => true, 'posts' => $datas, 'counts' => $counts);
			} else {

				$postss = Post::where('is_approved', 1)->where('category', 'like', '%' . $cat . '%')->take($take)->skip($skip)->orderBy('created_at', 'desc')->get();
				$counts = Post::where('is_approved', 1)->where('category', 'like', '%' . $cat . '%')->count();
				$datas = array();
				foreach ($postss as $post) {

					if($publisher = Publisher::find($post->publisher_id)) {
						$publisher_name = $publisher->name;
						$publisher_image = $publisher->image;
					} else {
						$publisher_name = "";
						$publisher_image = "";
					}

					$cat_name = $post->share_cat;
					$link = URL::to('/') . '/read/' . $cat_name . '/' . $post->link;
					$data = array();
					$data['id'] = $post->id;
					$data['title'] = $post->title;
					$data['description'] = $post->des;
					$data['url'] = $post->url;
					$data['image'] = $post->image;
					$data['time'] = $post->created_at->diffForHumans();
					$data['share_link'] = $link;

					$data['publisher_image'] = $publisher_image;
					$data['publisher_name'] = $publisher_name;
					

					array_push($datas, $data);
				}
				$response_array = array('success' => true, 'posts' => $datas, 'counts' => $counts);
			}
		}
		return Response::json($response_array);
	}
	
	
	public function getNewPostCat()
	{
		$cat = Input::get('category');
		$take = Input::get('take');
		$skip = Input::get('skip');
		$postid=Input::get('postid');

		$validator = Validator::make(
			array(
				'take' => $take,
				'skip' => $skip,
				'postid' =>$postid,
			), array(
				'take' => 'required|integer',
				'skip' => 'required|integer',
				'postid' => 'required|integer',
			)
		);

		if ($validator->fails()) {
			$error_messages = $validator->messages()->all();
			$response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages);
			$response_code = 200;
		} else {
			if (!$cat) {
				$posts = Post::where('is_approved', 1)->where('id','>', $postid)->take($take)->skip($skip)->orderBy('created_at', 'desc')->get();
				$counts = Post::where('is_approved', 1)->count();
				$datas = array();
				foreach ($posts as $post) {

					if($publisher = Publisher::find($post->publisher_id)) {
						$publisher_name = $publisher->name;
						$publisher_image = $publisher->image;
					} else {
						$publisher_name = "";
						$publisher_image = "";
					}

					$cat_name = $post->share_cat;
					$link = URL::to('/'). '/read/' . $cat_name . '/' . $post->link;
					$data = array();
					$data['id'] = $post->id;
					$data['title'] = $post->title;
					$data['description'] = $post->des;
					$data['url'] = $post->url;
					$data['image'] = $post->image;
					$data['time'] = $post->created_at->diffForHumans();
					$data['share_link'] = $link;
					$data['publisher_image'] = $publisher_image;
					$data['publisher_name'] = $publisher_name;

					array_push($datas, $data);
				}
				$response_array = array('success' => true, 'posts' => $datas, 'counts' => $counts);
			} else {

				$postss = Post::where('is_approved', 1)->where('category', 'like', '%' . $cat . '%')->where('id','>', $postid)->take($take)->skip($skip)->orderBy('created_at', 'desc')->get();
				$counts = Post::where('is_approved', 1)->where('category', 'like', '%' . $cat . '%')->count();
				$datas = array();
				foreach ($postss as $post) {

					if($publisher = Publisher::find($post->publisher_id)) {
						$publisher_name = $publisher->name;
						$publisher_image = $publisher->image;
					} else {
						$publisher_name = "";
						$publisher_image = "";
					}

					$cat_name = $post->share_cat;
					$link = URL::to('/') . '/read/' . $cat_name . '/' . $post->link;
					$data = array();
					$data['id'] = $post->id;
					$data['title'] = $post->title;
					$data['description'] = $post->des;
					$data['url'] = $post->url;
					$data['image'] = $post->image;
					$data['time'] = $post->created_at->diffForHumans();
					$data['share_link'] = $link;

					$data['publisher_image'] = $publisher_image;
					$data['publisher_name'] = $publisher_name;
					

					array_push($datas, $data);
				}
				$response_array = array('success' => true, 'posts' => $datas, 'counts' => $counts);
			}
		}
		return Response::json($response_array);
	}



	public function register()
	{
		$device_token = Input::get('device_token');
		$device_type = Input::get('device_type');
		$gcm	= Input::get('gcm');

		$validator = Validator::make(
			array(
				'device_token' => $device_token,
				'device_type' => $device_type,
			), array(
				'device_token' => 'required',
				'device_type' => 'required',
			)
		);

		if ($validator->fails())
		{
			$error_messages = $validator->messages()->all();
			$response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages);
			$response_code = 200;
		}
		else
		{
			//$check_device = User::where('device_token' , $device_token)->count();

			$finding_device = MobileRegister::whereDevice_token($device_token)->count();

			if ($finding_device == 0)
			{
				$add_device = new MobileRegister;
				$add_device->device_type = $device_type;
				$add_device->device_token = $device_token;
				$add_device->gcm = $gcm;
				$add_device->save();

				$response_array = array('success' => true, 'message' => 'Device Register Successfully');
			}
			else
			{
				$find_device = MobileRegister::whereDevice_token($device_token)->first();
				$find_device->gcm = $gcm;
				$find_device->save();

				$response_array = array('success' => false, 'message' => 'Device Already Registered');
			}
		}

		//send_notifications("hi" , "hi message");

		return Response::json($response_array);
	}

	public function postList()
	{
		$take = Input::get('take');
		$skip = Input::get('skip');

		$validator = Validator::make(
			array(
				'take' => $take,
				'skip' => $skip,
			), array(
				'take' => 'required',
				'skip' => 'required',
			)
		);

		if ($validator->fails()) {
			$error_messages = $validator->messages()->all();
			$response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages);
			$response_code = 200;
		} else {
			$posts = Post::take($take)->skip($skip)->orderBy('created_at', 'desc')->get();
			$counts = Post::count();
			$datas = array();
			foreach ($posts as $post) {

				$publisher_name = "";
				$publisher_image = "";

				if($post) {
					$publisher  = Publisher::find($post->publisher_id)->first();
					if(count($publisher) != 0) {
						$publisher_name = $publisher->name;
						$publisher_image = $publisher->image;
					}
				}
				$data = array();

				$data['id'] = $post->id;
				$data['title'] = $post->title;
				$data['description'] = $post->des;
				$data['url'] = $post->url;
				$data['image'] = $post->image;
				$data['time'] = $post->created_at;
				$data['share_link'] = $post->link;
				$data['category'] = $post->category;
				$data['is_approved'] = $post->is_approved;
				$data['title_tag'] = $post->title_tag;
				$data['meta_desc'] = $post->meta_des;
				$data['publisher_image'] = $publisher_image;
				$data['publisher_name'] = $publisher_name;

				array_push($datas, $data);
			}
			$response_array = array('success' => true, 'posts' => $datas, 'counts' => $counts);
		}
		return Response::json($response_array);
	}

	public function postDetail()
	{
		$id = Input::get('id');

		$validator = Validator::make(
			array(
				'id' => $id,
			), array(
				'id' => 'required',
			)
		);

		if ($validator->fails()) {
			$error_messages = $validator->messages()->all();
			$response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages);
			$response_code = 200;
		} else {
			$post = Post::find($id);
			if ($post) {
				$publisher = Publisher::find($post->publisher_id)->first();

				$publisher_name = "";
				$publisher_image = "";

				if(count($publisher) != 0) {
					$publisher_name  = $publisher->name;
					$publisher_image = $publisher->image; 
				}
				$data = array();
				$data['id'] = $post->id;
				$data['title'] = $post->title;
				$data['description'] = $post->des;
				$data['url'] = $post->url;
				$data['image'] = $post->image;
				$data['time'] = $post->created_at;
				$data['share_link'] = $post->link;
				$data['category'] = $post->category;
				$data['is_approved'] = $post->is_approved;
				$data['title_tag'] = $post->title_tag;
				$data['meta_desc'] = $post->meta_des;
				$data['publisher_name'] = $publisher_name;
				$data['publisher_image'] = $publisher_image;

			}
			$response_array = array('success' => true, 'posts' => $data);
		}
		return Response::json($response_array);
	}

	

	public function auto_save_form()
	{
		$category = Input::get('category');
		$title = Input::get('title');
		$post_img = Input::file('post_img');
		$url = Input::get('url');
		$title_tag = Input::get('title_tag');
		$meta_des = Input::get('meta_des');
		$share_link = Input::get('share_link');
		$share_cat = Input::get('share_cat');
		$author = Input::get('author');
		$publisher = Input::get('publisher');

			if(Input::get('id') != ""){
				$post = Post::find(Input::get('id'));
			}else{
				$post = new Post;
			}

			if($title != ""){
				$post->title = $title;
			}

			$post->is_approved = 0;
			if($url != ""){
				$post->url = $url;
			}	

			if($publisher != ""){
				$post->publisher = $publisher;
			}

			if($author != ""){
				$post->author = $author;
			}

			if(Auth::user()){
				$post->user_id = Auth::user()->id;
			}
			
			if(Input::get('des') != ""){
				$post->des = Input::get('des');
			}

			if($meta_des != ""){
				$post->meta_des = $meta_des;
			}

			if(!empty($category)){
				$post->category = implode(',', $category);
			}

			if($share_cat != ""){
				$post->share_cat = $share_cat;
			}

			if(Input::get('share_link') != ""){
				$link = str_replace(" ", "-", Input::get('share_link')) . '-' . rand(0, 99);
				//$post->link = $link;
				$post->share_title = Input::get('share_link');
			}

			if($title_tag != ""){
				$post->title_tag = $title_tag;
			}
			$post->save();

			$response_array = array('success' => true , 'new_id' => $post->id);
		
		return Response::json($response_array);
	}


	public function addApiPostProcess()
	{
		$category = Input::get('category');
		$title = Input::get('title');
		$post_img = Input::file('post_img');
		$url = Input::get('url');
		$title_tag = Input::get('title_tag');
		$meta_des = Input::get('meta_des');
		$share_link = Input::get('share_link');
		$share_cat = Input::get('share_cat');

		$validator = Validator::make(
			array(
				'title' => $title,
				'url' => $url,
				'meta_des' => $meta_des,
				'category' => $category,
				'post_img' => $post_img,
				'share_link' => $share_link,
				'share_cat' => $share_cat,
			), array(
				'title' => 'required',
				'url' => 'required',
				'meta_des' => 'required',
				'share_link' => 'required',
				'share_cat' => 'required',
				'category' => '',
				'post_img' => 'mimes:jpeg,bmp,gif,png'
			)
		);

		if ($validator->fails()) {
			$error_messages = $validator->messages()->all();
			$response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages);
			$response_code = 200;
		} else {
			$post = new Post;
			$post->title = $title;
			$post->is_approved = 1;
			$post->url = $url;
			$post->des = Input::get('des');
			$post->meta_des = $meta_des;

			$file_name = time();
			$file_name .= rand();
			$path = $_FILES['file']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			// $ext = Input::file('post_img')->getClientOriginalExtension();
			Input::file('post_img')->move(public_path() . "/uploads", $file_name . "." . $ext);
			$local_url = $file_name . "." . $ext;

			// Upload to S3
			$s3_url = URL::to('/') . '/uploads/' . $local_url;

			$post->image = $s3_url;

			$post->category = implode(',', $category);

			$post->share_cat = $share_cat;

			$link = str_replace(" ", "-", Input::get('share_link')) . '-' . rand(0, 99);

			$post->link = $link;
			$post->title_tag = $title_tag;
			$post->save();

			$response_array = array('success' => true);
		}
		return Response::json($response_array);
	}



	public function api_ajax_loading(){
         $offset = is_numeric(Input::get('offset')) ? Input::get('offset') : die();
        $postnumbers = is_numeric(Input::get('number')) ? Input::get('number') : die();

        $query = "";

        $query = Post::orderBy('id','desc')->distinct()->where('is_approved',1)->limit($postnumbers)->offset($offset)->get();
        
        $data = $query;


        foreach ($data as $post) {
                $cat_id = explode(',', $post->category);
                $cat_data = Category::find($cat_id[0]);
                $cat_name = $cat_data->name;
                $fb = route("single",array("id" => $cat_name,"data" => $post->link));
                $twitter = route("single",array("id" => $cat_name,"data" => $post->link));
        	echo '<div class="col-md-3">
		          <div class="single-post card animated zoomIn">
		                <span class="card-title">'.$post->title.'<em class="time-ago right">'.$post->created_at->diffForHumans().'</em></span>
		              <div class="card-content">
		               <p class="text-justify">'.$post->des.'</p>
		              </div>

		              <div class="card-action text-center">

		                <a href="http://www.facebook.com/sharer.php?u='.$fb.'" class="full waves-effect waves-light btn light-blue darken-4"><i class="fa fa-facebook left"></i>Share on Facebook</a>
		                <a href="http://twitter.com/share?text='.$post->title.'&url='.$twitter.'" class="full waves-effect waves-light btn no-right-mar light-blue accent-3"><i class="fa fa-twitter left"></i>Share on Twitter</a>
		                <a href="'.$post->url.'" target="_blank" class="full-btn waves-effect waves-light btn no-right-mar mat-clr">Read More </a>

		              </div>
		             
		              
		          </div>  	
		      </div>';

        }
    }

    
       public function api_hybrid_feed(){

         $offset = is_numeric(Input::get('offset')) ? Input::get('offset') : die();
        $postnumbers = is_numeric(Input::get('number')) ? Input::get('number') : die();

        $query = "";

        $query = Post::orderBy('id','desc')->distinct()->where('is_approved',1)->limit($postnumbers)->offset($offset)->get();
        
        $data = $query;


        foreach ($data as $post) {
        	echo '<div class="section fp-section fp-table"><div class="fp-tableCell">
        	<div class="swiper-slide">
                    <div class="news-box">
                        <div class="img-container">
                            <img src="'.$post->image.'">
                            <div class="bottom-nav">
                                <h6>'.$post->created_at->diffForHumans().'</h6>
                                <a href="javascript:void(0);" onclick="window.plugins.socialsharing.share(\''.$post->title.'\', null, null, \'http://www.x-services.nl\')" class="icon right"><i class="fa fa-share"></i></a>
                            </div>
                        </div>
                        <div class="conent-container">
                            <h4>'.$post->title.'</h4>

                            <p>'.$post->des.'</p>

                            <div class="read">
                                <a href="javascript:void(0);" onclick="open_this_url(url);"><i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i></a>
                            </div>
                        </div>
                    </div>
                </div></div></div>';

        }
    }

	public function testpush()
	{
		$title = "PBN";
		$message = "post added";
		$post_id = 1;
		$url = "single.html";

		Log::info($message);

     	send_notifications($title,$message,$post_id,$url);
	}

	public function singlePost() {

		$post_id = Input::get('id');

		$validator = Validator::make(
			array(
				'post_id' => $post_id,
			), array(
				'post_id' => 'required',
			)
		);

		if ($validator->fails()) {
			$error_messages = $validator->messages()->all();
			$response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages);
			$response_code = 200;
		} else {
			if($post = Post::find($post_id)) {
				if($publisher = Publisher::find($post->publisher_id)) {
					$publisher_name = $publisher->name;
					$publisher_image = $publisher->image;
				} else {
					$publisher_name = "";
					$publisher_image = "";
				}
				$datas = array();

				$cat_name = $post->share_cat;
				$link = URL::to('/'). '/read/' . $cat_name . '/' . $post->link;
				$data = array();
				$data['id'] = $post->id;
				$data['title'] = $post->title;
				$data['description'] = $post->des;
				$data['url'] = $post->url;
				$data['image'] = $post->image;
				$data['time'] = $post->created_at->diffForHumans();
				$data['share_link'] = $link;
				$data['publisher_image'] = $publisher_image;
				$data['publisher_name'] = $publisher_name;

				array_push($datas, $data);

				$response_array = array('success' => true, 'posts' => $datas);
			} else {
				$response_array = array('success' => false , 'error' => 'Post Not Found');
			}
		}

		return Response::json($response_array);
	}

	public function pbnlite() {

		$s_date = date('Y-m-d'." "."00:00:00");
		$e_date = date('Y-m-d'." "."23:59:59");


		$pbn_lites = PbnLite::where('pbn_lites.created_at', '>=', $s_date )
						->where('pbn_lites.created_at', '<=', $e_date )
						->leftJoin('posts','pbn_lites.post_id','=','posts.id')
						->select('posts.id as post_id' , 'pbn_lites.title as post_title' ,'posts.url as url')
						->get();

		$count = count($pbn_lites);

		if($pbn_lites) {

			$post_data = array();

			foreach ($pbn_lites as $pl => $pbn_lite) 
			{
				$post_data[$pl]['post_id'] = $pbn_lite->post_id;
				$post_data[$pl]['title'] = $pbn_lite->post_title;
				$post_data[$pl]['share'] = $pbn_lite->url;
				$post_data['count'] = $count;
			}

			$response_array = array('success' => true, 'posts' => $post_data);

		} else {

			$response_array = array('success' => false, '' => "No Post Found Today");
		}

		return Response::json($response_array);


	}

}


