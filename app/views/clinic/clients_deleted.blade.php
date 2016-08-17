@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  $('#clearDeleted').click(function() {
    if (confirm('{{ trans('main.removeRemovedClientsConfirmation') }}')) {
      location.href = '/clinic/clients/clearDeleted';
    }
  });
});
</script>
@stop
@section('content')
<h3 class="ui block attached top header" style="background-color: white;">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/clients">{{ trans('main.clients') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.removedClients') }}</div>
  </div>
</h3>
<table class="ui celled striped centered bottom attached table">
  <thead>
    <tr>
      <th class="{{ Input::get('order') == 'last_name' ? 'sorted ' . (Input::get('order_reverse') ? 'descending' : 'ascending') : '' }}">
       <a href="{{ qs_url('/clinic/clients', Input::all()) }}">{{ trans('main.fullName') }}</a>
      </th>
      <th class="center aligned collapsing">
        {{ trans('main.sex') }}
      </th>
      <th class="center aligned collapsing">
        {{ trans('main.birthday') }}
      </th>
      <th class="center aligned collapsing">
        {{ trans('main.age') }}
      </th>
      <th class="center aligned">
        {{ trans('main.phone') }}
      </th>
      <th class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red popup item" id="clearDeleted" data-content="{{ trans('main.removeRemovedClients') }}">
            <i class="remove icon"></i>
          </a>
        </div>
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($clients))
    @foreach ($clients as $client)
    <tr>
      <td>
        <i class="{{ $client->sex ? 'male' : 'female' }} icon"></i> <a href="/clinic/clients/{{ $client->id }}">{{ $client->last_name }} {{ $client->first_name }} {{ $client->patronymic }}</a>
      </td>
      <td class="center aligned">
        {{ $client->sex ? 'М' : 'Ж' }}
      </td>
      <td class="center aligned">
        {{ $client->birthday->format('d.m.Y') }}
      </td>
      <td class="center aligned">
        {{ $client->age }}
      </td>
      <td class="center aligned">
        {{ $client->phone }}
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red popup item" href="/clinic/notifications/create?source=client&source_id={{ $client->id }}" data-content="{{ trans('main.sendNotificationToClient') }}">
            <i class="mail outline icon"></i>
          </a>
          <a class="red popup item" href="/clinic/clients/{{ $client->id }}/restore" data-content="{{ trans('main.restoreClient') }}">
            <i class="share icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="5" class="center aligned">{{ trans('main.clientsAreNotFound') }}</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center" style="padding-top: 20px;">{{ $clients->appends([
    'sex' => Input::get('sex'),
    'activity' => Input::get('activity'),
    'age_from' => Input::get('age_from'),
    'age_to' => Input::get('age_to'),
    'first_name' => Input::get('first_name'),
    'last_name' => Input::get('last_name'),
    'patronymic' => Input::get('patronymic'),
    'birthday' => Input::get('birthday'),
  ])->links() }}</div>
@stop