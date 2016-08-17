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
<form class="ui error form segment" action="/clinic/notifications/create" method="POST">
  @if (count($clients))
  <div class="field">
    <label>Текст уведомления</label>
    <textarea name="text">{{ Input::get('text', $text) }}</textarea>
  </div>
  <div class="field">
    <label>Получатели</label>
    <table class="ui very basic table">
      <thead>
        <tr>
          <th>ФИО</th>
          <th class="center aligned collapsing">Пол</th>
          <th class="center aligned collapsing">Дата рождения</th>
          <th class="center aligned collapsing">Возраст</th>
          <th class="center aligned">Телефон</th>
        </tr>
      </thead>
      </thead>
      <tbody>
        @foreach ($clients as $client)
        <tr>
          <td>{{ $client->first_name }}</td>
          <td class="center aligned collapsing">{{ $client->sex ? 'М' : 'Ж' }}</td>
          <td class="center aligned collapsing">{{ $client->birthday->format('d.m.Y') }}</td>
          <td class="center aligned collapsing">{{ $client->age }}</td>
          <td class="center aligned">{{ $client->phone }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <input type="hidden" name="source" value="{{ Input::get('source') }}" />
  <input type="hidden" name="source_id" value="{{ Input::get('source_id') }}" />
  <div class="ui submit button">Отправить</div>
  @else
  <div class="ui error message">
    <div class="header">Нет ни одного получателя</div>
    <p>Для отправки уведомления Вы должны выбрать не пустой список.</p>
  </div>
  @endif
</form>
@stop