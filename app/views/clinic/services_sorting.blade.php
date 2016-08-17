@extends('clinic')
@section('head')
<script type="text/javascript" src="/jquery/jquery.rowsorter.min.js"></script>
<script type="text/javascript">
var services = {{ $services->toJson() }};
var saveServicesTimeout = null;

$(function() {
  $('#services').rowSorter({
      onDrop: function(tbody, row, newIndex, oldIndex) {
          $('#services').css({backgroundColor: '#fcfffc'});
          if (saveServicesTimeout) {
            clearTimeout(saveServicesTimeout);
            saveServicesTimeout = null;
          }
          saveServicesTimeout = setTimeout(function() {
            var update = []; // 32514
            $('#services tr').each(function() {
              if (!$(this).attr('data-id')) {
                return;
              }
              update.push($(this).attr('data-id'));
            });
            $.ajax({
                method: 'POST',
                url: '/clinic/services/updateIndexes',
                data: {'update': update},
            }).done(function(data) {
                if (!data.success) {
                    console.log(data);
                    $('#services').css({backgroundColor: '#efd8d8'}).animate({backgroundColor: '#eaf6eb'}, 'slow');
                    return;
                }
                $('#services').css({backgroundColor: '#daefd8'}).animate({backgroundColor: '#ffffff'}, 'slow');
            });
          }, 500);
      },
  });
});
</script>
@stop
@section('sidebar')
<a class="item" href="/clinic/services/add">
  <i class="add icon"></i> {{ trans('main.addService') }}
</a>
@stop
@section('content')
<h3 class="ui block attached top header" style="background-color: white;">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/services">{{ trans('main.services') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.sorting') }}</div>
  </div>
</h3>
<table class="ui celled striped bottom attached centered table" id="services">
  <thead>
    <tr>
      <th>
      	{{ trans('main.name') }}
      </th>
    </tr>
  </thead>
  <tbody id="services">
    @if (count($services))
    @foreach ($services as $service)
    <tr data-id="{{ $service->id }}">
      <td>
        <i class="share alternate icon"></i> <a href="/clinic/services/{{ $service->id }}">{{ $service->name }}</a>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="2" class="center aligned">{{ trans('main.noServices') }}</td>
    </tr>
    @endif
  </tbody>
</table>
@stop