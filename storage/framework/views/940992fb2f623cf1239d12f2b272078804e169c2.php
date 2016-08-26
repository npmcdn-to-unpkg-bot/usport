
<?php $__env->startSection('content'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#notification').show().delay(4000).fadeOut(700);
        });
    </script>
    <section class="content-header">
        <h1> Category
            <small> | Control Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo url(getLang(). '/admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Category</li>
        </ol>
    </section>
    <br>
    <div class="container">
        <div class="col-lg-10">
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <br>

            <div class="pull-left">
                <div class="btn-toolbar"><a href="<?php echo langRoute('admin.category.create'); ?>" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add Category </a></div>
            </div>
            <br> <br> <br>
            <?php if($categories->count()): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach( $categories as $category ): ?>
                            <tr>
                                <td> <?php echo link_to_route( getLang() . 'admin.category.show', $category->name,
                                    $category->id, array( 'class' => 'btn btn-link btn-xs' )); ?>

                                </td>
                                <td>
                                    <a href="<?php echo langRoute('admin.category.edit', array($category->id)); ?>">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit
                                                </a> 
                                    <a href="<?php echo URL::route('admin.category.delete', array($category->id)); ?>">
                                        <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Delete
                                        </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">No results found</div>
            <?php endif; ?>
        </div>
        <div class="pull-left">
            <ul class="pagination">
                <?php echo $categories->render(); ?>

            </ul>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend/layout/layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>