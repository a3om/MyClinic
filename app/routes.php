<?php

View::creator('clinic', function($view)
{
    $view->with('temp_catalog', TempCatalog::where('clinic_id', Auth::user()->relation->id)->count());
    $view->with('calls_count', Call::where('clinic_id', Auth::user()->relation->id)->where('was_called', false)->count());
});

Route::get('/', function() {

	// $user = User::find(2);
	// Auth::login($user, true);
	// Auth::logout();
	// print_r(Auth::check());

	$faker = Faker\Factory::create();
	Eloquent::unguard();

	// for($i = 0; $i < 1000; ++$i)
	// {
	// 	$client = Client::find($i + 1);
	// 	$client->phone = $faker->phoneNumber;
	// 	$client->save();
	// }
	// [
		// 'first_name' => $faker->firstName,
		// 'last_name' => $faker->lastName,
		// 'patronymic' => $faker->lastName,
		// 'sex' => $faker->numberBetween($min = 0, $max = 1),
		// 'birthday' => $faker->dateTimeThisCentury,
	// ]);

	// for ($i = 1; $i <= 100; ++$i)
	// {
	// 	$doctor = Doctor::find($i);
	// 	$doctor->description = $faker->text(500);
	// 	$doctor->save();
	// }

	// for ($i = 2; $i <= 25; ++$i)
	// {
	// 	Speciality::find($i)->doctors()->attach(1);
	// }

	return 'We\'re just working...';

	// Doctor::create([
	// 	'first_name' => $faker->firstName,
	// 	'last_name' => $faker->lastName,
	// 	'patronymic' => $faker->lastName,
	// 	'photo' => $faker->imageUrl(400, 400, 'cats'),
	// 	'phone' => $faker->phoneNumber,
	// 	'address' => $faker->address,
	// 	'description' => $faker->text(500),
	// 	'clinic_id' => 1,
	// ]);

	// Clinic::create([
	// 	'address' => $faker->address,
	// 	'latitude' => $faker->latitude,
	// 	'longitude' => $faker->longitude,
	// 	'email' => $faker->email,
	// 	'phone1' => $faker->phoneNumber,
	// 	'phone2' => $faker->phoneNumber,
	// 	'phone3' => $faker->phoneNumber,
	// 	'password' => $faker->word,
	// ]);

	// Service::create([
	// 	'name' => $faker->sentence(3),
	// 	'description' => $faker->text(500),
	// 	'clinic_id' => 1,
	// ]);

	// Speciality::create([
	// 	'name' => $faker->sentence(3),
	// 	'clinic_id' => 1,
	// ]);



	// $clinic = Clinic::find(1);

	// for ($i = 1; $i <= 1000; ++$i)
	// 	$clinic->clients()->attach($i);
});

Route::group(['prefix' => 'clinics/{id}'], function()
{
	Route::any('', function($id)
	{
		if (!$clinic = Clinic::with('doctors', 'specialities', 'services', 'specialities.doctors', 'services.doctors')->find($id))
		{
			return;
		}

		$clinic = $clinic->toArray();

		foreach ($clinic['specialities'] as &$speciality)
		{
			foreach ($speciality['doctors'] as &$doctor)
			{
				$doctor = $doctor['id'];
			}
		}

		foreach ($clinic['services'] as &$speciality)
		{
			foreach ($speciality['doctors'] as &$doctor)
			{
				$doctor = $doctor['id'];
			}
		}

		// return print_r($clinic, true);
		return Response::json($clinic)
					->setCallback(Input::get('callback'));
	});
});

