<?php if(Session::has('message')): ?>
	<div class="alert">
		<?php echo e(session('message')); ?>

	</div>
<?php endif; ?>

<?php if(Session::has('youtubeVideoId')): ?>
	Last upload...<?php echo e(session('youtubeVideoId')); ?>

<?php endif; ?>

<?php if(isset($authUrl)): ?>
	<a href="<?php echo e($authUrl); ?>">Connect me</a>
<?php elseif(isset($accessToken)): ?>
	The access token has been added to your database: <b><?php echo e($accessToken); ?></b> now <a href="/admin/youtubeupload">try an upload</a>
<?php else: ?>
	<?php echo e(Form::open(array('url' => '/admin/youtubeupload', 'class' => 'form', 'files' => true))); ?>


		<div class="form-group<?php echo e($errors->has('title') ? ' has-error' : ''); ?>">

			<?php echo e(Form::label('title', 'title', array('class' => 'control-label'))); ?>


			<?php echo e(Form::text('title', Input::old('title'), array('class' => 'form-control', 'placeholder' => 'title'))); ?>


			<?php if($errors->has('title')): ?>
				<span class="help-block"><?php echo e($errors->first('title')); ?></span>
			<?php endif; ?>

		</div>

		<div class="form-group<?php echo e($errors->has('description') ? ' has-error' : ''); ?>">

			<?php echo e(Form::label('description', 'description', array('class' => 'control-label'))); ?>


			<?php echo e(Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'placeholder' => 'description'))); ?>


			<?php if($errors->has('description')): ?>
				<span class="help-block"><?php echo e($errors->first('description')); ?></span>
			<?php endif; ?>

		</div>

		<div class="form-group<?php echo e($errors->has('status') ? ' has-error' : ''); ?>">

			<?php echo e(Form::label('status', 'status', array('class' => 'control-label'))); ?>


			<?php echo e(Form::select('status', array('unlisted' => 'Unlisted', 'public' => 'Public', 'private' => 'Private'), Input::old('status'))); ?>


			<?php if($errors->has('status')): ?>
				<span class="help-block"><?php echo e($errors->first('status')); ?></span>
			<?php endif; ?>

		</div>

		<div class="form-group<?php echo e($errors->has('video') ? ' has-error' : ''); ?>">

			<?php echo e(Form::label('video', 'video', array('class' => 'control-label'))); ?>


			<?php echo e(Form::file('video', array('class' => 'form-control'))); ?>


			<?php if($errors->has('video')): ?>
				<span class="help-block"><?php echo e($errors->first('video')); ?></span>
			<?php endif; ?>

		</div>

		<?php echo e(Form::submit('Submit', array('class' => 'btn btn-default'))); ?>


	<?php echo e(Form::close()); ?>

<?php endif; ?>