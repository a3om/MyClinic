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
@section('sidebar')
<a class="item" href="/clinic/specialities/add">
  <i class="add icon"></i> {{ trans('main.addSpeciality') }}
</a>
@stop
@section('content')
<h3 class="ui block attached top header" style="background-color: white;">
  <div class="ui breadcrumb">
    <div class="active section">{{ trans('main.specialities') }}</div>
  </div>
</h3>
<table class="ui celled striped bottom attached centered table">
  <thead>
    <tr>
      <th>
      	{{ trans('main.name') }}
      </th>
      <th class="right aligned collapsing">
        {{ trans('main.options') }}
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($specialities))
    @foreach ($specialities as $specialitiy)
    <tr>
      <td>
        <i class="share alternate icon"></i> <a href="/clinic/specialities/{{ $specialitiy->id }}">{{ $specialitiy->name }}</a>
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red popup item" data-content="Удалить специализаию" href="/clinic/specialities/{{ $specialitiy->id }}/delete">
            <i class="remove icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="2" class="center aligned">{{ trans('main.noSpecialities') }}</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center" style="padding-top: 20px;">{{ $specialities->appends([])->links() }}</div>
@stop