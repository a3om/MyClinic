@extends('clinic')
@section('head')
<script type="text/javascript">

</script>
@stop
@section('content')
<table class="ui celled striped centered table">
  <thead>
    <tr>
      <th>
       ФИО
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
        <div class="ui massive rating" data-max-rating="1"></div>
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($records))
    @foreach ($records as $record)
    <tr>
      <td class="">
        <i class="user icon"></i> {{ $record->client->first_name }} {{ $record->client->last_name }} {{ $record->client->patronymic }}
      </td>
      <td class="center aligned">
        {{ $record->client->sex ? 'М' : 'Ж' }}
      </td>
      <td class="center aligned">
        {{ $record->client->birthday->format('d.m.Y') }}
      </td>
      <td class="center aligned">
        {{ $record->client->age }}
      </td>
      <td class="center aligned">
        {{ $record->client->phone }}
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red popup item" href="/clinic/notifications/create?source=client&source_id={{ $record->client->id }}" data-content="Отправить клиенту уведомление">
            <i class="mail outline icon"></i>
          </a>
          <a class="red popup item" href="/clinic/clients/{{ $record->client->id }}/removeFromTempcatalog" data-content="Удалить клиента из временного списка">
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
<div align="center">{{ $records->links() }}</div>
@stop