<?php
/**
 * Created by PhpStorm.
 * User: aravinth
 * Date: 9/7/15
 * Time: 11:59 PM
 */
?>
@extends('admin.adminLayout')

@section('content')

@include('notification.notify')

<div class="page">

    <div class="col-md-12">
        <div class="card">
            <div class="card-head style-primary">
               <header>{{tr('edit_category') }}</header>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('editCategoryProcess', array('id' => $categoryDetails->id)) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="name" value="{{$categoryDetails->name}}">
                        <label for="regular1">{{tr('category_name')}}</label>
                    </div>

                    <div class="file-field input-field col s12">
                        <div class="tile-content">
                                <div class="tile-icon brand-logo">
                                    <img  src="{{$categoryDetails->pics}}" alt="">
                                </div>
                            </div>
                        <div class="btn light-blue accent-2" style="padding: 0px 10px;">
                            <span>{{tr('choose_picture')}}</span>
                            <input type="file" name="picture" />
                        </div>
                        <input class="file-path validate" type="text"/>

                    </div>

                    <button type="submit" class="btn ink-reaction btn-raised btn-info">
                        {{tr('admin_submit')}}
                    </button>
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
        <li><a class="btn-floating yellow darken-1" href="{{route('adminCategory')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-visibility" style="line-height:40px;"></i></a></li>

        <li><a class="btn-floating blue" href="{{route('addCategory')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-add" style="line-height:40px;"></i></a></li>

    </ul>
</div>
@stop