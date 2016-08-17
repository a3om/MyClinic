@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  $('.ui.submit').click(function() {
    $('.ui.form').submit();
  });
});
</script>
@stop
@section('content')
<h3 class="ui top attached header">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/specialities">{{ trans('main.specialities') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.addingOfNewSpeciality') }}</div>
  </div>
</h3>
<form class="ui error form attached segment" action="/clinic/specialities/add" method="post">
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
    <textarea name="description">{{ Input::old('description') }}</textarea>
    @if($errors->has('description'))
    <div class="ui red pointing label">
      {{ $errors->first('description') }}
    </div>
    @endif
  </div>
  <div class="ui submit button">{{ trans('main.add') }}</div>
</form>
@stop