@extends('backend/layout/layout')
@section('content')
{!! HTML::style('assets/bootstrap/css/bootstrap-tagsinput.css') !!}
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}
{!! HTML::script('ckeditor/ckeditor.js') !!}
{!! HTML::script('assets/bootstrap/js/bootstrap-tagsinput.js') !!}
{!! HTML::script('assets/js/jquery.slug.js') !!}
<script type="text/javascript">
    $(document).ready(function () {
        $("#title").slug();

        if ($('#tag').length != 0) {
            var elt = $('#tag');
            elt.tagsinput();
        }
    });
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Post <small> | Update Post</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang() . '/admin/post') !!}"><i class="fa fa-book"></i> Post</a></li>
        <li class="active">Update Post</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array('admin.post.update', $post->id), 'method' => 'PATCH', 'files'=>true)) !!}

    <!-- Type -->
    <!-- <div class="control-group {!! $errors->has('type') ? 'error' : '' !!}">
        <label class="control-label" for="title">Type</label>
    
        <div class="controls">
            {!! Form::select('type', array('text'=>'Text', 'image'=>'Image', 'video'=>'Video'), $post->type, array('class' => 'form-control', 'value'=>Input::old('type'))) !!}
            @if ($errors->first('type'))
            <span class="help-block">{!! $errors->first('type') !!}</span>
            @endif
        </div>
    </div>
    <br> -->

    <!-- Category -->
    <!-- <div class="control-group {!! $errors->has('category_id') ? 'error' : '' !!}">
        <label class="control-label" for="title">Category</label>
    
        <div class="controls">
            {!! Form::select('category_id', $categories, $post->category_id, array('class' => 'form-control', 'value'=>Input::old('category_id'))) !!}
            @if ($errors->first('category_id'))
            <span class="help-block">{!! $errors->first('category_id') !!}</span>
            @endif
        </div>
    </div>
    <br> -->

    <!-- Content -->
    <div class="control-group {!! $errors->has('content') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Caption</label>

        <div class="controls">
            {!! Form::textarea('content', $post->content, array('class'=>'form-control', 'id' => 'content', 'placeholder'=>'Input a caption', 'value'=>Input::old('content'))) !!}
            @if ($errors->first('content'))
            <span class="help-block">{!! $errors->first('content') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Attachment -->
    <div class="control-group {!! $errors->has('src') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Attachment Url</label>

        <div class="controls">
            {!! Form::text('src', $attachments->src, array('class'=>'form-control', 'id' => 'src', 'placeholder'=>'Http://', 'value'=>Input::old('src'))) !!}
            @if ($errors->first('src'))
            <span class="help-block">{!! $errors->first('src') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Tag -->
    <!-- <div class="control-group {!! $errors->has('tag') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Tag</label>
    
        <div class="controls">
            {!! Form::text('tag', $tags, array('class'=>'form-control', 'id' => 'tag', 'placeholder'=>'Tag', 'value'=>Input::old('tag'))) !!}
            @if ($errors->first('tag'))
            <span class="help-block">{!! $errors->first('tag') !!}</span>
            @endif
        </div>
    </div>
    <br> -->

    <!-- Source -->
    <!-- <div class="control-group {!! $errors->has('source') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Source</label>
    
        <div class="controls">
            {!! Form::text('source', $post->source, array('class'=>'form-control', 'id' => 'source', 'placeholder'=>'Sưu tầm', 'value'=>Input::old('source'))) !!}
            @if ($errors->first('source'))
            <span class="help-block">{!! $errors->first('source') !!}</span>
            @endif
        </div>
    </div> -->

    <!-- Published -->
    <div class="control-group {!! $errors->has('is_published') ? 'has-error' : '' !!}">

        <div class="controls">
            <label class="">{!! Form::checkbox('is_published', 'is_published',$post->is_published) !!} Publish ?</label>
            @if ($errors->first('is_published'))
            <span class="help-block">{!! $errors->first('is_published') !!}</span>
            @endif
        </div>
    </div>
    <br>
    {!! Form::submit('Update', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}
</div>
@stop