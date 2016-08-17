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
@section('sidebar')
<a class="item" href="/clinic/managers/add">
  <i class="user icon"></i> {{ trans('main.addManager') }}
</a>
@stop
@section('content')
<h3 class="ui block attached top header" style="background-color: white;">
  <div class="ui breadcrumb">
    <div class="active section">{{ trans('main.managers') }}</div>
  </div>
</h3>
<table class="ui celled striped centered bottom attached table">
  <thead>
    <tr>
      <th>
        {{ trans('main.login') }}
      </th>
      <th class="right aligned collapsing">
        {{ trans('main.options') }}
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($managers))
    @foreach ($managers as $manager)
    <tr>
      <td>
        <i class="browser outline icon"></i> <a href="/clinic/managers/{{ $manager->id }}">{{ $manager->login }}</a>
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red item" href="/clinic/managers/{{ $manager->id }}/delete">
            <i class="remove icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="2" class="center aligned">{{ trans('main.noManagers') }}</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center" style="padding-top: 20px;">{{ $managers->links() }}</div>
@stop