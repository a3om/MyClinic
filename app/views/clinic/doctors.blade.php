@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
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
});</script>
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
      <form class="ui form" action="/clinic/doctors" id="filtration">
        <div class="field">
          <label>Фамилия</label>
          <input type="text" name="last_name" placeholder="Фамилия"{{ Input::has('last_name') ? ' value="' . Input::get('last_name') . '"' : '' }}>
        </div>
        <div class="field">
          <label>Имя</label>
          <input type="text" name="first_name" placeholder="Имя"{{ Input::has('first_name') ? ' value="' . Input::get('first_name') . '"' : '' }}>
        </div>
        <div class="field">
          <label>Отчество</label>
          <input type="text" name="patronymic" placeholder="Отчество"{{ Input::has('patronymic') ? ' value="' . Input::get('patronymic') . '"' : '' }}>
        </div>
        <div class="fluid ui button" id="filtration-button">Отфильтровать</div>
      </form>
    </div>
  </div>
  <div class="ui fluid vertical menu">
    <div class="header item">
      Клиенты
    </div>
    <a class="item" href="/clinic/doctors/add">
      <i class="doctor icon"></i> Добавить нового доктора
    </a>
  </div>
</div>
@stop
@section('content')
<table class="ui celled striped centered table">
  <thead>
    <tr>
      <th class="{{ Input::get('order') == 'last_name' ? 'sorted ' . (Input::get('order_reverse') ? 'descending' : 'ascending') : '' }}">
       <a href="{{ qs_url('/clinic/doctors', Input::all()) }}">ФИО</a>
      </th>
      <th class="right aligned collapsing">
        <div class="ui dropdown">
          Опции<i class="dropdown icon"></i>
          <div class="menu">
            <div class="item">Choice 1</div>
            <div class="item">Choice 2</div>
            <div class="item">Choice 3</div>
          </div>
        </div>
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($doctors))
    @foreach ($doctors as $doctor)
    <tr>
      <td>
        <i class="doctor icon"></i> <a href="/clinic/doctors/{{ $doctor->id }}">{{ $doctor->last_name }} {{ $doctor->first_name }} {{ $doctor->patronymic }}</a>
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="green popup item" href="/clinic/doctors/{{ $doctor->id }}/delete" data-content="Удалить доктора">
            <i class="remove icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="5" class="center aligned">Доктора не найдены</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center">{{ $doctors->appends([
    'first_name' => Input::get('first_name'),
    'last_name' => Input::get('last_name'),
    'patronymic' => Input::get('patronymic'),
  ])->links() }}</div>
@stop