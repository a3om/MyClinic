@extends('clinic')
@section('head')
<script type="text/javascript">
</script>
@stop
@section('content')
<h3 class="ui block header" style="background-color: white;">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/clients">{{ trans('main.clients') }}</a>
    <div class="divider"> / </div>
    <a class="section" href="/clinic/clients/{{ $client->id }}">{{ $client->last_name }} {{ $client->first_name }} {{ $client->patronymic }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.calls') }}</div>
  </div>
</h3>
<table class="ui celled striped centered table">
  <thead>
    <tr>
      <th>
       {{ trans('main.creationDate') }}
      </th>
      <th>
       {{ trans('main.from') }}
      </th>
      <th>
       {{ trans('main.to') }}
      </th>
      <th class="right aligned collapsing">
        {{ trans('main.options') }}
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($calls))
    @foreach ($calls as $call)
    <tr class="{{ $call->was_called ? 'positive' : ($call->from >= new DateTime()) ? 'active' : 'negative' }}">
      <td>
        {{ $call->created_at }}</a>
      </td>
      <td>
        {{ $call->from }}</a>
      </td>
      <td>
        {{ $call->to }}</a>
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="green {{ $call->was_called ? 'active ' : '' }}popup item"{{ $call->was_called ? '' : ' href="/clinic/calls/' . $call->id . '/called"' }} data-content="{{ trans('main.callIsCompleted') }}">
            <i class="check circle icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="4" class="center aligned">{{ trans('main.clientHasNotAnyCall') }}</td>
    </tr>
    @endif
  </tbody>
</table>
@stop