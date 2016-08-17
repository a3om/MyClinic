@extends('clinic')
@section('head')
<script type="text/javascript">
$(function() {
  $('.ui.submit').click(function() {
    $('.ui.form').submit();
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
    <a class="section" href="/clinic/tempcatalog">{{ trans('main.temporaryCatalog') }}</a>
    <div class="divider"> / </div>
    <div class="active section">{{ trans('main.additionOfClientsFromFile') }}</div>
  </div>
</h3>
<form class="ui success error form bottom attached segment" action="/clinic/tempcatalog/addFromFile" method="POST" enctype="multipart/form-data">
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
  <div class="ui submit button">{{ trans('main.add') }}</div>
</form>
@stop