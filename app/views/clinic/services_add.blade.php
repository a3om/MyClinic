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
    resize: {cssclass: 'resize'},
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
    <a class="section" href="/clinic/services">{{ trans('main.services') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.addingOfNewService') }}</div>
  </div>
</h3>
<form class="ui error form attached segment" action="/clinic/services/add" method="post">
  <div class="{{ $errors->has('name') ? 'error ' : '' }}field">
    <label>{{ trans('main.name') }}</label>
    <input name="name" placeholder="{{ trans('main.enterName') }}" type="text" value="{{ Input::old('name') }}">
    @if($errors->has('name'))
    <div class="ui red pointing label">
      {{ $errors->first('name') }}
    </div>
    @endif
  </div>
  <div class="{{ $errors->has('description') ? 'error ' : '' }}field">
    <label>{{ trans('main.description') }}</label>
    <textarea name="description" id="wysiwyg">{{ Input::old('description') }}</textarea>
    @if($errors->has('description'))
    <div class="ui red pointing label">
      {{ $errors->first('description') }}
    </div>
    @endif
  </div>
  <div class="ui submit button">{{ trans('main.add') }}</div>
</form>
@stop