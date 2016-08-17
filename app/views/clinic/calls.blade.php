@extends('clinic')
@section('head')
<script type="text/javascript">
</script>
@stop
@section('left_rail')
@stop
@section('content')
<table class="ui celled striped centered table">
  <thead>
    <tr>
      <th class="{{ Input::get('order') == 'last_name' ? 'sorted ' . (Input::get('order_reverse') ? 'descending' : 'ascending') : '' }}">
       <a href="{{ qs_url('/clinic/clients', Input::all()) }}">ФИО</a>
      </th>
      <th class="center aligned">
        Пол
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
    @if (count($calls))
    @foreach ($calls as $call)
    <tr class="{{ $call->was_called ? 'positive' : 'negative' }}">
      <td>
        <i class="{{ $call->client->sex ? 'male' : 'female' }} icon"></i> <a href="/clinic/clients/{{ $call->client->id }}">{{ $call->client->last_name }} {{ $call->client->first_name }} {{ $call->client->patronymic }}</a>
      </td>
      <td class="center aligned">
        {{ $call->client->sex ? 'М' : 'Ж' }}
      </td>
      <td class="center aligned">
        {{ $call->client->phone }}
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="green {{ $call->was_called ? 'active ' : '' }}popup item"{{ $call->was_called ? '' : ' href="/clinic/calls/' . $call->id . '/called"' }} data-content="Звонок произведен">
            <i class="check circle icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="5" class="center aligned">Нет ни одного звонка</td>
    </tr>
    @endif
  </tbody>
</table>
@stop