@extends('panel')
@section('head')
<script type="text/javascript"></script>
@stop
@section('content')
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
      <!-- <th></th> -->
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
      	М
      </td>
      <td class="center aligned">
      	12.02.1990
      </td>
      <!-- <td class="right aligned collapsing"><div class="ui fitted toggle checkbox"><input type="checkbox" name="public"><label></label></div></td> -->
    </tr>
    @endforeach
    @else
    <tr><td colspan="3" class="center aligned">Клиенты не найдены</td></tr>
    @endif
  </tbody>
</table>
@stop