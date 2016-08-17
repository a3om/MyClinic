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
        Название
      </th>
      <!-- <th>
        Число клиентов
      </th> -->
      <th class="center aligned">
        Опции
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($catalogs))
    @foreach ($catalogs as $catalog)
    <tr>
      <td class="">
        <i class="list icon"></i> <a href="/clinic/catalogs/{{ $catalog->id }}">{{ $catalog->name }}</a>
      </td>
      <td class="right aligned collapsing">
        <div class="ui icon menu">
          <a class="red{{ $catalog->clients->count() ? '' : ' disabled'}} popup item"{{ $catalog->clients->count() ? ' href="/clinic/notifications/create?source=catalog&source_id=' . $catalog->id . '" data-content="Отправить клиентам из списка уведомление"' : ''}}>
            <i class="mail outline icon"></i>
          </a>
          <a class="green popup item" data-content="Добавить клиентов этого списка во временный список" href="/clinic/catalogs/{{ $catalog->id }}/addToTempcatalog">
            <i class="sign in icon"></i>
          </a>
          <a class="green popup item" data-content="Удалить клиентов этого списка из временного списока" href="/clinic/catalogs/{{ $catalog->id }}/removeFromTempcatalog">
            <i class="sign out icon"></i>
          </a>
          <a class="red popup item" data-content="Удалить список клиентов" href="/clinic/catalogs/{{ $catalog->id }}/delete">
            <i class="remove icon"></i>
          </a>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="3" class="center aligned">В системе нет ни одного списка</td>
    </tr>
    @endif
  </tbody>
</table>
<div align="center">{{ $catalogs->links() }}</div>
@stop