
<?php $__env->startSection('content'); ?>
<?php echo HTML::style('assets/bootstrap/css/bootstrap-tagsinput.css'); ?>

<?php echo HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css'); ?>

<?php echo HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js'); ?>

<?php echo HTML::script('ckeditor/ckeditor.js'); ?>

<?php echo HTML::script('assets/bootstrap/js/bootstrap-tagsinput.js'); ?>

<?php echo HTML::script('assets/js/jquery.slug.js'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#title").slug();

        if ($('#tag').length != 0) {
            var elt = $('#tag');
            elt.tagsinput();
        }
    });
</script>
<script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '290323457998704',
          xfbml      : true,
          version    : 'v2.7'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));


        function loginFB() {
            FB.login(function(response) {
                if (response.authResponse) {
                    var access_token = FB.getAuthResponse()['accessToken'];
                    $.get("https://graph.facebook.com/me/accounts?access_token=" + access_token, function(data, status){
                        if (status == 'success') {
                            $.each(data.data, function(index, val) {
                                if (val.id == <?=config('cc.facebook_api.fanpage_id')?>) {//'583524488486094') {
                                    $('input#page_access_token').val(val.access_token);
                                }
                                console.log(index + ':' + val.id);
                            });
                        }
                    });
                } else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, {
                scope: 'publish_actions,publish_pages', 
                return_scopes: true
            });
        }
    </script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Post <small> | Post to facebook</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo url(getLang() . '/admin/post'); ?>"><i class="fa fa-book"></i> Post</a></li>
        <li class="active">Facebook Post</li>
    </ol>
</section>
<br>
<br>
<div class="container">
<p><iframe width="420" height="315" src="http://youtube.com/watch?v=<?php echo e($post->youtube_id); ?>" frameborder="0" allowfullscreen></iframe></p>
<?php if($post->fb_post_id): ?>
        <p> bài này đã có trên fb</p>
<?php else: ?>
    <button id="btb" class="btn btn-primary" onclick="loginFB()">Lấy Access_token của trang</button>
    <br />
    <?php echo Form::open( array('method' => 'POST', 'enctype'=>'multipart/form-data')); ?>

    <!-- <?php echo e(Form::hidden('id', $post->id, array('class' => 'form-control'))); ?> -->
            <div class="form-group<?php echo e($errors->has('title') ? ' has-error' : ''); ?>">

                <?php echo e(Form::label('name', 'name', array('class' => 'control-label'))); ?>


                <?php echo e(Form::text('name', $post->title, array('class' => 'form-control', 'placeholder' => 'name'))); ?>


                <?php if($errors->has('title')): ?>
                    <span class="help-block"><?php echo e($errors->first('title')); ?></span>
                <?php endif; ?>

            </div>

            <div class="form-group<?php echo e($errors->has('description') ? ' has-error' : ''); ?>">

                <?php echo e(Form::label('description', 'description', array('class' => 'control-label'))); ?>


                <?php echo e(Form::textarea('message', $post->content, array('class' => 'form-control', 'placeholder' => 'description'))); ?>


                <?php if($errors->has('description')): ?>
                    <span class="help-block"><?php echo e($errors->first('description')); ?></span>
                <?php endif; ?>

            </div>

            <div class="form-group<?php echo e($errors->has('link') ? ' has-error' : ''); ?>">

                <?php echo e(Form::label('Youtube video', 'youtube video', array('class' => 'control-label'))); ?>


                <?php echo e(Form::text('link', 'https://www.youtube.com/watch?v=' . $post->youtube_id, array('class' => 'form-control', 'placeholder' => 'youtube link'))); ?>


                <?php if($errors->has('youtube_id')): ?>
                    <span class="help-block"><?php echo e($errors->first('youtube_id')); ?></span>
                <?php endif; ?>

            </div>

            <div class="form-group<?php echo e($errors->has('access_token') ? ' has-error' : ''); ?>">

                <?php echo e(Form::label('page access_token', 'page token', array('class' => 'control-label'))); ?>


                <?php echo e(Form::text('access_token', null, array('id' => 'page_access_token', 'class' => 'form-control', 'placeholder' => 'The page access token'))); ?>


                <?php if($errors->has('access_token')): ?>
                    <span class="help-block"><?php echo e($errors->first('access_token')); ?></span>
                <?php endif; ?>

            </div>

            <?php echo e(Form::submit('Post to facebook', array('class' => 'btn btn-primary'))); ?>


        <?php echo e(Form::close()); ?>

<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend/layout/layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>