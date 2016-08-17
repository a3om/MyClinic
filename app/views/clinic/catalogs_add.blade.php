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
<form class="ui error form segment" action="/clinic/catalogs/add" method="POST">
  <div class="{{ $errors->has('name') ? 'error ' : '' }}field">
    <label>Имя</label>
    <input placeholder="Имя" type="text" name="name" value="{{ Input::old('name') }}">
    @if($errors->has('name'))
    <div class="ui red pointing label">
      {{ $errors->first('name') }}
    </div>
    @endif
  </div>
  @if (count($clients))
  <div class="field">
    <label>Клиенты</label>
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
  <input type="hidden" name="source" value="{{ Input::old('source', Input::get('source')) }}" />
  <input type="hidden" name="source_id" value="{{ Input::old('source_id', Input::get('source_id')) }}" />
  @endif
  <div class="ui submit button">Добавить</div>
</form>
@stop