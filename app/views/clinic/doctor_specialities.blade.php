@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  $('.ui.submit').click(function() {
    $('.ui.form').submit();
  });
  $('#filtration .ui.button')
    .click(function() {
      $('#filtration').submit();
    });
  $('#filtration')
    .keypress(function(event) {
      if (event.which == 13) {
          event.preventDefault();
          $("#filtration").submit();
      }
    });
  $('#add-speciality-field')
    .search({
      apiSettings: {
        url: '/clinic/specialities?query={query}'
      },
      onSelect: function(result, response) {
        // console.log(result);
        // console.log(response);
        // $('.ui.search').search('hide results');
        window.location.href = '/clinic/specialities/' + result.speciality_id + '/attachDoctor?doctor_id={{ $doctor->id }}';
        return false;
      },
      cache: false,
      error: {
        noResults: '{{ trans('main.specialityIsNotFound') }}',
        serverError: '{{ trans('main.thereIsAnErrorWhenConnectingWithServer') }}',
      }
    });
});
</script>
@stop
@section('content')
<h3 class="ui block top attached header" style="background-color: white;">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/doctors">{{ trans('main.doctors') }}</a>
    <div class="divider"> / </div>
    <a class="section" href="/clinic/doctors/{{ $doctor->id }}">{{ $doctor->last_name }} {{ $doctor->first_name }} {{ $doctor->patronymic }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.specialities') }}</div>
  </div>
</h3>
<form class="ui form attached segment">
  <div class="ui dropdown icon search input" id="add-speciality-field">
    <input type="text" class="prompt" placeholder="{{ trans('main.assignSpeciality') }}..." />
    <i class="share alternate link icon"></i>
    <div class="results"></div>
  </div>
</form>
<table class="ui celled striped centered bottom attached table">
  <thead>
    <tr>
      <th>{{ trans('main.name') }}</th>
      <th class="center aligned collapsing">{{ trans('main.options') }}</th>
    </tr>
  </thead>
  <tbody>
    @if (count($specialities))
    @foreach ($specialities as $speciality)
    <tr>
      <td><i class="share alternate icon"></i> <a href="/clinic/specialities/{{ $speciality->id }}">{{ $speciality->name }}</a></td>
      <td class="center aligned collapsing">
        <div class="ui icon menu">
          <a class="red popup item" data-content="{{ trans('main.unassignSpeciality') }}" href="/clinic/specialities/{{ $speciality->id }}/detachDoctor?doctor_id={{ $doctor->id }}">
            <i class="remove icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="2" class="center aligned">{{ trans('main.doctorIsNotNotAssociatedWithAnySpeciality') }}</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center" style="padding-top: 20px;">{{ $specialities->appends([])->links() }}</div>
@stop