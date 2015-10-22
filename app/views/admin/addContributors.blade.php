<?php
/**
 * Created by PhpStorm.
 * User: aravinth
 * Date: 19/10/15
 * Time: 4:21 PM
 */?>

@extends('admin.adminLayout')

@section('content')

    @include('notification.notify')

    <div class="page">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form" action="{{route('addContributorsProcess')}}" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" id="regular1" name="first_name">
                            <label for="regular1">First Name</label>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="regular1" name="last_name">
                            <label for="regular1">Last Name</label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="regular1" name="username">
                            <label for="regular1">User Name</label>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="password1" name="email">
                            <label for="password1">Email</label>
                        </div>
                        <button type="submit" class="btn ink-reaction btn-raised btn-primary">Submit</button>
                    </form>
                </div><!--end .card-body -->
            </div><!--end .card -->

        </div>



    </div>
    </div>

    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large red">
            <i class="md md-person" style="font-size: 25px;line-height: 65px;"></i>
        </a>
        <ul>

            <li><a class="btn-floating yellow darken-1" href="{{route('adminModeratorManagement')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-visibility" style="line-height:40px;"></i></a></li>

            <li><a class="btn-floating blue" href="{{route('addModerate')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-add" style="line-height:40px;"></i></a></li>

        </ul>
    </div>
@stop