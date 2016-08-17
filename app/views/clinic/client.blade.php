@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  $('.birthday').datepicker().datepicker('option', 'dateFormat', 'dd.mm.yy').datepicker($.datepicker.regional['ru']);
  $('.sex').dropdown('set selected', {{ Input::old('sex', $client->sex) }});
  $('.activity').dropdown('set selected', {{ Input::old('activity', $client->pivot->active) }});
  $('.ui.submit').click(function() {
    $('.ui.form').submit();
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
      Клиенты
    </div>
    <a class="item" href="/clinic/clients/add">
      <i class="user icon"></i> Добавить нового клиента
    </a>
  </div>
</div>
@stop
@section('content')
<form class="ui success error form segment" action="/clinic/clients/{{ $client->id }}" method="post">
  @if(Session::has('success'))
  <div class="ui success message">
    <div class="header">
      Редактирование
    </div>
    <p>Данные были успешно сохранены</p>
  </div>
  @endif
  <div class="{{ $errors->has('phone') ? 'error ' : '' }}field">
    <label>Телефон</label>
    <input placeholder="Телефон" type="text" name="phone" value="{{ Input::old('phone', $client->phone) }}">
    @if($errors->has('phone'))
    <div class="ui red pointing label">
      {{ $errors->first('phone') }}
    </div>
    @endif
  </div>
  <div class="three fields">
    <div class="{{ $errors->has('last_name') ? 'error ' : '' }}field">
      <label>Фамилия</label>
      <input placeholder="Фамилия" type="text" name="last_name" value="{{ Input::old('last_name', $client->last_name) }}">
      @if($errors->has('last_name'))
      <div class="ui red pointing label">
        {{ $errors->first('last_name') }}
      </div>
      @endif
    </div>
    <div class="{{ $errors->has('first_name') ? 'error ' : '' }}field">
      <label>Имя</label>
      <input placeholder="Имя" type="text" name="first_name" value="{{ Input::old('first_name', $client->first_name) }}">
      @if($errors->has('first_name'))
      <div class="ui red pointing label">
        {{ $errors->first('first_name') }}
      </div>
      @endif
    </div>
    <div class="{{ $errors->has('patronymic') ? 'error ' : '' }}field">
      <label>Отчество</label>
      <input placeholder="Отчество" type="text" name="patronymic" value="{{ Input::old('patronymic', $client->patronymic) }}">
      @if($errors->has('patronymic'))
      <div class="ui red pointing label">
        {{ $errors->first('patronymic') }}
      </div>
      @endif
    </div>
  </div>
  <div class="{{ $errors->has('sex') ? 'error ' : '' }}field">
    <label>Пол</label>
    <div class="ui sex selection dropdown">
      <div class="default text">Выберите пол</div>
      <i class="dropdown icon"></i>
      <input type="hidden" name="sex">
      <div class="menu">
        <div class="item" data-value="1">Мужчина</div>
        <div class="item" data-value="0">Женщина</div>
      </div>
    </div>
    @if($errors->has('sex'))
    <div class="ui red pointing label">
      {{ $errors->first('sex') }}
    </div>
    @endif
  </div>
  <div class="{{ $errors->has('birthday') ? 'error ' : '' }}field">
    <label>Дата рождения</label>
    <input placeholder="Дата рождения" type="text" name="birthday" value="{{ Input::old('birthday', $client->birthday->format('d.m.Y')) }}" class="birthday">
    @if($errors->has('birthday'))
    <div class="ui red pointing label">
      {{ $errors->first('birthday') }}
    </div>
    @endif
  </div>
  <div class="{{ $errors->has('activity') ? 'error ' : '' }}field">
    <label>Активность</label>
    <div class="ui activity selection dropdown">
      <div class="default text">Укажите активность</div>
      <i class="dropdown icon"></i>
      <input type="hidden" name="activity">
      <div class="menu">
        <div class="item" data-value="1">Активный</div>
        <div class="item" data-value="0">Неактивный</div>
      </div>
    </div>
    @if($errors->has('activity'))
    <div class="ui red pointing label">
      {{ $errors->first('activity') }}
    </div>
    @endif
  </div>
  <div class="ui submit button">Сохранить</div>
</form>
@stop