@extends('clinic')
@section('head')
<script type="text/javascript">
</script>
@stop
@section('content')
<h3 class="ui block attached top header" style="background-color: white;">
  <div class="ui breadcrumb">
    @if (Request::path() == 'clinic/doctorentries')
    <div class="active section">{{ trans('main.appointments') }}</div>
    @else
    <a href="/clinic/doctorentries"class="section">{{ trans('main.appointments') }}</a>
    <div class="divider"> / </div>
    <div class="active section">
      @if (Request::path() == 'clinic/doctorentries/overdue')
      {{ trans('main.overdueAppointments') }}
      @elseif (Request::path() == 'clinic/doctorentries/canceled')
      {{ trans('main.canceledAppointments') }}
      @elseif (Request::path() == 'clinic/doctorentries/completed')
      {{ trans('main.completedAppointments') }}
      @elseif (Request::path() == 'clinic/doctorentries/all')
      {{ trans('main.allAppointments') }}
      @endif
    </div>
    @endif
  </div>
</h3>
<table class="ui celled striped centered bottom attached table">
  <thead>
    <tr>
      <th>
        {{ trans('main.fullName') }}
      </th>
      <th class="center aligned">
        {{ trans('main.orderDate') }}
      </th>
      <th class="center aligned">
        {{ trans('main.from') }} / {{ trans('main.to') }}
      </th>
      <th class="center aligned">
        {{ trans('main.phone') }}
      </th>
      <th class="center aligned collapsing">
        {{ trans('main.goalOfTreatment') }}
      </th>
      <th class="right aligned collapsing">
        <div class="ui dropdown">
          {{ trans('main.options') }}<i class="dropdown icon"></i>
          <div class="menu">
            <a class="item{{ Request::path() == 'clinic/doctorentries/overdue' ? ' active' : '' }}" href="/clinic/doctorentries/overdue">{{ trans('main.overdueAppointments') }}</a>
            <a class="item{{ Request::path() == 'clinic/doctorentries/canceled' ? ' active' : '' }}" href="/clinic/doctorentries/canceled">{{ trans('main.canceledAppointments') }}</a>
            <a class="item{{ Request::path() == 'clinic/doctorentries/completed' ? ' active' : '' }}" href="/clinic/doctorentries/completed">{{ trans('main.completedAppointments') }}</a>
            <a class="item{{ Request::path() == 'clinic/doctorentries/all' ? ' active' : '' }}" href="/clinic/doctorentries/all">{{ trans('main.allAppointments') }}</a>
          </div>
        </div>
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($doctorentries))
    @foreach ($doctorentries as $doctorentry)
    <tr class="{{ $doctorentry->completed ? 'positive' : ($doctorentry->canceled ? 'active' : (($doctorentry->to <= new DateTime) ? 'negative' : '')) }}" style="height: 53px;">
      <td>
        <i class="{{ $doctorentry->client->sex ? 'male' : 'female' }} icon"></i> <a href="/clinic/clients/{{ $doctorentry->client->id }}">{{ $doctorentry->client->last_name }} {{ $doctorentry->client->first_name }} {{ $doctorentry->client->patronymic }}</a>
      </td>
      <td class="center aligned">
        {{ $doctorentry->created_at->format('H:i') }}<br />{{ $doctorentry->created_at->format('d.m.Y') }}
      </td>
      <td class="center aligned">
        {{ $doctorentry->from->format('H:i') }} - {{ $doctorentry->to->format('H:i') }}<br />{{ $doctorentry->to->format('d.m.Y') }}
      </td>
      <td class="center aligned">
        {{ phoneFormat($doctorentry->client->phone) }}
      </td>
      <td class="center aligned">
        @if ($doctorentry->place_type)
          @if ($doctorentry->place_type == 'Doctor')
          @if ($doctorentry->place)
          <a href="/clinic/doctors/{{ $doctorentry->place->id }}">{{ $doctorentry->place->last_name }} {{ $doctorentry->place->first_name }} {{ $doctorentry->place->patronymic }}</a>
          @else
          {{ trans('main.unknown') }}
          @endif
          @elseif ($doctorentry->place_type == 'Service')
          @if ($doctorentry->place)
          <a href="/clinic/services/{{ $doctorentry->place->id }}" class="popup" data-content="{{ trans('main.service') }}">{{ $doctorentry->place->name }}</a>
          @else
          {{ trans('main.unknown') }}
          @endif
          @elseif ($doctorentry->place_type == 'Speciality')
          @if ($doctorentry->place)
          <a href="/clinic/specialities/{{ $doctorentry->place->id }}" class="popup" data-content="{{ trans('main.speciality') }}">{{ $doctorentry->place->name }}</a>
          @else
          {{ trans('main.unknown') }}
          @endif
          @endif
        @else
          {{ trans('main.unknown') }}
        @endif
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          @if (!$doctorentry->completed && !$doctorentry->canceled && ($doctorentry->to > new DateTime))
          <a class="popup item" href="/clinic/doctorentries/{{ $doctorentry->id }}/completed" data-content="{{ trans('main.appointmentIsCompleted') }}">
            <i class="checkmark icon"></i>
          </a>
          @endif
          @if (!$doctorentry->completed && !$doctorentry->canceled && ($doctorentry->to > new DateTime))
          <a class="popup item" href="/clinic/doctorentries/{{ $doctorentry->id }}/cancel" data-content="{{ trans('main.appointmentIsCanceled') }}">
            <i class="minus icon"></i>
          </a>
          @endif
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="7" class="center aligned">{{ trans('main.noAppointments') }}</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center" style="padding-top: 20px;">{{ $doctorentries->appends([])->links() }}</div>
@stop