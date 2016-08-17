@extends('clinic')
@section('head')
<script type="text/javascript">
</script>
@stop
@section('content')
<h3 class="ui top attached header">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/notifications">{{ trans('main.notifications') }}</a>
    <div class="divider"> / </div>
    <a class="section" href="/clinic/notifications">{{ $notification->title }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.interestedClients') }}</div>
  </div>
</h3>
<table class="ui celled striped bottom attached centered table">
  <thead>
    <tr>
      <th>{{ trans('main.fullName') }}</th>
      <th class="center aligned collapsing">{{ trans('main.sex') }}</th>
      <th class="center aligned collapsing">{{ trans('main.birthday') }}</th>
      <th class="center aligned collapsing">{{ trans('main.age') }}</th>
      <th class="center aligned">{{ trans('main.phone') }}</th>
    </tr>
  </thead>
  <tbody>
  	@if (count($clients))
    @foreach ($clients as $client)
    <tr>
      <td><i class="{{ $client->sex ? 'male' : 'female' }} icon"></i> <a href="/clinic/clients/{{ $client->id }}">{{ $client->last_name }} {{ $client->first_name }} {{ $client->patronymic }}</a></td>
      <td class="center aligned collapsing">{{ $client->sex ? trans('main.m') : trans('main.f') }}</td>
      <td class="center aligned collapsing">{{ $client->birthday->format('d.m.Y') }}</td>
      <td class="center aligned collapsing">{{ $client->age }}</td>
      <td class="center aligned">{{ $client->phone }}</td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="5" class="center aligned">{{ trans('main.didNotAnsweredAnyClient') }}</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center" style="padding-top: 20px;">{{ $clients->appends([])->links() }}</div>
@stop