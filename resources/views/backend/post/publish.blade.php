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
    <h1> Post <small> | Publish Post</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang() . '/admin/post') !!}"><i class="fa fa-book"></i> Post</a></li>
        <li class="active">Update Post</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    @if (isset($authUrl))
        <a href="{{ $authUrl }}" class="btn btn-primary">Bạn cần tạo mới 1 access_token</a>
    @elseif (isset($youtubeVideo))
        <p>Bài viết này đã được đẩy lên youtube</p>
        <p><iframe width="420" height="315" src="{{ $youtubeVideo }}" frameborder="0" allowfullscreen></iframe></p>

        <a href="postfacebook" title="" class="btn btn-primary">Post to the facebook</a>
    @elseif (isset($accessToken))
        {!! Form::open( array( 'route' => array('admin.post.uploadyoutube'), 'method' => 'POST', 'files'=>true)) !!}

            {{ Form::hidden('id', $post->id, array('class' => 'form-control')) }}
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">

                {{ Form::label('title', 'title', array('class' => 'control-label')) }}

                {{ Form::text('title', $post->title, array('class' => 'form-control', 'placeholder' => 'title')) }}

                @if ($errors->has('title'))
                    <span class="help-block">{{ $errors->first('title') }}</span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                {{ Form::label('description', 'description', array('class' => 'control-label')) }}

                {{ Form::textarea('description', $post->content, array('class' => 'form-control', 'placeholder' => 'description')) }}

                @if ($errors->has('description'))
                    <span class="help-block">{{ $errors->first('description') }}</span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">

                {{ Form::label('status', 'status', array('class' => 'control-label')) }}

                {{ Form::select('status', array('unlisted' => 'Unlisted', 'public' => 'Public', 'unlisted' => 'Unlisted', 'private' => 'Private'), Input::old('status')) }}

                @if ($errors->has('status'))
                    <span class="help-block">{{ $errors->first('status') }}</span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('video') ? ' has-error' : '' }}">

                {{ Form::label('video', 'video', array('class' => 'control-label')) }}

                {{ Form::text('videoPath', $attachments->src, array('class' => 'form-control', 'placeholder' => 'video path')) }}

                @if ($errors->has('video'))
                    <span class="help-block">{{ $errors->first('video') }}</span>
                @endif

            </div>

            {{ Form::submit('Post video to youtube', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}
    @endif
</div>
@stop