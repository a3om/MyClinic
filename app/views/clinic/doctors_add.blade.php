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
<form class="ui error form segment" action="/clinic/doctors/add" method="post">
  <div class="{{ $errors->has('last_name') ? 'error ' : '' }}field">
    <label>Фамилия</label>
    <input name="last_name" placeholder="Введите фамилию" type="text" value="{{ Input::old('last_name') }}">
    @if($errors->has('last_name'))
    <div class="ui red pointing label">
      {{ $errors->first('last_name') }}
    </div>
    @endif
  </div>
  <div class="{{ $errors->has('first_name') ? 'error ' : '' }}field">
    <label>Имя</label>
    <input name="first_name" placeholder="Введите имя" type="text" value="{{ Input::old('first_name') }}">
    @if($errors->has('first_name'))
    <div class="ui red pointing label">
      {{ $errors->first('first_name') }}
    </div>
    @endif
  </div>
  <div class="{{ $errors->has('patronymic') ? 'error ' : '' }}field">
    <label>Отчество</label>
    <input name="patronymic" placeholder="Введите отчество" type="text" value="{{ Input::old('patronymic') }}">
    @if($errors->has('patronymic'))
    <div class="ui red pointing label">
      {{ $errors->first('patronymic') }}
    </div>
    @endif
  </div>
  <div class="{{ $errors->has('description') ? 'error ' : '' }}field">
    <label>Описание</label>
    <textarea name="description">{{ Input::old('description') }}</textarea>
    @if($errors->has('description'))
    <div class="ui red pointing label">
      {{ $errors->first('description') }}
    </div>
    @endif
  </div>
  <div class="ui submit button">Добавить</div>
</form>
@stop