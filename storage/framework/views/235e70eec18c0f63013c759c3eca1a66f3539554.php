
<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Category
        <small> | Add Category</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo url(getLang(). '/admin/category'); ?>"><i class="fa fa-list"></i> Category</a></li>
        <li class="active">Add Category</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    <?php echo Form::open(array('action' => '\App\Http\Controllers\Admin\CategoryController@store' )); ?>

    <!-- Title -->
    <div class="control-group <?php echo $errors->has('name') ? 'has-error' : ''; ?>">
        <label class="control-label" for="name">Category</label>

        <div class="controls">
            <?php echo Form::text('name', null, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Category', 'value'=>Input::old('name'))); ?>

            <?php if($errors->first('name')): ?>
            <span class="help-block"><?php echo $errors->first('name'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>
    <!-- Form actions -->
    <?php echo Form::submit('Save Changes', array('class' => 'btn btn-success')); ?>

    <a href="<?php echo langUrl('/admin/category'); ?>" class="btn btn-default">&nbsp;Cancel</a>
    <?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend/layout/layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>