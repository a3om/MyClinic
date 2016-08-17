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
    <a class="section" href="/clinic/managers">{{ trans('main.managers') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.additionOfManager') }}</div>
  </div>
</h3>
<form class="ui error form attached segment" action="/clinic/managers/add" method="post">
  <div class="{{ $errors->has('login') ? 'error ' : '' }}field">
    <label>{{ trans('main.login') }}</label>
    <input name="login" placeholder="{{ trans('main.enterLogin') }}" type="text" value="{{ Input::old('login') }}">
    @if($errors->has('login'))
    <div class="ui red pointing label">
      {{ $errors->first('login') }}
    </div>
    @endif
  </div>
  <div class="{{ $errors->has('password') ? 'error ' : '' }}field">
    <label>{{ trans('main.password') }}</label>
    <input name="password" placeholder="{{ trans('main.enterPassword') }}" type="text" value="{{ Input::old('password') }}">
    @if($errors->has('password'))
    <div class="ui red pointing label">
      {{ $errors->first('password') }}
    </div>
    @endif
  </div>
  <div class="inline field">
    <div class="ui checkbox">
      <input type="checkbox" name="delete_client"{{ Input::old('delete_client') ? ' checked' : '' }} />
      <label>{{ trans('main.canRemoveClients') }}</label>
    </div>
  </div>
  <div class="inline field">
    <div class="ui checkbox">
      <input type="checkbox" name="edit_clinic_info"{{ Input::old('edit_clinic_info') ? ' checked' : '' }} />
      <label>{{ trans('main.canChangeClinicInfo') }}</label>
    </div>
  </div>
  <div class="inline field">
    <div class="ui checkbox">
      <input type="checkbox" name="control_managers"{{ Input::old('control_managers') ? ' checked' : '' }} />
      <label>{{ trans('main.canControlManagers') }}</label>
    </div>
  </div>
  <div class="ui submit button">{{ trans('main.add') }}</div>
</form>
@stop