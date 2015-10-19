<?php
/**
 * Created by PhpStorm.
 * User: aravinth
 * Date: 19/7/15
 * Time: 5:06 PM
 */
?>

@extends('contributor.contributorLayout')

@section('content')

    @include('notification.notify')

    <div class="page">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form" action="{{route('contributorProfileProcess')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$admin->id}}">
                        <div class="form-group">
                            <input type="text" class="form-control" id="regular1" name="first_name" value="{{$admin->first_name}}">
                            <label for="regular1">First Name</label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="regular1" name="last_name" value="{{$admin->last_name}}">
                            <label for="regular1">Last Name</label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="regular1" name="email" value="{{$admin->email}}">
                            <label for="regular1">Email</label>￼
                        </div>

                        <button type="submit" class="btn ink-reaction btn-raised btn-primary">Submit</button>
                    </form>
                </div><!--end .card-body -->
            </div><!--end .card -->

        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form" action="{{route('contributorProfilePics')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$admin->id}}">

                        <div class="file-field input-field col s12">
                            <div class="tile-content">
                                <div class="tile-icon brand-logo">
                                    <img  src="{{$admin->profile_pic}}" alt="">
                                </div>
                            </div>
                            <div class="btn light-blue accent-2" style="padding: 0px 10px;">
                                <span>Choose Picture</span>
                                <input type="file" name="profile_pic" />
                            </div>
                            <input class="file-path validate" type="text" />

                        </div>
                        <button type="submit" class="btn ink-reaction btn-raised btn-primary">Submit</button>
                    </form>
                </div><!--end .card-body -->
            </div><!--end .card -->

        </div>


        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form" action="{{route('contributorPassword')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$admin->id}}">

                        <div class="form-group">
                            <input type="password" class="form-control" id="regular1" name="password" >
                            <label for="regular1">Password</label>￼
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="regular1" name="con_password">
                            <label for="regular1">Con Password</label>￼
                        </div>



                        <button type="submit" class="btn ink-reaction btn-raised btn-primary">Submit</button>
                    </form>
                </div><!--end .card-body -->
            </div><!--end .card -->

        </div>



    </div>
    </div>


@stop