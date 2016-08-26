
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
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Post <small> | Publish Post</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo url(getLang() . '/admin/post'); ?>"><i class="fa fa-book"></i> Post</a></li>
        <li class="active">Update Post</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    <?php if(isset($authUrl)): ?>
        <a href="<?php echo e($authUrl); ?>" class="btn btn-primary">Bạn cần tạo mới 1 access_token</a>
    <?php elseif(isset($youtubeVideo)): ?>
        <p>Bài viết này đã được đẩy lên youtube</p>
        <p><iframe width="420" height="315" src="<?php echo e($youtubeVideo); ?>" frameborder="0" allowfullscreen></iframe></p>

        <a href="postfacebook" title="" class="btn btn-primary">Post to the facebook</a>
    <?php elseif(isset($accessToken)): ?>
        <?php echo Form::open( array( 'route' => array('admin.post.uploadyoutube'), 'method' => 'POST', 'files'=>true)); ?>


            <?php echo e(Form::hidden('id', $post->id, array('class' => 'form-control'))); ?>

            <div class="form-group<?php echo e($errors->has('title') ? ' has-error' : ''); ?>">

                <?php echo e(Form::label('title', 'title', array('class' => 'control-label'))); ?>


                <?php echo e(Form::text('title', $post->title, array('class' => 'form-control', 'placeholder' => 'title'))); ?>


                <?php if($errors->has('title')): ?>
                    <span class="help-block"><?php echo e($errors->first('title')); ?></span>
                <?php endif; ?>

            </div>

            <div class="form-group<?php echo e($errors->has('description') ? ' has-error' : ''); ?>">

                <?php echo e(Form::label('description', 'description', array('class' => 'control-label'))); ?>


                <?php echo e(Form::textarea('description', $post->content, array('class' => 'form-control', 'placeholder' => 'description'))); ?>


                <?php if($errors->has('description')): ?>
                    <span class="help-block"><?php echo e($errors->first('description')); ?></span>
                <?php endif; ?>

            </div>

            <div class="form-group<?php echo e($errors->has('status') ? ' has-error' : ''); ?>">

                <?php echo e(Form::label('status', 'status', array('class' => 'control-label'))); ?>


                <?php echo e(Form::select('status', array('unlisted' => 'Unlisted', 'public' => 'Public', 'unlisted' => 'Unlisted', 'private' => 'Private'), Input::old('status'))); ?>


                <?php if($errors->has('status')): ?>
                    <span class="help-block"><?php echo e($errors->first('status')); ?></span>
                <?php endif; ?>

            </div>

            <div class="form-group<?php echo e($errors->has('video') ? ' has-error' : ''); ?>">

                <?php echo e(Form::label('video', 'video', array('class' => 'control-label'))); ?>


                <?php echo e(Form::text('videoPath', $attachments->src, array('class' => 'form-control', 'placeholder' => 'video path'))); ?>


                <?php if($errors->has('video')): ?>
                    <span class="help-block"><?php echo e($errors->first('video')); ?></span>
                <?php endif; ?>

            </div>

            <?php echo e(Form::submit('Post video to youtube', array('class' => 'btn btn-primary'))); ?>


        <?php echo e(Form::close()); ?>

    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend/layout/layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>