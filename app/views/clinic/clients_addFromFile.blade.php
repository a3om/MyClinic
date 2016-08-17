@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  $('.submit').click(function() {
    $('.small.modal').modal('show');
    $('.confim').click(function() {
      $('.ui.form').submit();
    });
  });
  $(document).on('change', '.attachment.field > .input > .file', function() {
      var input = $(this);
      console.log(this);
      var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      // $('#file').attr('name', 'attachmentName'); // allow upload.
      $(this).parent().find('.name').val(label);
  });
});
</script>
@stop
@section('content')
<h3 class="ui top attached header">
  <div class="ui breadcrumb">
    <a class="section" href="/clinic/clients">Клиенты</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.additionOfClientsFromFile') }}</div>
  </div>
</h3>
<div class="ui small modal">
  <i class="close icon"></i>
  <div class="header">
    {{ trans('main.additionOfClientsFromFile') }}
  </div>
  <div class="content">
    <div class="description">
      <p><b>{{ trans('main.caution') }}!</b> {{ trans('main.additionSendMessageCautionToAll') }}!</p>
    </div>
  </div>
  <div class="actions">
    <div class="ui negative button">
      {{ trans('main.cancel') }}
    </div>
    <div class="ui positive right labeled icon button confim">
      {{ trans('main.add') }}
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>
<form class="ui warning success error form bottom attached segment" action="/clinic/clients/addFromFile" method="POST" enctype="multipart/form-data">
  @if(Session::has('success'))
  <div class="ui success message">
    <div class="header">
      {{ trans('main.addition') }}
    </div>
    <p>{{ Session::get('success') }}</p>
  </div>
  @endif
  <div class="{{ $errors->has('file') ? 'error ' : '' }}attachment field" style="display: ;">
    <div class="ui fluid action input">
      <input type="text" class="name" readonly />
      <label for="file" class="ui {{ $errors->has('file') ? 'red ' : '' }}icon button"><i class="file icon"{{ $errors->has('file') ? ' style="color: #dbb1b1;"' : '' }}></i></label>
      <input type="file" class="file" id="file" name="file" style="display: none;" />
    </div>
    @if($errors->has('file'))
    <div class="ui red pointing label">
      {{ $errors->first('file') }}
    </div>
    @endif
  </div>
  <div class="ui igonred warning message">
    <p><b>{{ trans('main.caution') }}!</b> {{ trans('main.additionSendMessageCautionToAll') }}!</p>
  </div>
  <div class="ui submit button">{{ trans('main.add') }}</div>
</form>
@stop