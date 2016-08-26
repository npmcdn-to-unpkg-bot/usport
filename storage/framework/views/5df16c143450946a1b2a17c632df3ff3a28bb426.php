<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo gravatarUrl(Sentinel::getUser()->email); ?>" class="img-circle" alt="User Image" />

            </div>
            <div class="pull-left info">
                <p><?php echo e((Sentinel::getUser()->name == 'NULL')?Sentinel::getUser()->email:Sentinel::getUser()->name); ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="<?php echo e(setActive('admin')); ?>"><a href="<?php echo e(url('/admin')); ?>"> <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a></li>
            <li class="treeview <?php echo e(setActive('admin/category*')); ?>"><a href="#"> <i class="fa fa-th"></i> <span>Category</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('/admin/category')); ?>"><i class="fa fa-calendar"></i> All Categories</a>
                    </li>
                    <li><a href="<?php echo e(url('/admin/category/create')); ?>"><i class="fa fa-plus-square"></i> Add Category</a>
                    </li>
                </ul>
            </li>
            <li class="treeview <?php echo e(setActive('admin/post*')); ?>"><a href="#"> <i class="fa fa-book"></i> <span>Posts</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('/admin/post')); ?>"><i class="fa fa-archive"></i> All Posts</a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('/admin/post/create')); ?>"><i class="fa fa-plus-square"></i> Add Post</a>
                    </li>
                </ul>
            </li>
            <li class="treeview <?php echo e(setActive(['admin/user*', 'admin/group*'])); ?>"><a href="#"> <i class="fa fa-user"></i> <span>Users</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(url('/admin/user')); ?>"><i class="fa fa-user"></i> All Users</a>
                    </li>
                    <li><a href="<?php echo e(url('/admin/role')); ?>"><i class="fa fa-group"></i> Add Role</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo e(setActive('admin/logout*')); ?>">
                <a href="<?php echo e(url('/admin/logout')); ?>"> <i class="fa fa-sign-out"></i> <span>Logout</span> </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>