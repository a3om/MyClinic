@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
	$('.ui.submit').click(function() {
		$('.ui.form').submit();
	});
	$('#add-doctor-field')
	  .search({
	    apiSettings: {
	      url: '/clinic/doctors?query={query}'
	    },
	    onSelect: function(result, response) {
	      // console.log(result);
	      // console.log(response);
	      // $('.ui.search').search('hide results');
	      window.location.href = '/clinic/specialities/{{ $speciality->id }}/attachDoctor?doctor_id=' + result.doctor_id;
	      return false;
	    },
	    cache: false,
	    error: {
	      noResults: '{{ trans('main.doctorIsNotFound') }}',
	      serverError: '{{ trans('main.thereIsAnErrorWhenConnectingWithServer') }}',
	    }
	  });
});
</script>
@stop
@section('content')
<h3 class="ui top attached header">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/specialities">{{ trans('main.specialities') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ $speciality->name }}</div>
  </div>
</h3>
<form class="ui success error form bottom attached segment" action="/clinic/specialities/{{ $speciality->id }}" method="post">
	@if(Session::has('success'))
	<div class="ui success message">
		<div class="header">
		  {{ trans('main.editing') }}
		</div>
		<p>{{ trans('main.dataWereSavedSuccessfuly') }}</p>
	</div>
	@endif
	<div class="{{ $errors->has('name') ? 'error ' : '' }}field">
		<label>{{ trans('main.name') }}</label>
		<input placeholder="{{ trans('main.name') }}" type="text" name="name" value="{{ Input::old('name', $speciality->name) }}">
		@if($errors->has('name'))
		<div class="ui red pointing label">
		  {{ $errors->first('name') }}
		</div>
		@endif
	</div>
	<div class="field">
		<label>{{ trans('main.description') }}</label>
		<textarea name="description">{{ Input::old('description', $speciality->description) }}</textarea>
	</div>
	<div class="ui submit button">{{ trans('main.save') }}</div>
	<div class="ui dropdown icon search input" style="float: right; width: 400px;" id="add-doctor-field">
    	<input type="text" class="prompt" placeholder="{{ trans('main.assignDoctor') }}..." />
    	<i class="doctor link icon"></i>
    	<div class="results"></div>
  	</div>
</form>

<table class="ui celled striped centered table">
  <thead>
    <tr>
      <th>{{ trans('main.fullName') }}</th>
      <th class="center aligned collapsing">{{ trans('main.sex') }}</th>
      <th class="center aligned collapsing"></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($doctors as $doctor)
    <tr>
      <td><i class="doctor icon"></i> <a href="/clinic/doctors/{{ $doctor->id }}">{{ $doctor->last_name }} {{ $doctor->first_name }} {{ $doctor->patronymic }}</a></td>
      <td class="center aligned collapsing">{{ $doctor->sex ? trans('main.m') : trans('main.f') }}</td>
      <td class="center aligned collapsing">
      	<div class="ui icon menu">
          <a class="red popup item" data-content="{{ trans('main.unassignDoctorFromSpeciality') }}" href="/clinic/specialities/{{ $speciality->id }}/detachDoctor?doctor_id={{ $doctor->id }}">
            <i class="remove icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<div align="center">{{ $doctors->appends([])->links() }}</div>
@stop