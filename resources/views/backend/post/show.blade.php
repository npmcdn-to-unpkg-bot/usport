@extends('backend/layout/layout')
@section('content')
{!! HTML::style('ckeditor/contents.css') !!}
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Post
        <small> | Show Post</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.post.index') !!}"><i class="fa fa-book"></i> Post</a></li>
        <li class="active">Show Post</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="col-lg-10">
        <div class="pull-left">
            <div class="btn-toolbar">
                <a href="{!! langRoute('admin.post.index') !!}"
                   class="btn btn-primary"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back </a>
            </div>
        </div>
        <br> <br> <br>
        <table class="table table-striped">
            <tbody>
            <tr>
                <td><strong>Title</strong></td>
                <td>{!! $post->title !!}</td>
            </tr>
            <tr>
                <td><strong>Slug</strong></td>
                <td>{!! $post->slug !!}</td>
            </tr>
            <tr>
                <td><strong>Category</strong></td>
                <td>{!! $post->category[0]->title !!}</td>
            </tr>
            <tr>
                <td><strong>Date Created</strong></td>
                <td>{!! $post->created_at !!}</td>
            </tr>
            <tr>
                <td><strong>Date Updated</strong></td>
                <td>{!! $post->updated_at !!}</td>
            </tr>
            <tr>
                <td><strong>Meta Keywords</strong></td>
                <td>{!! $post->meta_keywords !!}</td>
            </tr>
            <tr>
                <td><strong>Meta Description</strong></td>
                <td>{!! $post->meta_description !!}</td>
            </tr>
            <tr>
                <td><strong>Published</strong></td>
                <td>{!! $post->is_published !!}</td>
            </tr>
            <tr>
                <td><strong>Tag</strong></td>
                <td>
                    @foreach($post->tags as $tag)
                        {!! $tag->name !!},
                    @endforeach
                </td>
            </tr>
            <tr>
                <td><strong>Content</strong></td>
                <td>{!! $post->content !!}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@stop
