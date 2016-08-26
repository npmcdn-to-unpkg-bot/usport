@extends('backend/layout/layout')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#notification').show().delay(4000).fadeOut(700);

            // publish settings
            $(".publish").bind("click", function (e) {
                var id = $(this).attr('id');
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{!! url(getLang() . '/admin/post/" + id + "/toggle-publish/') !!}",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    success: function (response) {
                        if (response['result'] == 'success') {
                            var imagePath = (response['changed'] == 1) ? "{!!url('/')!!}/assets/images/publish.png" : "{!!url('/')!!}/assets/images/not_publish.png";
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
            <li><a href="{!! url(getLang() . '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Post</li>
        </ol>
    </section>
    <br>

    <div class="container">
        <div class="col-lg-10">
            @include('flash::message')
            <br>

            <div class="pull-left">
                <div class="btn-toolbar">
                    <a href="{!! langRoute('admin.post.create') !!}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add Post </a>
                    <a href="{!! langRoute('admin.category.create') !!}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add Category </a>
                </div>
            </div>
            <br> <br> <br>
            @if($posts->count())
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
                        @foreach( $posts as $post )
                            <tr>
                                <td>
                                    <a href="#" class="btn btn-link btn-xs">
                                        {!! subwords(strip_tags($post->content), 10) !!}</a>
                                </td>
                                <td>{!! $post->display_name !!}</td>
                                <!-- <td>{!! $post->category_name !!}</td> -->
                                <td>{!! $post->updated_at !!}</td>
                                <td>
                                    <a href="{!! langRoute('admin.post.edit', array($post->id)) !!}">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a>
                                    <a href="{!! URL::route('admin.post.delete', array($post->id)) !!}">
                                                    <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Delete</a>
                                    <a href="{!! URL::route('admin.post.publish', array($post->id)) !!}">
                                        <img id="publish-image-{!! $post->id !!}" src="{!! url('/') !!}/assets/images/{!! ($post->fb_post_id) ? 'publish.png' : 'not_publish.png'  !!}"/>&nbsp;Publish</a>
                                </td>
                                <!-- <td>
                                    <a href="#" id="{!! $post->id !!}" class="publish">
                                        <img id="publish-image-{!! $post->id !!}" src="{!! url('/') !!}/assets/images/{!! ($post->is_published) ? 'publish.png' : 'not_publish.png'  !!}"/>
                                    </a>
                                </td> -->
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-danger">No results found</div>
            @endif
        </div>
        <div class="pull-left">
            <ul class="pagination">
                {!! $posts->render() !!}
            </ul>
        </div>
    </div>
@stop