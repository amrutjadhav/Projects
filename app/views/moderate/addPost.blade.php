<?php
/**
 * Created by PhpStorm.
 * User: aravinth
 * Date: 25/7/15
 * Time: 1:28 PM
 */
?>

@extends('moderate.moderateLayout')

@section('content')

@include('notification.notify')

<div class="page">

    <div class="col-md-8">
        <div class="card">
            <div class="card-head style-info">
               <header>{{tr('add_post')}}}</header>
            </div>
            <div class="card-body">
                <div class="text-right">
                    <a class="btn ink-reaction btn-raised btn-primary" href="{{route('moderatePost')}}">{{tr('back')}}</a>
                </div>
                <form class="form" action="{{route('moderateAddPostProcess')}}" id="autoform" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" >
                        <label for="title">{{tr('title')}}</label>
                    </div>


                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="publisher" >
                        <label for="regular1">{{tr('publisher')}}</label>
                    </div>
                    <input type="hidden" name="id" value="" id="post_id">

                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="url" >
                        <label for="regular1">{{tr('url')}}</label>
                    </div>
                    <div class="file-field input-field col s12">
                            
                        <div class="btn light-blue accent-2" style="padding: 0px 10px;">
                            <span>{{tr('choose_picture')}}</span>
                            <input type="file" name="post_img" />
                        </div>
                        <input class="file-path validate" type="text"/>

                    </div>

                    <div class="form-group">
                        <textarea name="des" id="textarea1" class="form-control" maxlength="450" rows="3"></textarea>
                        <label for="textarea1">{{tr('description')}}</label>
                    </div>

                    <div class="row">


                        <h4>{{tr('permalink')}}</h4>

                        <div class="form-group col-md-3 col-sm-4">

                            <h5>{{URL::to('/')}}</h5>

                        </div>

                        <div class="form-group floating-label col-md-4 col-sm-4" style="padding-left: 0px;">
                            <select id="cat_select" name="share_cat" class="form-control" required>
                                <option value="">{{tr('select_category')}}</option>
                                
                            </select>
                            <label for="cat_select">{{tr('select')}}</label>

                        </div>

                        <div class="form-group col-md-5 col-sm-4" style="padding-left: 0px;">

                            <input type="text" class="form-control" name="share_link" id="meta_title" >
                            <label for="meta_title">{{tr('permalink')}}</label>

                        </div>

                    </div>

                    <div class="form-group">

                        <input type="text" class="form-control" id="title_tag" name="title_tag" maxlength="70">
                        <label for="regular1">{{tr('title_tag')}}</label>
                        <div id="characterLeft"></div>

                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="meta_des" name="meta_des" >
                        <label for="regular1">{{tr('meta_description')}}</label>
                    </div>

            </div><!--end .card-body -->
        </div><!--end .card -->

    </div>

        <div class="col-md-4">
        <div class="card">
            <div class="card-body">

                <button type="submit" class="btn ink-reaction btn-raised btn-warning">{{tr('publish')}}</button>

                    <button type="button" id="draft_button" class="btn ink-reaction btn-raised btn-primary btn-loading-state" data-loading-text="<i class='fa fa-spinner fa-spin'></i> {{tr('saving_draft')}}...">{{tr('save_draft')}}</button>
                    <br><br>


                        <div class="input-group date" id="demo-date">
                                <div class="input-group-content">
                                     <input type="text" required class="form-control" name="pub_date" value="{{date('m/d/Y')}}">
                                    <label>{{tr('publish_date')}}</label>
                                </div>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>


                       <div class="form-group">
                            <input type="text" class="form-control time-mask" required id="pub" name="pub_time" value="{{{date('H:i')}}}">
                            <label for="pub">{{tr('publish_time')}}</label>
                        </div>
                        

                        <div class="form-group">
                            <input type="text" class="form-control" readonly required id="regular1" name="author" value="{{$details->author_name}}">
                            <label for="regular1">{{tr('author_name')}}</label>
                             @if($details->author_name=="")
                        <p class="help-block">Please Enter Your Author Name Under Menu->Account->Profile Action</p>
                        @endif
                        </div>

                        

                    <div class="input-field col s12 check-box-inline">
                        <?php foreach($category as $cat) {?>
                            <p> <input type="checkbox"  name="category[{{$cat->id}}]" value="{{$cat->id}}" next="{{$cat->name}}" id="cat_{{$cat->id}}" onchange="category_add('#cat_{{$cat->id}}')"/>
                                <label for="cat_{{$cat->id}}">{{$cat->name}}</label>
                            </p>
                        <?php } ?>
                        <br><br>
                    </div>

            </div><!--end .card-body -->
        </div><!--end .card -->

    </div>

</form>

</div>
</div>

<script src="{{asset('admins/js/libs/jquery/jquery-1.11.2.min.js')}}"></script>

<script type="text/javascript">
$('#characterLeft').text('70 characters left');
$('#title_tag').keyup(function () {
    var max = 70;
    var len = $(this).val().length;
    if (len >= max) {
        $('#characterLeft').text(' you have reached the limit');
    } else {
        var ch = max - len;
        $('#characterLeft').text(ch + ' characters left');
    }
});

</script>

    <script type="text/javascript">
    function category_add(id){
        if($(id).attr("checked")){
             var name = $(id).attr("next");
            var cat_value = $(id).val();
            var append_val = "<option value='"+ cat_value +"'>"+ name +"</option>";
            $('#cat_select').append(append_val);
            console.log(name);
        }else{
            console.log('un checked');
            var new_cal = $(id).val();
            $("#cat_select option[value='"+new_cal+"']").remove();
        }
    }

    $(document).ready(function(){
        $('#title').keyup(function(){
            $('#meta_title').val($('#title').val().replace(/\s+/g, '-').toLowerCase());
        });
    });

    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var typingTimer;                //timer identifier
            var doneTypingInterval = 2000;  //time in ms, 5 second for example
            var $input = $('.form-control');

            //on keyup, start the countdown
            $input.on('keyup', function () {
              clearTimeout(typingTimer);
              typingTimer = setTimeout(doneTyping, doneTypingInterval);
            });

            //on keydown, clear the countdown 
            $input.on('keydown', function () {
              clearTimeout(typingTimer);
            });

            function doneTyping () {
              //do something
            var route_url = "{{route('auto_save_form')}}";
            $('#draft_button').prop('disabled', false);
            $('#draft_button').text('Save Draft');

            // setInterval(function() {
                var form_data = $("#autoform").serialize();
                $('#draft_button').prop('disabled', true);
                $('#draft_button').html("<i class='fa fa-spinner fa-spin'></i> Saving Draft...");
                $.ajax({
                    type: 'POST',
                    data:  form_data,
                     cache: false,
                    url: route_url,
                    success: function(datas){
                        console.log(datas);
                        $('#post_id').val(datas.new_id);
                        setTimeout( function() {
                            $('#draft_button').prop('disabled', false);
                            $('#draft_button').text('Save Draft');
                        }, 2000);
                    }
                });
            // }, 10000);

            }

        });
    </script>
@stop





