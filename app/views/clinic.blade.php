<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>MedoPlus.dev</title>
  <link rel="stylesheet" type="text/css" href="/jquery/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="/jquery/jquery-ui.theme.css">
  <link rel="stylesheet" type="text/css" href="/semantic/semantic.css">
  <link rel="stylesheet" type="text/css" href="/css/clinic.css">
  <script src="/jquery/jquery-2.1.3.min.js"></script>
  <script src="/jquery/jquery-ui.js"></script>
  <script src="/jquery/jquery-ui.datepicker-ru.js"></script>
  <script src="/semantic/semantic.js"></script>
  <script src="/js/clinic.js"></script>
  <script>
  	clinic.callsCount = {{ $calls_count }};
  </script>
  @yield('head')
</head>
<body>
	<div class="ui grid page" style="padding: 0 0; height: 100%;">
		<div class="ui bottom fixed menu navbar page grid">
            <a href="/clinic/calls" class="{{ $calls_count ? 'red ' : '' }}item active" id="callsMenuItem">
            	<i class="mobile icon"></i> Звонки<div class="ui red label{{ $calls_count ? '' : ' hidden' }}" id="callsMenuItemText">{{ $calls_count ? $calls_count : '' }}</div>
           	</a>
            <!-- <a href="" class="active item">Home</a>
            <a href="" class="item">About</a>
            <a href="" class="item">Contact --></a>
            <!-- <div class="right menu">
                <a href="" class="active item">Default</a>
                <a href="" class="item">Static top</a>
                <a href="" class="item">Fixed top</a>
            </div> -->
        </div>
		<div class="one wide column">

		</div>
		<div class="three wide column">
			
		</div>
		<div class="eight wide column" id="clinic" style="height: 100%;">
			<div class="left ui rail">
				@yield('left_rail')
			</div>
			<div class="ui menu">
				<div class="menu">
					<a class="item{{ strpos(Request::path(), 'clinic/clients') === 0 ? ' active' : '' }}" href="/clinic/clients">
						<i class="users icon"></i> Клиенты
					</a>
					<a class="item{{ strpos(Request::path(), 'clinic/catalogs') === 0 ? ' active' : '' }}" href="/clinic/catalogs">
						<i class="list icon"></i> Списки
					</a>
					<a class="item{{ strpos(Request::path(), 'clinic/doctors') === 0 ? ' active' : '' }}" href="/clinic/doctors">
						<i class="doctor icon"></i> Врачи
					</a>
					<a class="item{{ strpos(Request::path(), 'clinic/notifications') === 0 ? ' active' : '' }}" href="/clinic/notifications">
						<i class="mail icon"></i> Уведомления
					</a>
				  	<div class="right menu">
				  		<div class="item">
					    	<div class="ui transparent dropdown fluid search icon input">
					        	<input type="text" class="prompt" placeholder="Поиск..."{{ (Request::path() == 'panel/search' && Input::has('query')) ? ' value="' . Input::get('query') . '"' : ''}}>
					        	<i class="search link icon"></i>
					        	<div class="results"></div>
					      	</div>
					    </div>
					    <div class="item">
					    	<a href="/clinic/logout">
					    		<i class="sign out icon"></i> Выход
					    	</a>
					    </div>
				  	</div>
				</div>
			</div>
			@yield('content')
			<div class="right ui rail">
				<div class="ui sticky">
					<p></p>
					<p></p>
					<p></p>
					<div class="ui fluid vertical menu">
					  <div class="header item">
					    <i class="indent icon"></i> Временный список клиентов
					  </div>
					  <a class="item{{ Request::path() == 'clinic/tempcatalog' ? ' active' : '' }}" href="/clinic/tempcatalog">
					  	Клиенты
					  	<div class="ui teal label">{{ $temp_catalog }}</div>
					  </a>
					  <a class="item" href="/clinic/notifications/create?source=tempcatalog">
					    <i class="mail outline icon"></i> Отправить уведомление клиентам
					  </a>
					  <a class="item" href="/clinic/catalogs/add?source=tempcatalog">
					    <i class="save icon"></i> Сохранить список клиентов
					  </a>
					  <a class="item" href="/clinic/tempcatalog/clear">
					    <i class="trash icon"></i> Очистить список клиентов
					  </a>
					</div>
				</div>
			</div>
		</div>
		<div class="three wide column">
			
		</div>
		<div class="one wide column">

		</div>
	</div>
</body>

</html>
