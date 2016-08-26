
<?php $__env->startSection('content'); ?>
<?php echo HTML::style('assets/bootstrap/css/bootstrap-tagsinput.css'); ?>

<?php echo HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css'); ?>

<?php echo HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js'); ?>

<!-- <?php echo HTML::script('ckeditor/ckeditor.js'); ?> -->
<?php echo HTML::script('assets/bootstrap/js/bootstrap-tagsinput.js'); ?>

<?php echo HTML::script('assets/js/jquery.slug.js'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#title").slug();
    });
</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Post <small> | Add Post</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo url('/admin/post'); ?>"><i class="fa fa-book"></i> Post</a></li>
        <li class="active">Add Post</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    <?php echo Form::open(array('action' => '\App\Http\Controllers\Admin\PostController@store', 'files'=>true)); ?>


    <!-- Type -->
    <div class="control-group <?php echo $errors->has('type') ? 'error' : ''; ?>">
        <label class="control-label" for="title">Type</label>

        <div class="controls">
            <?php echo Form::select('type', array('text'=>'Text', 'image'=>'Image', 'video'=>'Video'), null, array('class' => 'form-control', 'value'=>Input::old('type'))); ?>

            <?php if($errors->first('type')): ?>
            <span class="help-block"><?php echo $errors->first('type'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <!-- Category -->
    <div class="control-group <?php echo $errors->has('category_id') ? 'error' : ''; ?>">
        <label class="control-label" for="title">Category</label>

        <div class="controls">
            <?php echo Form::select('category_id', $categories, null, array('class' => 'form-control', 'value'=>Input::old('category_id'))); ?>

            <?php if($errors->first('category_id')): ?>
            <span class="help-block"><?php echo $errors->first('category_id'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <!-- Content -->
    <div class="control-group <?php echo $errors->has('content') ? 'has-error' : ''; ?>">
        <label class="control-label" for="title">Content</label>

        <div class="controls">
            <?php echo Form::textarea('content', null, array('class'=>'form-control', 'id' => 'content', 'placeholder'=>'Content', 'value'=>Input::old('content'))); ?>

            <?php if($errors->first('content')): ?>
            <span class="help-block"><?php echo $errors->first('content'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <!-- Attachment -->
    <div class="control-group <?php echo $errors->has('src') ? 'has-error' : ''; ?>">
        <label class="control-label" for="title">Attachment Url</label>

        <div class="controls">
            <?php echo Form::text('src', null, array('class'=>'form-control', 'id' => 'src', 'placeholder'=>'Http://', 'value'=>Input::old('src'))); ?>

            <?php if($errors->first('src')): ?>
            <span class="help-block"><?php echo $errors->first('src'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <!-- Tag -->
    <div class="control-group <?php echo $errors->has('tag') ? 'has-error' : ''; ?>">
        <label class="control-label" for="title">Tag</label>

        <div class="controls">
            <?php echo Form::text('tag', null, array('class'=>'form-control', 'id' => 'tag', 'placeholder'=>'Tag', 'value'=>Input::old('tag'))); ?>

            <?php if($errors->first('tag')): ?>
            <span class="help-block"><?php echo $errors->first('tag'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <!-- Source -->
    <div class="control-group <?php echo $errors->has('source') ? 'has-error' : ''; ?>">
        <label class="control-label" for="title">Source</label>

        <div class="controls">
            <?php echo Form::text('source', null, array('class'=>'form-control', 'id' => 'source', 'placeholder'=>'Sưu tầm', 'value'=>Input::old('source'))); ?>

            <?php if($errors->first('source')): ?>
            <span class="help-block"><?php echo $errors->first('source'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <!-- Published -->
    <div class="control-group <?php echo $errors->has('is_published') ? 'has-error' : ''; ?>">

        <div class="controls">
            <label class=""><?php echo Form::checkbox('is_published', 'is_published'); ?> Publish ?</label>
            <?php if($errors->first('is_published')): ?>
            <span class="help-block"><?php echo $errors->first('is_published'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <?php echo Form::submit('Create', array('class' => 'btn btn-success')); ?>

    <?php echo Form::close(); ?>

    <script type="text/javascript">
        /*window.onload = function () {
            CKEDITOR.replace('content', {
                "filebrowserBrowseUrl": "<?php echo url('filemanager/show'); ?>",
                "height":100
            });
        };*/

        $(document).ready(function () {
            if ($('#tag').length != 0) {
                var elt = $('#tag');
                elt.tagsinput();
            }
        });
    </script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend/layout/layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>