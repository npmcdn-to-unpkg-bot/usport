
<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1> Post
        <small> | Delete Post</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo langRoute('admin.post.index'); ?>"><i class="fa fa-book"></i> Post</a></li>
        <li class="active">Delete Post</li>
    </ol>
</section>
<br>
<br>
<br>
<div class="col-lg-10">
    <?php echo Form::open( array(  'route' => array(getLang(). 'admin.post.destroy', $post->id ) ) ); ?>

    <?php echo Form::hidden( '_method', 'DELETE' ); ?>

    <div class="alert alert-warning">
        <div class="pull-left"><b> Be Careful!</b> Are you sure you want to delete <b><?php echo $post->title; ?> </b> ?
        </div>
        <div class="pull-right">
            <?php echo Form::submit( 'Yes', array( 'class' => 'btn btn-danger' ) ); ?>

            <?php echo link_to( URL::previous(), 'No', array( 'class' => 'btn btn-primary' ) ); ?>

        </div>
        <div class="clearfix"></div>
    </div>
    <?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend/layout/layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>