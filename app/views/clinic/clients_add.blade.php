@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  $('.birthday').datepicker().datepicker('option', 'dateFormat', 'dd.mm.yy').datepicker($.datepicker.regional['ru']);
  $('.sex').dropdown('set selected', {{ Input::old('sex', '-1') }});
  $('.ui.submit').click(function() {
    $('.ui.form').submit();
  });
});
</script>
@stop
@section('content')
<form class="ui error form segment" action="/clinic/clients/add" method="post">
  @if(Session::has('success'))
  <div class="ui success message">
    <div class="header">
      Добавление
    </div>
    <p>Клиент был успешно добавлен</p>
  </div>
  @endif
  @if(Session::has('error'))
  <div class="ui error message">
    <div class="header">
      Добавление
    </div>
    <p>Клиент с таким номером телефона уже существует</p>
  </div>
  @endif
  <div class="{{ $errors->has('phone') ? 'error ' : '' }}field">
    <label>Телефон</label>
    <input name="phone" placeholder="Введите телефон" type="text" value="{{ Input::old('phone') }}">
    @if($errors->has('phone'))
    <div class="ui red pointing label">
      {{ $errors->first('phone') }}
    </div>
    @endif
  </div>
  @if (Session::has('nonExistent'))
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
    <input placeholder="Дата рождения" type="text" name="birthday" value="{{ Input::old('birthday') }}" class="birthday">
    @if($errors->has('birthday'))
    <div class="ui red pointing label">
      {{ $errors->first('birthday') }}
    </div>
    @endif
  </div>
  @endif
  <div class="ui submit button">Добавить</div>
</form>
@stop