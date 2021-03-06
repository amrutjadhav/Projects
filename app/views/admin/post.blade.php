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
                        <header>{{ tr('posts') }}</header>
                    </div>
                <div class="card-body">
                    <ul class="pull-right">
                        <li>
                            <!-- Search form -->
                            <form class="navbar-search" role="search" action="{{route('adminPostSearch')}}">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="Enter The Author Name">
                                </div>
                                <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                            </form>
                        </li>
                    </ul>
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>{{ tr('admin_id')}} {{Auth::user()->id}}</th>
                            <th>{{ tr('title') }}</th>
                            <th>{{ tr('description')}}</th>
                            <th>{{ tr('time') }}</th>
                            <th>{{ tr('roles') }}</th>
                            <th>{{ tr('author_name') }}</th>
                            <th>{{ tr('admin_action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{$post->id}}</td>
                                <td>{{$post->title}}</td>
                                <td>{{substr($post->des, 0, 50)}}</td>
                                <td>{{$post->created_at->diffForHumans()}}</td>
                                <?php $user = User::where('id',$post->user_id)->first(); ?>
                                <td>
                                    <?php
                                        if($user)
                                        {
                                            if($user->role_id == 1)
                                            {
                                                echo "Moderator";
                                            }
                                            elseif($user->role_id == 3)
                                            {
                                                if($post->is_approved == 0){
                                                echo "Contributor<br> <em>(Waiting for Approval)</em>";}else{ echo "Contributor"; }
                                            }
                                            else
                                            {
                                                echo "Admin";
                                            }
                                        }
                                        else
                                        {
                                            echo "";
                                        }
                                    ?>
                                </td>
                                <td>{{{$post->author}}}</td>
                                <td style="width: 297px;">
                                    @if($post->is_approved != 0)
                                        <a title="Un Publish" class="btn ink-reaction btn-floating-action btn-warning" href="{{route('adminPostDecline', array('id' => $post->id))}}"><i class="fa fa-times"></i></a>
                                    @else
                                        <a title="Publish" class="btn ink-reaction btn-floating-action btn-primary" href="{{route('adminPostActivate', array('id' => $post->id))}}"><i class="fa fa-check"></i></a>
                                    @endif
                                    <!-- <a class="btn ink-reaction btn-floating-action btn-info" href="{{route('sendPush')}}"><i class="fa fa-paper-plane"></i></a> -->
                                    <!-- <a class="btn ink-reaction btn-floating-action btn-info" href="{{route('adminAddPost')}}"><i class="fa fa-plus"></i></a> -->
                                    <a title="Edit Post" class="btn ink-reaction btn-floating-action btn-info" href="{{route('adminEditPost', array('id' => $post->id))}}"><i class="fa fa-edit"></i></a>
                                    @if($post->is_approved ==1)
                                        <a target="_blank" title="View Post" class="btn ink-reaction btn-floating-action btn-info" href="{{route('adminViewPost', array('id' => $post->share_cat,'data' => $post->link))}}"><i class="fa fa-eye"></i></a>
                                    @else
                                        <a target="_blank" title="View Post" class="btn ink-reaction btn-floating-action btn-info" href="{{route('adminViewPost', array('id' => $post->share_cat,'data' => $post->link))}}" disabled><i class="fa fa-eye"></i></a>
                                    @endif
                                    @if($post->is_approved ==1)
                                        <a title="Send Push Notification" class="btn ink-reaction btn-floating-action btn-info" href="{{route('sendPush', array('id' => $post->id))}}"><i class="fa fa-paper-plane"></i></a>
                                    @else
                                        <a title="Send Push Notification" class="btn ink-reaction btn-floating-action btn-info" href="{{route('sendPush', array('id' => $post->id))}}" disabled><i class="fa fa-paper-plane"></i></a>
                                    @endif
                                    <a title="Delete" onclick="return confirm('Are you sure?')" class="btn ink-reaction btn-floating-action btn-danger" href="{{route('adminDeletePost',array('id' => $post->id))}}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div align="right" id="paglink"><?php echo $posts->links(); ?></div>
                </div><!--end .card-body -->
            </div><!--end .card -->

        </div>
    </div>


    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large red">
            <i class="md md-star" style="font-size: 25px;line-height: 65px;"></i>
        </a>
        <ul>
            <li><a class="btn-floating blue" href="{{route('adminAddPost')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-add" style="line-height:40px;"></i></a></li>

        </ul>
    </div>

@stop