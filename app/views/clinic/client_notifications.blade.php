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
});
</script>
@stop
@section('sidebar')
<div class="item" style="margin: 0 10px;">
  <div class="ui small header">{{ trans('main.filtration') }}</div>
  <div class="menu">
    <form class="ui form" action="/clinic/clients/{{ $client->id }}/notifications" id="filtration">
      <div class="field">
        <label>{{ trans('main.text' )}}</label>
        <input type="text" name="text" placeholder="{{ trans('main.text') }}"{{ Input::has('text') ? ' value="' . Input::get('text') . '"' : '' }}>
      </div>
      <div class="fluid ui button" id="filtration-button">{{ trans('main.filter') }}</div>
    </form>
  </div>
</div>
@stop
@section('content')
<h3 class="ui block top attached header" style="background-color: white;">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/clients">{{ trans('main.clients') }}</a>
    <div class="divider"> / </div>
    <a class="section" href="/clinic/clients/{{ $client->id }}">{{ $client->last_name }} {{ $client->first_name }} {{ $client->patronymic }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.notifications') }}</div>
  </div>
</h3>
<table class="ui celled striped centered bottom attached table">
  <thead>
    <tr>
      <th>
        {{ trans('main.name') }}
      </th>
      <th class="center aligned collapsing">
        {{ trans('main.date') }}
      </th>
      <th class="right aligned collapsing">
        {{ trans('main.options') }}
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($notifications))
    @foreach ($notifications as $notification)
    <tr>
      <td>
        <i class="mail outline icon"></i> <a href="/clinic/notifications/{{ $notification->id }}">{{ $notification->title }}</a>
      </td>
      <td class="right aligned collapsing">
        {{ $notification->created_at->format('d.m.Y') }} в {{ $notification->created_at->format('H:i') }}
      </td>
      <!-- <td>
        25
      </td> -->
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red item" href="/clinic/notifications/create?source=notification&source_id={{ $notification->id }}">
            <i class="mail outline icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="2" class="center aligned">{{ trans('main.clientHasNotAnyNotification') }}</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center" style="padding-top: 20px;">{{ $notifications->links() }}</div>
@stop