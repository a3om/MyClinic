@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  $('.sex').dropdown('set selected', {{ Input::old('sex', $doctor->sex) }});
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
      Доктора
    </div>
    <a class="item" href="/clinic/doctors/add">
      <i class="doctor icon"></i> Добавить нового доктора
    </a>
  </div>
</div>
@stop
@section('content')
<form class="ui success error form segment" action="/clinic/doctors/{{ $doctor->id }}" method="post">
  @if(Session::has('success'))
  <div class="ui success message">
    <div class="header">
      Редактирование
    </div>
    <p>Данные были успешно сохранены</p>
  </div>
  @endif
  <div class="{{ $errors->has('photo') ? 'error ' : '' }}field">
    <label>Фотография</label>
    <input placeholder="Фотография" type="" name="photo" value="{{ Input::old('photo', $doctor->photo) }}">
    @if($errors->has('photo'))
    <div class="ui red pointing label">
      {{ $errors->first('photo') }}
    </div>
    @endif
  </div>
  <div class="three fields">
    <div class="{{ $errors->has('last_name') ? 'error ' : '' }}field">
      <label>Фамилия</label>
      <input placeholder="Фамилия" type="text" name="last_name" value="{{ Input::old('last_name', $doctor->last_name) }}">
      @if($errors->has('last_name'))
      <div class="ui red pointing label">
        {{ $errors->first('last_name') }}
      </div>
      @endif
    </div>
    <div class="{{ $errors->has('first_name') ? 'error ' : '' }}field">
      <label>Имя</label>
      <input placeholder="Имя" type="text" name="first_name" value="{{ Input::old('first_name', $doctor->first_name) }}">
      @if($errors->has('first_name'))
      <div class="ui red pointing label">
        {{ $errors->first('first_name') }}
      </div>
      @endif
    </div>
    <div class="{{ $errors->has('patronymic') ? 'error ' : '' }}field">
      <label>Отчество</label>
      <input placeholder="Отчество" type="text" name="patronymic" value="{{ Input::old('patronymic', $doctor->patronymic) }}">
      @if($errors->has('patronymic'))
      <div class="ui red pointing label">
        {{ $errors->first('patronymic') }}
      </div>
      @endif
    </div>
  </div>
  <div class="three fields">
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
    <div class="{{ $errors->has('phone') ? 'error ' : '' }}field">
      <label>Телефон</label>
      <input placeholder="Телефон" type="text" name="phone" value="{{ Input::old('phone', $doctor->phone) }}">
      @if($errors->has('phone'))
      <div class="ui red pointing label">
        {{ $errors->first('phone') }}
      </div>
      @endif
    </div>
    <div class="{{ $errors->has('address') ? 'error ' : '' }}field">
      <label>Адрес</label>
      <input placeholder="Имя" type="text" name="address" value="{{ Input::old('address', $doctor->address) }}">
      @if($errors->has('address'))
      <div class="ui red pointing label">
        {{ $errors->first('address') }}
      </div>
      @endif
    </div>
  </div>
  <div class="{{ $errors->has('description') ? 'error ' : '' }}field">
    <label>Описание</label>
    <textarea name="description">{{ Input::old('description', $doctor->description) }}</textarea>
    @if($errors->has('description'))
    <div class="ui red pointing label">
      {{ $errors->first('description') }}
    </div>
    @endif
  </div>
  <div class="ui submit button">Сохранить</div>
</form>
@stop