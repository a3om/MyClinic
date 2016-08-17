@extends('clinic')
@section('head')
<link rel="stylesheet" href="/tinyeditor/tinyeditor.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="/tinyeditor/tinyeditor.js"></script>
<script type="text/javascript">
$(function() {
	new TINY.editor.edit('editor', {
		id: 'wysiwyg',
		// width: 584,
		// height: 175,
		cssclass: 'te',
		controlclass: 'tecontrol',
		rowclass: 'teheader',
		dividerclass: 'tedivider',
		controls: ['bold','italic','underline','strikethrough','|','subscript','superscript','|',
		      'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
		      'centeralign','rightalign','blockjustify','|','unformat','|','hr','|','undo','redo'],
		// footer: true,
		fonts: ['Verdana', 'Arial', 'Georgia', 'Trebuchet MS'],
		// xhtml:true,
		cssfile: '/tinyeditor/tinyeditor.css',
		bodyid: 'editor',
		// footerclass: 'tefooter',
		// toggle:{text: 'source', activetext: 'wysiwyg', cssclass: 'toggle'},
		resize:{cssclass: 'resize'}
	});
	$('.te').css({'width': '100%', 'margin': '0', 'border-radius': '3px'});
	$('.te iframe').css('width', '100%');
	$('.ui.submit').click(function() {
		editor.post();
		$('.ui.form').submit();
	});
});
</script>
@stop
@section('sidebar')
<a class="item" href="/clinic/news/add">
  <i class="browser icon"></i> {{ trans('main.addNews') }}
</a>
@stop
@section('content')
<h3 class="ui top attached header">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/news">{{ trans('main.news') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ $tiding->title }}</div>
  </div>
</h3>
<form class="ui success error form bottom attached segment" action="/clinic/news/{{ $tiding->id }}" method="post">
	@if(Session::has('success'))
	<div class="ui success message">
		<div class="header">
		  {{ trans('main.editing') }}
		</div>
		<p>{{ trans('main.dataWereSavedSuccessfuly') }}</p>
	</div>
	@endif
	<div class="{{ $errors->has('title') ? 'error ' : '' }}field">
		<label>{{ trans('main.title') }}</label>
		<input placeholder="{{ trans('main.title') }}" type="text" name="title" value="{{ Input::old('title', $tiding->title) }}">
		@if($errors->has('title'))
		<div class="ui red pointing label">
		  {{ $errors->first('title') }}
		</div>
		@endif
	</div>
	<div class="field">
		<label>{{ trans('main.text') }}</label>
		<textarea name="text" id="wysiwyg">{{ Input::old('text', $tiding->text) }}</textarea>
	</div>
	<div class="ui submit button">{{ trans('main.save') }}</div>
</form>
@stop