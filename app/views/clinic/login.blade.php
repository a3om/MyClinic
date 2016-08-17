<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>MedoPlus.dev</title>
  <link rel="stylesheet" type="text/css" href="/semantic/semantic.min.css">
  <script src="/jquery/jquery-2.1.3.min.js"></script>
  <script src="/jquery/jquery-ui.js"></script>
  <script src="/semantic/semantic.min.js"></script>
  <script>
  	$(function() {
  		$('.ui.submit').click(function() {
  			$('.ui.form').submit();
  		});
  	});
  </script>
</head>
<body style="display: table; width: 100%;">
	<div style="display: table-cell; vertical-align: middle;">
		<div style="width: 360px; margin: -100px auto 0;">
			<div class="ui header top attached block segment">Авторизация клиники</div>
			<form class="ui attached error form segment" action="/clinic" method="post">
				@if (isset($error))
				<div class="ui error message">
					<div class="header">Ошибка входа</div>
					<p>{{ $error }}</p>
				</div>
				@endif
				<div class="two fields">
					<div class="field">
						<label>ID</label>
						<input placeholder="Введите ID" name="id" type="text"{{ Input::has('id') ? ' value="' . Input::get('id') . '"' : '' }}>
					</div>
					<div class="field">
						<label>Пароль</label>
						<input name="password" placeholder="********" type="password">
					</div>
				</div>
				<div class="ui submit button fluid">Войти</div>
			</form>
		</div>
	</div>
</body>
</html>