@extends('clinic')
@section('head')

@stop
@section('sidebar')
<a class="item" href="/clinic/services/add">
  <i class="add icon"></i> {{ trans('main.addService') }}
</a>
@stop
@section('content')
<h3 class="ui block attached top header" style="background-color: white;">
  <div class="ui breadcrumb">
    <div class="active section">{{ trans('main.services') }}</div>
  </div>
</h3>
<table class="ui celled striped bottom attached centered table">
  <thead>
    <tr>
      <th>
      	{{ trans('main.name') }}
      </th>
      <th class="right aligned collapsing">
        <div class="ui dropdown">
          {{ trans('main.options') }}<i class="dropdown icon"></i>
          <div class="menu">
            <a class="item" href="/clinic/services/sorting">{{ trans('main.sorting') }}</a>
          </div>
        </div>
      </th>
    </tr>
  </thead>
  <tbody id="services">
    @if (count($services))
    @foreach ($services as $service)
    <tr>
      <td>
        <i class="share alternate icon"></i> <a href="/clinic/services/{{ $service->id }}">{{ $service->name }}</a>
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red popup item" data-content="{{ trans('main.removeService') }}" href="/clinic/services/{{ $service->id }}/delete">
            <i class="remove icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="2" class="center aligned">{{ trans('main.noServices') }}</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center" style="padding-top: 20px;">{{ $services->appends([])->links() }}</div>
@stop