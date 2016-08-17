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
@section('sidebar')
<a class="item" href="/clinic/managers/add">
  <i class="user icon"></i> {{ trans('main.addManager') }}
</a>
@stop
@section('content')
<h3 class="ui top attached header">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/managers">{{ trans('main.managers') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ $manager->login }}</div>
  </div>
</h3>
<form class="ui success error form bottom attached segment" action="/clinic/managers/{{ $manager->id }}" method="post">
	@if(Session::has('success'))
	<div class="ui success message">
		<div class="header">
		  {{ trans('main.editing') }}
		</div>
		<p>{{ trans('main.dataWereSavedSuccessfuly') }}</p>
	</div>
	@endif
	<div class="{{ $errors->has('login') ? 'error ' : '' }}field">
		<label>{{ trans('main.login') }}</label>
		<input placeholder="{{ trans('main.enterLogin') }}" type="text" name="login" value="{{ Input::old('login', $manager->login) }}" />
		@if($errors->has('login'))
		<div class="ui red pointing label">
		  {{ $errors->first('login') }}
		</div>
		@endif
	</div>
	<div class="field">
		<label>{{ trans('main.password') }}</label>
		<input placeholder="{{ trans('main.enterNewPassword') }}" type="text" name="password" />
		@if($errors->has('password'))
		<div class="ui red pointing label">
		  {{ $errors->first('password') }}
		</div>
		@endif
	</div>
	<div class="inline field">
		<div class="ui checkbox">
		  <input type="checkbox" name="delete_client"{{ Input::old('delete_client', $manager->delete_client) ? ' checked' : '' }} />
		  <label>{{ trans('main.canRemoveClients') }}</label>
		</div>
	</div>
	<div class="inline field">
		<div class="ui checkbox">
		  <input type="checkbox" name="edit_clinic_info"{{ Input::old('edit_clinic_info', $manager->edit_clinic_info) ? ' checked' : '' }} />
		  <label>{{ trans('main.canChangeClinicInfo') }}</label>
		</div>
	</div>
	<div class="inline field">
		<div class="ui checkbox">
		  <input type="checkbox" name="control_managers"{{ Input::old('control_managers', $manager->control_managers) ? ' checked' : '' }} />
		  <label>{{ trans('main.canControlManagers') }}</label>
		</div>
	</div>
	<div class="ui submit button">{{ trans('main.save') }}</div>
</form>
@stop