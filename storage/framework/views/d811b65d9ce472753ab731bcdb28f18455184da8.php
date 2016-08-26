
<?php $__env->startSection('content'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#notification').show().delay(4000).fadeOut(700);
        });
    </script>
    <section class="content-header">
        <h1> Role
            <small> | Control Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo url(getLang(). '/admin/role'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Role</li>
        </ol>
    </section>
    <br>
    <div class="container">
        <div class="col-lg-10">
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <br>

            <div class="pull-left">
                <div class="btn-toolbar">
                    <a href="<?php echo langRoute('admin.role.create'); ?>" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;New Role </a>
                </div>
            </div>
            <br> <br> <br>
            <?php if($roles->count()): ?>
                <div class="">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach( $roles as $role ): ?>
                            <tr>
                                <td> <?php echo link_to_route(getLang(). 'admin.role.show', $role->name, $role->id, array(
                                    'class' => 'btn btn-link btn-xs' )); ?>

                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                            Action <span class="caret"></span> </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo langRoute('admin.role.show', array($role->id)); ?>">
                                                    <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Show User
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo langRoute('admin.role.edit', array($role->id)); ?>">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit Role </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="<?php echo URL::route('admin.role.delete', array($role->id)); ?>">
                                                    <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Delete
                                                    Role </a>
                                            </li>
                                        </ul>
                                    </div>
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
                <?php echo $roles->render(); ?>

            </ul>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend/layout/layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>