@extends('clinic')
@section('head')
<link rel="stylesheet" href="/tinyeditor/tinyeditor.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="/tinyeditor/tinyeditor.js"></script>
<script type="text/javascript">
$(function() {
  var editor = new TINY.editor.edit('editor', {
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
    resize: {cssclass: 'resize'}
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
@section('content')
<h3 class="ui top attached header">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/news">{{ trans('main.news') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.additionOfNews') }}</div>
  </div>
</h3>
<form class="ui error form attached segment" action="/clinic/news/add" method="post">
  <div class="{{ $errors->has('title') ? 'error ' : '' }}field">
    <label>{{ trans('main.title') }}</label>
    <input name="title" placeholder="Введите заголовок" type="text" value="{{ Input::old('title') }}">
    @if($errors->has('title'))
    <div class="ui red pointing label">
      {{ $errors->first('title') }}
    </div>
    @endif
  </div>
  <div class="{{ $errors->has('text') ? 'error ' : '' }}field">
    <label>{{ trans('main.text') }}</label>
    <textarea name="text" id="wysiwyg"></textarea>
    @if($errors->has('text'))
    <div class="ui red pointing label">
      {{ $errors->first('text') }}
    </div>
    @endif
  </div>
  <div class="ui submit button">{{ trans('main.add') }}</div>
</form>
@stop