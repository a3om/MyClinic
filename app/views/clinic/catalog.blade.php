@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  $('.ui.submit').click(function() {
    $('.ui.form').submit();
  });
  $('.birthday').datepicker().datepicker('option', 'dateFormat', 'dd.mm.yy').datepicker($.datepicker.regional['ru']);
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
    @if(Input::has('sex') && Input::get('sex') >= -1 && Input::get('sex') <= 1)
      $('.sex').dropdown('set selected', {{ Input::get('sex') }});
    @endif

    @if(Input::has('activity') && Input::get('activity') >= -1 && Input::get('activity') <= 1)
      $('.activity').dropdown('set selected', {{ Input::get('activity') }});
    @endif
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
      <form class="ui form" action="/clinic/catalogs/{{ $catalog->id }}" id="filtration">
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
        <div class="field">
          <label>Пол</label>
          <div class="ui selection sex dropdown">
            <input type="hidden" name="sex">
            <div class="default text">Пол</div>
            <i class="dropdown icon"></i>
            <div class="menu">
              <div class="item" data-value="-1">Любой</div>
              <div class="item" data-value="1">Мужчина</div>
              <div class="item" data-value="0">Женщина</div>
            </div>
          </div>
        </div>
        <div class="field">
          <label>Дата рождения</label>
          <input class="birthday" type="text" name="birthday" placeholder="Дата рождения"{{ Input::has('birthday') ? ' value="' . Input::get('birthday') . '"' : '' }}>
        </div>
        <div class="field">
          <label>Возраст</label>
          <div class="two fields">
            <div class="eight wide field">
              <input type="text" name="age_from" placeholder="От"{{ Input::has('age_from') ? ' value="' . Input::get('age_from') . '"' : '' }}>
            </div>
            <div class="eight wide field">
              <input type="text" name="age_to" placeholder="До"{{ Input::has('age_to') ? ' value="' . Input::get('age_to') . '"' : '' }}>
            </div>
          </div>
        </div>
        <div class="fluid ui button" id="filtration-button">Отфильтровать</div>
      </form>
    </div>
  </div>
</div>
@stop
@section('content')
<form class="ui success error form segment" action="/clinic/catalogs/{{ $catalog->id }}" method="post">
  @if(Session::has('success'))
  <div class="ui success message">
    <div class="header">
      Редактирование
    </div>
    <p>Данные были успешно сохранены</p>
  </div>
  @endif
  <div class="{{ $errors->has('name') ? 'error ' : '' }}field">
    <label>Название</label>
    <input placeholder="Имя" type="text" name="name" value="{{ Input::old('name', $catalog->name) }}">
    @if($errors->has('name'))
    <div class="ui red pointing label">
      {{ $errors->first('name') }}
    </div>
    @endif
  </div>
  <div class="ui submit button">Сохранить</div>
</form>
<table class="ui celled striped centered table">
  <thead>
    <tr>
      <th class="">
       ФИО
      </th>
      <th class="right aligned collapsing">
        Пол
      </th>
      <th class="right aligned collapsing">
        Дата рождения
      </th>
      <th class="right aligned collapsing">
        Возраст
      </th>
      <th class="right aligned collapsing">
        <div class="ui massive rating" data-max-rating="1"></div>
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($clients))
    @foreach ($clients as $client)
    <tr>
      <td class="">
        <i class="user icon"></i> {{ $client->last_name }} {{ $client->first_name }} {{ $client->patronymic }}
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
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red popup item" href="/clinic/notifications/create?source=client&source_id={{ $client->id }}" data-content="Отправить клиенту уведомление">
            <i class="mail outline icon"></i>
          </a>
          <a class="green popup item{{ $client->tempcatalog ? ' active' : '' }}" href="/clinic/clients/{{ $client->id }}/{{ $client->tempcatalog ? 'removeFromTempcatalog' : 'addToTempcatalog' }}" data-content="{{ $client->tempcatalog ? 'Удалить клиента из временного списка' : 'Добавить клиента во временный список' }}">
            <i class="indent icon"></i>
          </a>
          <a class="red popup item" href="/clinic/clients/{{ $client->id }}/removeFromCatalog?catalog_id={{ $catalog->id }}" data-content="Удалить клиента из списка">
            <i class="remove icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="5" class="center aligned">Во временном списке нет ни одного клиента</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center">{{ $clients->appends([
    'sex' => Input::get('sex'),
    'age_from' => Input::get('age_from'),
    'age_to' => Input::get('age_to'),
    'first_name' => Input::get('first_name'),
    'last_name' => Input::get('last_name'),
    'patronymic' => Input::get('patronymic'),
    'birthday' => Input::get('birthday'),
  ])->links() }}</div>
@stop