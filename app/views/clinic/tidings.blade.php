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
<a class="item" href="/clinic/news/add">
  <i class="browser icon"></i> {{ trans('main.addNews') }}
</a>
@stop
@section('content')
<h3 class="ui block attached top header" style="background-color: white;">
  <div class="ui breadcrumb">
    <div class="active section">{{ trans('main.news') }}</div>
  </div>
</h3>
<table class="ui celled striped centered bottom attached table">
  <thead>
    <tr>
      <th>
        {{ trans('main.title') }}
      </th>
      <th class="center aligned collapsing">
        {{ trans('main.date') }}
      </th>
      <th class="right aligned collapsing">
        {{ trans('main.options') }}
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($tidings))
    @foreach ($tidings as $tiding)
    <tr>
      <td>
        <i class="browser outline icon"></i> <a href="/clinic/news/{{ $tiding->id }}">{{ $tiding->title }}</a>
      </td>
      <td class="right aligned collapsing">
        {{ $tiding->created_at->format('d.m.Y') }} в {{ $tiding->created_at->format('H:i') }}
      </td>
      <!-- <td>
        25
      </td> -->
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red item" href="/clinic/news/{{ $tiding->id }}/delete">
            <i class="remove icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="2" class="center aligned">{{ trans('main.noNews') }}</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center" style="padding-top: 20px;">{{ $tidings->links() }}</div>
@stop