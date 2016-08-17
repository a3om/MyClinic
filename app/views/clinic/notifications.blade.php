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
@section('left_rail')
<div class="ui sticky">
  <p></p>
  <p></p>
  <p></p>
  <div class="ui fluid vertical menu">
    <div class="header item">
      <i class="filter icon"></i> Фильтрация
    </div>
    <div class="item">
      <form class="ui form" action="/clinic/notifications" id="filtration">
        <div class="field">
          <label>Текст</label>
          <input type="text" name="text" placeholder="Текст"{{ Input::has('text') ? ' value="' . Input::get('text') . '"' : '' }}>
        </div>
        <div class="fluid ui button" id="filtration-button">Отфильтровать</div>
      </form>
    </div>
  </div>
</div>
@stop
@section('content')
<table class="ui celled striped centered table">
  <thead>
    <tr>
      <th>
        Название
      </th>
      <th class="right aligned collapsing">
        Опции
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($notifications))
    @foreach ($notifications as $notification)
    <tr>
      <td class="">
        <i class="mail outline icon"></i> <a href="/clinic/notifications/{{ $notification->id }}">{{ $notification->text }}</a>
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
      <td colspan="2" class="center aligned">В системе нет ни одного уведомления</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center">{{ $notifications->links() }}</div>
@stop