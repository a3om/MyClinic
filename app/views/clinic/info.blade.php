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
		resize:{cssclass: 'resize'}
	});
	$('.te').css({'width': '100%', 'margin': '0', 'border-radius': '3px'});
	@if (!$canEditInfo)
		$('.teheader').css('display', 'none');
	@endif
	$('.te iframe').css('width', '100%');
	$('.ui.submit').click(function() {
		editor.post();
		$('.ui.form').submit();
	});
	$('.language').dropdown('set selected', '{{ Input::old('language', $clinic->language) }}');
});
</script>
@stop
@section('content')
<h3 class="ui top attached header">
  <div class="ui breadcrumb">
    <div class="active section">{{ trans('main.information') }}</div>
  </div>
</h3>
<form class="ui success error form attached segment" action="/clinic/info" method="post" enctype="multipart/form-data">
	@if(Session::has('success'))
	<div class="ui success message">
		<div class="header">
		  {{ trans('main.editing') }}
		</div>
	<p>{{ trans('main.dataWereSavedSuccessfuly') }}</p>
	</div>
	@endif
	<div class="two fields">
		<div class="{{ $errors->has('logo') ? 'error ' : '' }}field">
			<label>{{ trans('main.logo') }}</label>
			@if ($canEditInfo)
			<label for="logo" style="cursor: pointer;">
			  <img alt="" style="border: 1px solid #ddd; border-radius: 3px; height: 100px;" id="logo-image" src="/logo.png" />
			</label>
			<input type="file" name="logo" style="display: none;" id="logo" />
			@else
			<img alt="" style="border: 1px solid #ddd; border-radius: 3px; height: 100px;" id="logo-image" src="/logo.png" />
			@endif
			@if($errors->has('logo'))
			<div class="ui red pointing label">
			  {{ $errors->first('logo') }}
			</div>
			@endif
		</div>
		<div class="{{ $errors->has('photo') ? 'error ' : '' }}field">
			<label>{{ trans('main.photo') }}</label>
			@if ($canEditInfo)
			<label for="photo" style="cursor: pointer;">
			  <img alt="" style="border: 1px solid #ddd; border-radius: 3px; height: 100px;" id="photo-image" src="/photo.jpg" />
			</label>
			<input type="file" name="photo" style="display: none;" id="photo" />
			@else
			<img alt="" style="border: 1px solid #ddd; border-radius: 3px; height: 100px;" id="photo-image" src="/photo.jpg" />
			@endif
			@if($errors->has('photo'))
			<div class="ui red pointing label">
			  {{ $errors->first('photo') }}
			</div>
			@endif
		</div>
	</div>
	<div class="two fields">
		<div class="two wide field">
			<label>{{ trans('main.clinicId') }}</label>
			<input value="{{ $clinic->id }}" readonly />
			</div>
		<div class="seven wide field">
			<label>{{ trans('main.clinicName') }}</label>
			<input value="{{ $clinic->name }}" name="name"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
		<div class="seven wide field">
			<label>{{ trans('main.clinicNameInPrepositional') }}</label>
			<input value="{{ $clinic->name_prepositional }}" name="name_prepositional"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
	</div>
	<div class="four fields">
		<div class="field">
			<label>{{ trans('main.email') }}</label>
			<input name="email" value="{{ $clinic->email }}"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
		<div class="field">
			<label>{{ trans('main.latitudeLocation') }}</label>
			<input name="latitude" value="{{ $clinic->latitude }}"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
		<div class="field">
			<label>{{ trans('main.longitudeLocation') }}</label>
			<input name="longitude" value="{{ $clinic->longitude }}"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
		<div class="field">
			<label>{{ trans('main.language') }}</label>
			<select class="ui language dropdown" name="language">
				<option value="">{{ trans('main.language') }}</option>
				<option value="ru">Русский</option>
				<option value="en">English</option>
			</select>
		</div>
	</div>
	<div class="field">
		<label>{{ trans('main.address') }}</label>
		<input name="address" value="{{ $clinic->address }}"{{ $canEditInfo ? '' : ' readonly' }} />
	</div>
	<div class="five fields">
		<div class="field">
			<label>{{ trans('main.phone') }} 1</label>
			<input name="phone1" value="{{ $clinic->phone1 }}"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
		<div class="field">
			<label>{{ trans('main.phone') }} 2</label>
			<input name="phone2" value="{{ $clinic->phone2 }}"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
		<div class="field">
			<label>{{ trans('main.phone') }} 3</label>
			<input name="phone3" value="{{ $clinic->phone3 }}"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
		<div class="field">
			<label>{{ trans('main.workingTimeFrom') }} 3</label>
			<input name="workingTimeFrom" value="{{ $clinic->working_time_from->format('H:i') }}"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
		<div class="field">
			<label>{{ trans('main.workingTimeTo') }} 3</label>
			<input name="workingTimeTo" value="{{ $clinic->working_time_to->format('H:i') }}"{{ $canEditInfo ? '' : ' readonly' }} />
		</div>
	</div>
	<div class="field">
		<label>{{ trans('main.description') }}</label>
		<textarea name="description" id="wysiwyg">{{ $clinic->description }}</textarea>
	</div>
	@if ($canEditInfo)
	<div class="ui submit button">{{ trans('main.save') }}</div>
	@endif
</form>
@stop