Route::group(['prefix' => 'clinic', 'before' => 'auth.clinic'], function()
{
	Route::group(['prefix' => 'calls'], function()
	{
		Route::any('countUncalled', function()
		{
			$count = Auth::user()->relation->calls()->where('was_called', false)->count();
			return Response::json(['count' => $count])
				->setCallback(Input::get('callback'));
		});

		Route::group(['prefix' => '{id}'], function()
		{
			Route::any('called', function($id)
			{
				if($call = Auth::user()->relation->calls()->where('calls.id', $id)->first())
				{
					if (!$call->was_called)
					{
						$call->was_called = true;
						$call->save();
					}
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});
		});

		Route::any('', function()
		{
			$query = Auth::user()->relation->calls()->with('client')->where('was_called', false)->orderBy('id', 'desc');
			$calls = $query->get();
			return View::make('clinic.calls', ['calls' => $calls]);
		});
	});

	Route::group(['prefix' => 'clients'], function()
	{
		Route::any('add', function()
		{
			if (Request::method() == 'POST')
			{
				$rules =
				[
					'phone' => 'required|regex:/\+7[0-9]{10}/',
				];

				$validator = Validator::make(Input::all(), $rules);

				if (!$validator->fails())
				{
					if (!$client = Client::where('clients.phone', Input::get('phone'))->first())
					{
						$rules =
						[
							'last_name' => 'required',
							'first_name' => 'required',
							'patronymic' => 'required',
							'sex' => 'required|between:0,1',
							'birthday' => 'required|date_format:d.m.Y',
						];

						$validator = Validator::make(Input::all(), $rules);

						if (!$validator->fails())
						{
							$client = new Client;
							$client->phone = Input::get('phone');
							$client->last_name = Input::get('last_name');
							$client->first_name = Input::get('first_name');
							$client->patronymic = Input::get('patronymic');
							$client->sex = Input::get('sex');
							$client->birthday = new DateTime(Input::get('birthday'));
							$client->save();
							Auth::user()->relation->clients()->attach($client->id, ['active' => 1]);
							return Redirect::to('/clinic/clients/' . $client->id);
						}

						return Redirect::to('/clinic/clients/add')->withErrors($validator->messages())->withInput()->with('nonExistent', true);
					}

					if (Auth::user()->relation->clients->contains($client->id))
					{
						$messages = $validator->messages();
						$messages->add('phone', 'Клиент с таким телефоном уже существует');
						return Redirect::to('/clinic/clients/add')->withErrors($messages)->withInput();
					}

					Auth::user()->relation->clients()->attach($client->id, ['active' => 1]);
					return Redirect::to('/clinic/clients/' . $client->id);
				}

				return Redirect::to('/clinic/clients/add')->withErrors($validator->messages())->withInput();
			}

			return View::make('clinic.clients_add');
		});

		Route::group(['prefix' => '{id}'], function()
		{
			Route::get('addToTempcatalog', function($id)
			{
				if($client = Auth::user()->relation->clients()->where('clients.id', $id)->first())
				{
					if($client->pivot->active && !$client->tempcatalog)
					{
						$tempcatalog = new TempCatalog();
						$tempcatalog->client_id = $client->id;
						$tempcatalog->clinic_id = Auth::user()->relation->id;
						$tempcatalog->save();
					}
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

			Route::get('removeFromTempcatalog', function($id)
			{
				if($client = Auth::user()->relation->clients()->find($id))
				{
					if($client->tempcatalog)
					{
						$client->tempcatalog->delete();
					}
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

			Route::get('removeFromCatalog', function($id)
			{
				if($client = Auth::user()->relation->clients()->find($id))
				{
					if($catalog = Auth::user()->relation->catalogs()->find(Input::get('catalog_id')))
					{
						$catalog->clients()->detach($client->id);
					}
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

			Route::get('disable', function($id)
			{
				if($client = Auth::user()->relation->clients()->where('clients.id', $id)->first())
				{
					if ($client->pivot->active)
					{
						$client->pivot->active = 0;
						$client->pivot->save();
						$client->catalogs()->detach();

						if ($client->tempcatalog)
						{
							$client->tempcatalog->delete();
						}
					}
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

			Route::get('enable', function($id)
			{
				if($client = Auth::user()->relation->clients()->where('clients.id', $id)->first())
				{
					if (!$client->pivot->active)
					{
						$client->pivot->active = 1;
						$client->pivot->save();
					}
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

			Route::any('', function($id)
			{
				if($client = Auth::user()->relation->clients()->where('clients.id', $id)->first())
				{
					if (Request::method() == 'POST')
					{
						$rules =
						[
							'phone' => 'required|regex:/\+7[0-9]{10}/',
							'first_name' => 'required',
							'last_name' => 'required',
							'patronymic' => 'required',
							'sex' => 'required|between:0,1',
							'birthday' => 'required|date_format:d.m.Y',
						];

						$validator = Validator::make(Input::all(), $rules);

						if (!$validator->fails())
						{
							if (Client::where('phone', Input::get('phone'))->where('id', '!=', $client->id)->first())
							{
								$messages = $validator->messages();
								$messages->add('phone', 'Клиент с таким телефоном уже существует');
								return Redirect::to('/clinic/clients/' . $id)->withErrors($messages)->withInput();
							}

							$client->phone = Input::get('phone');
							$client->last_name = Input::get('last_name');
							$client->first_name = Input::get('first_name');
							$client->patronymic = Input::get('patronymic');
							$client->sex = Input::get('sex');
							$client->birthday = new DateTime(Input::get('birthday'));
							$client->pivot->active = Input::get('activity');
							$client->pivot->save();
							$client->save();
							return Redirect::to('/clinic/clients/' . $id)->with('success', true);
						}

						return Redirect::to('/clinic/clients/' . $id)->withErrors($validator->messages())->withInput();
					}

					return View::make('clinic.client', ['client' => $client]);
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

		});

		Route::get('', function()
	    {
	    	$query = Auth::user()->relation->clients()->with('tempcatalog');
	    	// return $query->get();
	    	// return 1;

	    	if (Input::has('sex') && Input::get('sex') >= 0 && Input::get('sex') <= 1)
	    	{
	    		$query = $query->where('sex', Input::get('sex') ? 1 : 0);
	    	}

	    	if (Input::has('age_from'))
	    	{
	    		$query = $query->where(DB::raw('TIMESTAMPDIFF(YEAR, `birthday`, CURDATE())'), '>=', Input::get('age_from'));
	    	}

	    	if (Input::has('age_to'))
	    	{
	    		$query = $query->where(DB::raw('TIMESTAMPDIFF(YEAR, `birthday`, CURDATE())'), '<=', Input::get('age_to'));
	    	}

	    	if (Input::has('first_name'))
	    	{
	    		$query = $query->where('first_name', 'like', '%' . Input::get('first_name') . '%');
	    	}

	    	if (Input::has('last_name'))
	    	{
	    		$query = $query->where('last_name', 'like', '%' . Input::get('last_name') . '%');
	    	}

	    	if (Input::has('patronymic'))
	    	{
	    		$query = $query->where('patronymic', 'like', '%' . Input::get('patronymic') . '%');
	    	}

	    	if (Input::has('birthday'))
	    	{
	    		$query = $query->where('birthday', date('Y-m-d', strtotime(Input::get('birthday'))));
	    	}

	    	if (Input::has('activity') && Input::get('activity') >= 0 && Input::get('activity') <= 1)
	    	{
	    		$query = $query->where('active', Input::get('activity'));
	    	}

	    	$orders = ['first_name', 'last_name', 'patronymic', 'sex', 'birthday'];

	    	if (Input::has('order') && in_array(Input::get('order'), $orders))
	    	{
	    		$query = $query->orderBy(Input::get('order'), Input::get('order_reverse') ? 'desc' : 'asc');
	    	}

	    	$clients = $query->paginate(10);
	        return View::make('clinic.clients', ['clients' => $clients]);
	    });
	});

	Route::group(['prefix' => 'catalogs'], function()
	{
		Route::any('add', function()
		{
			$clients = [];

			switch (Input::old('source', Input::get('source')))
			{
				case 'tempcatalog':
				{
					foreach (Auth::user()->relation->tempcatalog()->with('client')->get() as $record)
					{
						$clients[] = $record->client;
					}

					break;
				}
			}

			if (Request::method() == 'POST')
			{
				$rules =
				[
					'name' => 'required',
				];

				$validator = Validator::make(Input::all(), $rules);

				if (!$validator->fails())
				{
					$catalog = new Catalog;
					$catalog->name = Input::get('name');
					$catalog->clinic_id = Auth::user()->relation->id;
					$catalog->save();

					foreach ($clients as $client)
					{
						$catalog->clients()->attach($client->id);
					}

					return Redirect::to('/clinic/catalogs/' . $catalog->id);
				}

				return Redirect::to('/clinic/catalogs/add')->withErrors($validator->messages())->withInput();
			}

			return View::make('clinic.catalogs_add', ['clients' => $clients]);
		});

		Route::group(['prefix' => '{id}'], function()
		{
			Route::get('addToTempcatalog', function($id)
			{
				if($catalog = Auth::user()->relation->catalogs()->find($id))
				{
					$records = TempCatalog::all();

					foreach ($catalog->clients as $client)
					{
						$exists = false;

						foreach ($records as $record)
						{
							if ($record->client_id != $client->id)
							{
								continue;
							}

							$exists = true;
							break;
						}

						if ($exists)
						{
							continue;
						}

						$record = new TempCatalog;
						$record->client_id = $client->id;
						$record->clinic_id = Auth::user()->relation->id;
						$record->save();
					}
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

			Route::get('removeFromTempcatalog', function($id)
			{
				if($catalog = Auth::user()->relation->catalogs()->find($id))
				{
					$records = TempCatalog::all();

					foreach ($catalog->clients as $client)
					{
						$exists = null;

						foreach ($records as $record)
						{
							if ($record->client_id != $client->id)
							{
								continue;
							}

							$exists = $record;
							break;
						}

						if (!$exists)
						{
							continue;
						}

						$exists->delete();
					}
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

			Route::get('delete', function($id)
			{
				if($catalog = Auth::user()->relation->catalogs()->find($id))
				{
					$catalog->clients()->detach();
					$catalog->delete();
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

			Route::any('', function($id)
			{
				if ($catalog = Auth::user()->relation->catalogs()->find($id))
				{
					if (Request::method() == 'POST')
					{
						$rules =
						[
							'name' => 'required',
						];

						$validator = Validator::make(Input::all(), $rules);

						if (!$validator->fails())
						{
							$catalog->name = Input::get('name');
							$catalog->save();
							return Redirect::to('/clinic/catalogs/' . $id)->with('success', true);
						}

						return Redirect::to('/clinic/catalogs/' . $id)->withErrors($validator->messages())->withInput();
					}

					$query = $catalog->clients()->with('tempcatalog');

					if (Input::has('sex') && Input::get('sex') >= 0 && Input::get('sex') <= 1)
			    	{
			    		$query = $query->where('sex', Input::get('sex') ? 1 : 0);
			    	}

			    	if (Input::has('age_from'))
			    	{
			    		$query = $query->where(DB::raw('TIMESTAMPDIFF(YEAR, `birthday`, CURDATE())'), '>=', Input::get('age_from'));
			    	}

			    	if (Input::has('age_to'))
			    	{
			    		$query = $query->where(DB::raw('TIMESTAMPDIFF(YEAR, `birthday`, CURDATE())'), '<=', Input::get('age_to'));
			    	}

			    	if (Input::has('first_name'))
			    	{
			    		$query = $query->where('first_name', 'like', '%' . Input::get('first_name') . '%');
			    	}

			    	if (Input::has('last_name'))
			    	{
			    		$query = $query->where('last_name', 'like', '%' . Input::get('last_name') . '%');
			    	}

			    	if (Input::has('patronymic'))
			    	{
			    		$query = $query->where('patronymic', 'like', '%' . Input::get('patronymic') . '%');
			    	}

			    	if (Input::has('birthday'))
			    	{
			    		$query = $query->where('birthday', date('Y-m-d', strtotime(Input::get('birthday'))));
			    	}

					$clients = $query->paginate(10);
					return View::make('clinic.catalog', ['catalog' => $catalog, 'clients' => $clients]);
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});
		});

		Route::get('', function()
	    {
	    	$catalogs = Auth::user()->relation->catalogs()->orderBy('id', 'desc')->with('clients')->paginate(10);
	        return View::make('clinic.catalogs', ['catalogs' => $catalogs]);
	    });
	});

	Route::group(['prefix' => 'tempcatalog'], function()
	{
		Route::get('', function()
		{
			$query = Auth::user()->relation->tempcatalog()->with('client');
			$records = $query->paginate(10);
			return View::make('clinic.tempcatalog', ['records' => $records]);
		});

		Route::get('clear', function()
		{
			Auth::user()->relation->tempcatalog()->delete();

			if (!Request::header('referer'))
			{
				return Redirect::to('/clinic');
			}

			return Redirect::back();
		});
	});

	Route::get('search', function()
	{
		if (Input::has('query'))
		{
			$query = Input::get('query');
			$clients = Auth::user()->relation->clients()
				->where('first_name', 'like', '%' . $query . '%')
				->orWhere('last_name', 'like', '%' . $query . '%')
				->orWhere('patronymic', 'like', '%' . $query . '%')
				->orWhere('phone', 'like', '%' . $query . '%')
				->orWhere('birthday', date('Y-m-d', strtotime($query)))
				->get();
		}
		else
		{
			$clients = [];
		}

		// return print_r(json_decode($clients), true);
		$results = [];

		foreach ($clients as $client)
		{
			$results[] =
			[
				'client_id' => $client->id,
				'title' => $client->last_name . ' ' . $client->first_name,
				'description' => $client->patronymic . '<br /><i>' . $client->phone . '</i>',
			];
		}

		if (Request::ajax())
		{
		    return ['results' => $results];
		}

		return View::make('panel.search', ['clients' => $clients]);
	});

	Route::group(['prefix' => 'notifications'], function()
	{
		Route::any('create', function()
		{
			if (!Input::has('source'))
			{
				return;
			}

			$clients = [];
			$text = '';

			switch (Input::get('source'))
			{
				case 'client':
				{
					if (!Input::has('source_id'))
					{
						return;
					}

					if (!$client = Auth::user()->relation->clients()->where('clients.id', Input::get('source_id'))->first())
					{
						return;
					}
					
					$clients[] = $client;
					break;
				}
				case 'catalog':
				{
					if (!Input::has('source_id'))
					{
						return;
					}

					if (!$catalog = Auth::user()->relation->catalogs()->with('clients')->where('catalogs.id', Input::get('source_id'))->first())
					{
						return;
					}

					foreach ($catalog->clients as $client)
					{
						$clients[] = $client;
					}

					break;
				}
				case 'notification':
				{
					if (!Input::has('source_id'))
					{
						return;
					}

					if (!$notification = Auth::user()->relation->notifications()->with('clients')->where('notifications.id', Input::get('source_id')))
					{
						return;
					}

					foreach ($notification->clients as $client)
					{
						$clients[] = $client;
					}

					$text = $notification->text;
					break;
				}
				case 'tempcatalog':
				{
					foreach (Auth::user()->relation->tempcatalog()->with('client')->get() as $record)
					{
						$clients[] = $record->client;
					}

					break;
				}
				default:
				{
					return;
				}
			}

			if (count($clients))
			{
				if (Input::has('text'))
				{
					$notification = new Notification;
					$notification->text = Input::get('text');
					$notification->clinic_id = Auth::user()->relation->id;
					$notification->save();

					foreach ($clients as $client)
					{
						$client->notifications()->attach($notification->id);
					}

					$clients_ids = [];

					foreach ($clients as $client)
					{
						$clients_ids[] = $client->id;
					}
					
					$devices = Device::whereIn('client_id', $clients_ids)->get();
					$appleDevices = [];
					$androidDevices = [];

					foreach ($devices as $device)
					{
						if ($device->type == 0)
						{
							$appleDevices[] = PushNotification::Device($device->token);
						}
						else if ($device->type == 1)
						{
							$androidDevices[] = PushNotification::Device($device->token);
						}
					}

					$message = PushNotification::Message($notification->text,
					[
					    'badge' => 1,
					    'sound' => 'bingbong.aiff',
					]);
					PushNotification::app('appNameIOS')
					    ->to(PushNotification::DeviceCollection($appleDevices))
					    ->send($message);
					
					return Redirect::to('/clinic/notifications/' . $notification->id);
				}
			}

			return View::make('clinic.notifications_create', ['clients' => $clients, 'text' => $text]);
		});

		Route::get('{id}', function($id)
		{
			if (!$notification = Auth::user()->relation->notifications()->find($id))
			{
				return;
			}

			return View::make('clinic.notification', ['notification' => $notification]);
		});

		Route::get('', function()
		{
			$query = Auth::user()->relation->notifications()->orderBy('id', 'desc');

			if (Input::has('text'))
	    	{
	    		$query = $query->where('text', 'like', '%' . Input::get('text') . '%');
	    	}

			$notifications = $query->paginate(10);
			return View::make('clinic.notifications', ['notifications' => $notifications]);
		});
	});

	Route::group(['prefix' => 'doctors'], function()
	{
		Route::any('add', function()
		{
			if (Request::method() == 'POST')
			{
				$rules =
				[
					'first_name' => 'required',
					'last_name' => 'required',
					'patronymic' => 'required',
					'description' => 'required',
				];

				$validator = Validator::make(Input::all(), $rules);

				if (!$validator->fails())
				{
					$doctor = new Doctor;
					$doctor->last_name = Input::get('last_name');
					$doctor->first_name = Input::get('first_name');
					$doctor->patronymic = Input::get('patronymic');
					$doctor->description = Input::get('description');
					$doctor->clinic_id = Auth::user()->relation->id;
					$doctor->save();
					return Redirect::to('/clinic/doctors/' . $doctor->id);
				}

				return Redirect::to('/clinic/doctors/add')->withErrors($validator->messages())->withInput();
			}

			return View::make('clinic.doctors_add');
		});

		Route::group(['prefix' => '{id}'], function()
		{
			Route::any('delete', function($id)
			{
				if($doctor = Auth::user()->relation->doctors()->find($id))
				{
					$doctor->delete();
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});

			Route::any('', function($id)
			{
				if($doctor = Auth::user()->relation->doctors()->where('doctors.id', $id)->first())
				{
					if (Request::method() == 'POST')
					{
						$rules =
						[
							'first_name' => 'required',
							'last_name' => 'required',
							'patronymic' => 'required',
							'description' => 'required',
							'sex' => 'required|between:0,1',
						];

						$validator = Validator::make(Input::all(), $rules);

						if (!$validator->fails())
						{
							$doctor->last_name = Input::get('last_name');
							$doctor->first_name = Input::get('first_name');
							$doctor->patronymic = Input::get('patronymic');
							$doctor->sex = Input::get('sex');
							$doctor->phone = Input::get('phone');
							$doctor->address = Input::get('address');
							$doctor->description = Input::get('description');
							$doctor->save();
							return Redirect::to('/clinic/doctors/' . $id)->with('success', true);
						}

						return Redirect::to('/clinic/doctors/' . $id)->withErrors($validator->messages())->withInput();
					}

					return View::make('clinic.doctor', ['doctor' => $doctor]);
				}

				if (!Request::header('referer'))
				{
					return Redirect::to('/clinic');
				}

				return Redirect::back();
			});
		});

		Route::any('', function()
		{
			$query = Auth::user()->relation->doctors();

			if (Input::has('first_name'))
	    	{
	    		$query = $query->where('first_name', 'like', '%' . Input::get('first_name') . '%');
	    	}

	    	if (Input::has('last_name'))
	    	{
	    		$query = $query->where('last_name', 'like', '%' . Input::get('last_name') . '%');
	    	}

	    	if (Input::has('patronymic'))
	    	{
	    		$query = $query->where('patronymic', 'like', '%' . Input::get('patronymic') . '%');
	    	}

			$doctors = $query->paginate(10);
			return View::make('clinic.doctors', ['doctors' => $doctors]);
		});
	});

	Route::any('logout', function()
	{
		if (Auth::check())
		{
			Auth::logout();
		}

		return Redirect::to('/clinic');
	});

    Route::any('', function()
	{
		return Redirect::to('/clinic/clients');
		return View::make('clinic.main');
	});
});

Route::group(['prefix' => 'client', 'before' => 'auth.client'], function()
{
	Route::any('logout', function()
	{
		if (Auth::check())
		{
			Auth::logout();
		}

		return Redirect::to('/client');
	});

	Route::any('edit', function()
	{
		if (!Auth::check())
		{
			return Response::json(['status' => 1])
				->setCallback(Input::get('callback'));;
		}

		$client = Auth::user()->relation;

		if (Input::has('last_name'))
		{
			$client->last_name = Input::get('last_name');
		}

		if (Input::has('first_name'))
		{
			$client->first_name = Input::get('first_name');
		}

		if (Input::has('patronymic'))
		{
			$client->patronymic = Input::get('patronymic');
		}

		if (Input::has('birthday'))
		{
			$client->birthday = new DateTime(Input::get('birthday'));
		}

		if (Input::has('sex'))
		{
			$client->sex = Input::get('sex');
		}
		
		$client->save();
		return Response::json(['status' => 0])
			->setCallback(Input::get('callback'));;
	});

	Route::any('call', function()
	{
		if (!Auth::check())
		{
			return Response::json(['status' => 1])
				->setCallback(Input::get('callback'));
		}

		$calls = Auth::user()->relation->calls()->where('calls.was_called', false)->get();

		if (count($calls) != 0)
		{
			return Response::json(['status' => 2])
				->setCallback(Input::get('callback'));
		}

		$call = new Call;
		$call->client_id = Auth::user()->relation->id;
		$call->clinic_id = 1;

		if (Input::has('place_type'))
		{
			$call->place_type = Input::get('place_type');

			if (Input::has('place_id'))
			{
				$call->place_id = Input::get('place_id');
			}
		}

		$call->save();
		return Response::json(['status' => 0])
			->setCallback(Input::get('callback'));
	});

	Route::group(['prefix' => 'notifications'], function()
	{
		Route::group(['prefix' => '{id}'], function()
		{
			Route::any('read', function($id)
			{
				if (!$notification = Auth::user()->relation->notifications()->where('notifications.id', $id)->first())
				{
					return Response::json(['status' => 1, 'error' => 'Not Found'])
					->setCallback(Input::get('callback'));
				}

				$notification->pivot->read = 1;
				$notification->pivot->save();
				return Response::json(['status' => 0])
					->setCallback(Input::get('callback'));
			});

			Route::any('answer', function($id)
			{
				if (!$notification = Auth::user()->relation->notifications()->where('notifications.id', $id)->first())
				{
					return Response::json(['status' => 1, 'error' => 'Not Found'])
					->setCallback(Input::get('callback'));
				}

				$notification->pivot->answer = 1;
				$notification->pivot->save();
				return Response::json(['status' => 0])
					->setCallback(Input::get('callback'));
			});
		});

		Route::any('', function()
		{
			$notifications = Auth::user()->relation->notifications()->orderBy('id', 'desc')->get();
			return Response::json($notifications)
					->setCallback(Input::get('callback'));
		});
	});

	Route::group(['prefix' => 'clinics'], function()
	{
		Route::any('add', function()
		{
			if (!Input::has('clinic_id'))
			{
				return Response::json(['status' => 1, 'error' => 'Field clinic_id is not found'])
					->setCallback(Input::get('callback'));
			}

			if (!$clinic = Clinic::find(Input::get('clinic_id')))
			{
				return Response::json(['status' => 2, 'error' => 'Clinic with this clinic_id doesnt exists'])
					->setCallback(Input::get('callback'));
			}

			if (Auth::user()->relation->clinics->contains($clinic->id))
			{
				return Response::json(['status' => 0, 'warning' => 'Client already has this clinic'])
					->setCallback(Input::get('callback'));
			}

			return Response::json(['status' => 0])
				->setCallback(Input::get('callback'));
		});

		Route::any('', function()
		{
			$notifications = Auth::user()->relation->notifications;
			return Response::json($notifications)
				->setCallback(Input::get('callback'));
		});
	});

	Route::any('', function()
	{
		$client = Auth::user()->relation()->first();
		return Response::json($client)
			->setCallback(Input::get('callback'));
	});
});

// Route::get('/', function()
// {
// 	$message = PushNotification::Message("1\r\n2\r\n3\r\n4\r\n5\r\n6\r\n7", array(
// 	    'badge' => 1234,
// 	    'sound' => 'example.aiff',
// 	));

// 	PushNotification::app('appNameIOS')
//             ->to('8226fed606ca4f172fc4ee4f33a9a45226bb275ec67f39b5e20cc9247529a8fe')
//             ->send($message);
// 	return View::make('hello');
// });
