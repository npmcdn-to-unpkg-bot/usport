
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> User
        <small> | Update User</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo url(getLang(). '/admin/user'); ?>"><i class="fa fa-user"></i> User</a></li>
        <li class="active">Update User</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    <?php echo Form::open( array( 'route' => array(getLang(). 'admin.user.update', $user->id), 'method' => 'PATCH')); ?>

    <!-- First Name -->
    <div class="control-group <?php echo $errors->has('first-name') ? 'has-error' : ''; ?>">
        <label class="control-label" for="first-name">First Name</label>

        <div class="controls">
            <?php echo Form::text('first_name', $user->first_name, array('class'=>'form-control', 'id' => 'first_name', 'placeholder'=>'First Name', 'value'=>Input::old('first_name'))); ?>

            <?php if($errors->first('first-name')): ?>
            <span class="help-block"><?php echo $errors->first('first-name'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>
    <!-- Last Name -->
    <div class="control-group <?php echo $errors->has('last-name') ? 'has-error' : ''; ?>">
        <label class="control-label" for="last-name">Last Name</label>

        <div class="controls">
            <?php echo Form::text('last_name', $user->last_name, array('class'=>'form-control', 'id' => 'last_name', 'placeholder'=>'Last Name', 'value'=>Input::old('last_name'))); ?>

            <?php if($errors->first('last-name')): ?>
            <span class="help-block"><?php echo $errors->first('last-name'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>
    <!-- Email -->
    <div class="control-group <?php echo $errors->has('email') ? 'has-error' : ''; ?>">
        <label class="control-label" for="email">Email</label>

        <div class="controls">
            <?php echo Form::text('email', $user->email, array('class'=>'form-control', 'id' => 'email', 'placeholder'=>'Email', 'value'=>Input::old('email'))); ?>

            <?php if($errors->first('email')): ?>
            <span class="help-block"><?php echo $errors->first('email'); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <!-- Role -->
    <div class="control-group <?php echo $errors->has('is_published') ? 'has-error' : ''; ?>">
        <label class="control-label" for="groups">Roles</label>
        <div class="controls">

            <?php foreach($roles as $id=>$role): ?>
            <label><input <?php echo ((in_array($role, $userRoles)) ? 'checked' : ''); ?> type="checkbox" value="<?php echo $id; ?>" name="groups[<?php echo $role; ?>]">  <?php echo $role; ?></label>
            <?php endforeach; ?>

        </div>
    </div>
    <br>

    <!-- Form actions -->
    <?php echo Form::submit('Save Changes', array('class' => 'btn btn-success')); ?>

    <a href="<?php echo url(getLang() . '/admin/user'); ?>"
       class="btn btn-default">
        &nbsp;Cancel
    </a>
    <?php echo Form::close(); ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend/layout/layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>