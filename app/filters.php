<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth.clinic', function()
{
	if (!Auth::check() || !Auth::user()->relation instanceof Clinic)
	{
		if (Request::method() == 'POST')
		{
			if (!Input::has('id') || !Input::has('password'))
			{
				return View::make('clinic.login', ['error' => 'Пожалуйста, заполните все поля']);
			}

			if (!$clinic = Clinic::find(Input::get('id')))
			{
				return View::make('clinic.login', ['error' => 'Клиника с таким ID не найдена в системе']);
			}

			if ($clinic->password != Input::get('password'))
			{
				return View::make('clinic.login', ['error' => 'Неверный пароль']);
			}

			if (!$clinic->user)
			{
				return View::make('clinic.login', ['error' => 'Техническая ошибка: клиника не имеет пользователя']); 
			}
			
			Auth::login($clinic->user, true);
			return Redirect::to('/clinic');
		}

		return View::make('clinic.login');
	}
});

Route::filter('auth.client', function()
{
	if (!Input::has('token'))
	{
		if (!Input::has('phone'))
		{
			return Response::json(['auth' => ['status' => 1, 'error' => 'Необходим идентификатор клиента в виде его телефонного номера']])
				->setCallback(Input::get('callback'));
		}

		$rules =
		[
			'phone' => 'required|regex:/\+7[0-9]{10}/',
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			$messages = $validator->messages();
			
			if ($messages->has('phone'))
			{
				$errors['phone'] = $messages->first('phone');
			}

			return Response::json(['auth' => ['status' => 1, 'error' => $errors]])
				->setCallback(Input::get('callback'));
		}

		if (!$authCode = AuthCode::where('phone', Input::get('phone'))->first())
		{
			$authCode = new AuthCode;
			$authCode->phone = Input::get('phone');
			$authCode->code = mt_rand(1000, 9999);
			$authCode->save();
			
			if (!$smsResult = file_get_contents('http://api.iqsms.ru/messages/v2/send/?login=z1424695601470&password=330539&phone=' . urlencode(Input::get('phone')) . '&text=' . $authCode->code))
			{
				return Response::json(['auth' => ['status' => 7, 'error' => 'Ошибка отправки СМС']])
					->setCallback(Input::get('callback'));
			}

			return Response::json(['auth' => ['status' => 2, 'info' => $smsResult]])
				->setCallback(Input::get('callback'));
		}

		if (!Input::has('code'))
		{
			return Response::json(['auth' => ['status' => 3, 'error' => 'Необходимо ввести код СМС']])
				->setCallback(Input::get('callback'));
		}

		if ($authCode->code != Input::get('code'))
		{
			return Response::json(['auth' => ['status' => 4, 'error' => 'Неверный код СМС']])
				->setCallback(Input::get('callback'));
		}

		// $authCode->delete();

		if (!Input::has('device_type') || !Input::has('device_token'))
		{
			return Response::json(['auth' => ['status' => 7, 'error' => 'device_type or/and device_token are not found']])
				->setCallback(Input::get('callback'));
		}

		if (!$client = Client::where('phone', Input::get('phone'))->first())
		{
			$client = new Client;
			$client->phone = Input::get('phone');
			$client->save();
		}

		if (!$client->user)
		{
			$user = new User;
			$user->relation_type = 'Client';
			$user->relation_id = $client->id;
			Auth::login($user, true);
			$client->user = $user;
		}

		if (!$client->devices()->where('type', Input::get('device_type'))->where('token', Input::get('device_token'))->first())
		{
			$device = new Device;
			$device->type = Input::get('device_type');
			$device->token = Input::get('device_token');
			$device->client_id = $client->id;
			$device->save();
		}
		
		return Response::json(['auth' => ['status' => 0, 'token' => $client->user->getRememberToken()]])
			->setCallback(Input::get('callback'));
	}

	if (!$user = User::where('remember_token', Input::get('token'))->first())
	{
		return Response::json(['auth' => 6, ['status' => 6, 'error' => 'Неверный токен авторизации']])
			->setCallback(Input::get('callback'));
	}

	Auth::login($user);
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
