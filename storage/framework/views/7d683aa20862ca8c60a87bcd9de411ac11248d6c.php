<?php $__env->startSection('content'); ?>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#notification').show().delay(4000).fadeOut(700);

            // publish settings
            $(".publish").bind("click", function (e) {
                var id = $(this).attr('id');
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "<?php echo url(getLang() . '/admin/post/" + id + "/toggle-publish/'); ?>",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    success: function (response) {
                        if (response['result'] == 'success') {
                            var imagePath = (response['changed'] == 1) ? "<?php echo url('/'); ?>/assets/images/publish.png" : "<?php echo url('/'); ?>/assets/images/not_publish.png";
                            $("#publish-image-" + id).attr('src', imagePath);
                        }
                    },
                    error: function () {
                        alert("error");
                    }
                })
            });
        });
    </script>
    <section class="content-header">
        <h1> Post
            <small> | Control Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo url(getLang() . '/admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Post</li>
        </ol>
    </section>
    <br>

    <div class="container">
        <div class="col-lg-10">
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <br>

            <div class="pull-left">
                <div class="btn-toolbar">
                    <a href="<?php echo langRoute('admin.post.create'); ?>" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add Post </a>
                    <a href="<?php echo langRoute('admin.category.create'); ?>" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add Category </a>
                </div>
            </div>
            <br> <br> <br>
            <?php if($posts->count()): ?>
                <div class="">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>User</th>
                            <!-- <th>Category</th> -->
                            <th>Updated Date</th>
                            <th>Action</th>
                            <!-- <th>Publish</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach( $posts as $post ): ?>
                            <tr>
                                <td>
                                    <a href="#" class="btn btn-link btn-xs">
                                        <?php echo subwords(strip_tags($post->content), 10); ?></a>
                                </td>
                                <td><?php echo $post->display_name; ?></td>
                                <!-- <td><?php echo $post->category_name; ?></td> -->
                                <td><?php echo $post->updated_at; ?></td>
                                <td>
                                    <a href="<?php echo langRoute('admin.post.edit', array($post->id)); ?>">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a>
                                    <a href="<?php echo URL::route('admin.post.delete', array($post->id)); ?>">
                                                    <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Delete</a>
                                    <a href="<?php echo URL::route('admin.post.publish', array($post->id)); ?>">
                                        <img id="publish-image-<?php echo $post->id; ?>" src="<?php echo url('/'); ?>/assets/images/<?php echo ($post->fb_post_id) ? 'publish.png' : 'not_publish.png'; ?>"/>&nbsp;Publish</a>
                                </td>
                                <!-- <td>
                                    <a href="#" id="<?php echo $post->id; ?>" class="publish">
                                        <img id="publish-image-<?php echo $post->id; ?>" src="<?php echo url('/'); ?>/assets/images/<?php echo ($post->is_published) ? 'publish.png' : 'not_publish.png'; ?>"/>
                                    </a>
                                </td> -->
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
                <?php echo $posts->render(); ?>

            </ul>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend/layout/layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>