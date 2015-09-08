<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{Setting::get('sitename')}}</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    <link type="text/css" rel="stylesheet" href="{{asset('admin/css/theme-default/bootstrap.css?1422792965')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('admin/css/theme-default/materialadmin.css?1425466319')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('admin/css/theme-default/font-awesome.min.css?1422529194')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('admin/css/theme-default/material-design-iconic-font.min.css?1421434286')}}" />
    <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
    <script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
    <![endif]-->
</head>
<body class="menubar-hoverable header-fixed ">

<!-- BEGIN LOGIN SECTION -->
<section class="section-account">
    <div class="img-backdrop" style="background-image: url('admin/img/signin-bg.jpg')"></div>
    <div class="spacer"></div>
    <div class="card contain-sm style-transparent">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <br/>
                    <span class="text-lg text-bold text-primary">INSHORTS SIGNUP</span>
                    <br/><br/>
                    <form class="form floating-label" action="{{route('signupProcess')}}" accept-charset="utf-8" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username">
                            <label for="username">Username</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password">
                            <label for="password">Password</label>

                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="cnfrmpassword" name="cnfrmpassword">
                            <label for="cnfrmpassword">Confirm Password</label>

                        </div>
                        <br/>
                        <div class="row">

                            <div class="col-xs-12 text-right">
                                <button class="btn btn-primary btn-raised" type="submit">Signup</button>
                            </div><!--end .col -->
                        </div><!--end .row -->
                    </form>
                </div><!--end .col -->
                <div class="col-sm-5 col-sm-offset-1 text-center">
                    <br><br>
                    <h3 class="text-light">
                        Already You have have an account?
                    </h3>
                    <a class="btn btn-block btn-raised btn-primary" href="{{route('login')}}">Login here</a>
                    <br><br>

                </div><!--end .col -->
            </div><!--end .row -->
        </div><!--end .card-body -->
    </div><!--end .card -->
</section>
<!-- END LOGIN SECTION -->

<!-- BEGIN JAVASCRIPT -->
<script src="{{asset('admin/js/libs/jquery/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('admin/js/libs/jquery/jquery-migrate-1.2.1.min.js')}}"></script>
<script src="{{asset('admin/js/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/js/libs/spin.js/spin.min.js')}}"></script>
<script src="{{asset('admin/js/libs/autosize/jquery.autosize.min.js')}}"></script>
<script src="{{asset('admin/js/libs/nanoscroller/jquery.nanoscroller.min.js')}}"></script>
<script src="{{asset('admin/js/core/source/App.js')}}"></script>
<script src="{{asset('admin/js/core/source/AppNavigation.js')}}"></script>
<script src="{{asset('admin/js/core/source/AppOffcanvas.js')}}"></script>
<script src="{{asset('admin/js/core/source/AppCard.js')}}"></script>
<script src="{{asset('admin/js/core/source/AppForm.js')}}"></script>
<script src="{{asset('admin/js/core/source/AppNavSearch.js')}}"></script>
<script src="{{asset('admin/js/core/source/AppVendor.js')}}"></script>
<script src="{{asset('admin/js/core/demo/Demo.js')}}"></script>
<!-- END JAVASCRIPT -->

</body>
</html>
