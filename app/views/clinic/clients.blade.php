@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  var lists = [];
  var $checkboxes = $('#clients-list .checkbox');
  var $childCheckboxes = $checkboxes.not('.check-all');
  $childCheckboxes.checkbox({
    onChecked: function() {
      lists.push($(this[0]).attr('value'));
    },
    onUnchecked: function() {
      var index = lists.indexOf($(this[0]).attr('value'));
      if (index > -1) {
        lists.splice(index, 1);
      }
    },
    onChange: function() {
      console.log(this);
    }
  });
  $parentCheckbox = $checkboxes.filter('.check-all');
  $parentCheckbox.checkbox({
    onChange: function() {
      if ($parentCheckbox.checkbox('is checked')) {
        $childCheckboxes.checkbox('check');
      }
      else {
        $childCheckboxes.checkbox('uncheck');
      }
    }
  });

  $('.submit.button')
      .api({
        url: '/panel/clients',
        method: 'POST',
        data: {},
        beforeSend: function(options) {
          console.log(options);
        options.data.lists = lists;
        return options;
      },
        onSuccess: function(response) {
          console.log(response);
          console.log('Вииии C:' + lists);
        },
        onError: function() {
          console.log('Плакн плакн');
        },
        onFailure: function() {
          console.log('Эхххх');
        },
      })
    ;
  // $checkboxes.not('.check-all').checkbox('attach events', '.check-all', 'check');
  // $checkboxes.not('.check-all').checkbox('attach events', '.check-all', 'uncheck');
  // $('.check-all').checkbox('');
  // $childCheckboxes = ;
  // $parentCheckbox = $checkboxes.filter(':first');

  // $parentCheckbox.prop('onChange', function (e) {
  //   if ($parentCheckbox.checkbox('is checked')) {
  //     $childCheckboxes.checkbox('check');
  //   }
  //   else {
  //     $childCheckboxes.checkbox('uncheck');
  //   }
  // });
  // $childCheckboxes.click(function (e) {
  //   var $checkbox = $(e.currentTarget);
  //   console.log($checkbox);
  // });
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
      <form class="ui form" action="/clinic/clients" id="filtration">
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
        <div class="field">
          <label>Активность</label>
          <div class="ui selection activity dropdown">
            <input type="hidden" name="activity">
            <div class="default text">Активность</div>
            <i class="dropdown icon"></i>
            <div class="menu">
              <div class="item" data-value="-1">Не важно</div>
              <div class="item" data-value="1">Активный</div>
              <div class="item" data-value="0">Неактивный</div>
            </div>
          </div>
        </div>
        <div class="fluid ui button" id="filtration-button">Отфильтровать</div>
      </form>
    </div>
  </div>
  <div class="ui fluid vertical menu">
    <div class="header item">
      <i class="users icon"></i> Клиенты
    </div>
    <a class="item" href="/clinic/clients/add">
      <i class="user icon"></i> Добавить нового клиента
    </a>
  </div>
</div>
@stop
@section('content')
<table class="ui celled striped centered table">
  <thead>
    <tr>
      <th class="{{ Input::get('order') == 'last_name' ? 'sorted ' . (Input::get('order_reverse') ? 'descending' : 'ascending') : '' }}">
       <a href="{{ qs_url('/clinic/clients', Input::all()) }}">ФИО</a>
      </th>
      <th class="center aligned collapsing">
        Пол
      </th>
      <th class="center aligned collapsing">
        Дата рождения
      </th>
      <th class="center aligned collapsing">
        Возраст
      </th>
      <th class="center aligned">
        Телефон
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
    @if (count($clients))
    @foreach ($clients as $client)
    <tr>
      <td>
        <i class="{{ $client->sex ? 'male' : 'female' }} icon"></i> <a href="/clinic/clients/{{ $client->id }}">{{ $client->last_name }} {{ $client->first_name }} {{ $client->patronymic }}</a>
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
      <td class="center aligned">
        {{ $client->phone }}
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red popup item" href="/clinic/notifications/create?source=client&source_id={{ $client->id }}" data-content="Отправить клиенту уведомление">
            <i class="mail outline icon"></i>
          </a>
          @if ($client->pivot->active)
          <a class="green popup item{{ $client->tempcatalog ? ' active' : '' }}" href="/clinic/clients/{{ $client->id }}/{{ $client->tempcatalog ? 'removeFromTempcatalog' : 'addToTempcatalog' }}" data-content="{{ $client->tempcatalog ? 'Удалить клиента из временного списка' : 'Добавить клиента во временный список' }}">
            <i class="indent icon"></i>
          </a>
          @endif
          <a class="green popup item{{ $client->pivot->active ? ' active' : '' }}" href="/clinic/clients/{{ $client->id }}/{{ $client->pivot->active ? 'disable' : 'enable' }}" data-content="{{ $client->pivot->active ? 'Сделать клиента неактивным' : 'Сделать клиента активным' }}">
            <i class="{{ $client->pivot->active ? '' : 'empty ' }}star icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="5" class="center aligned">Клиенты не найдены</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center">{{ $clients->appends([
    'sex' => Input::get('sex'),
    'activity' => Input::get('activity'),
    'age_from' => Input::get('age_from'),
    'age_to' => Input::get('age_to'),
    'first_name' => Input::get('first_name'),
    'last_name' => Input::get('last_name'),
    'patronymic' => Input::get('patronymic'),
    'birthday' => Input::get('birthday'),
  ])->links() }}</div>
@stop