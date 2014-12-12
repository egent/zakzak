<?php

class UsersController extends \BaseController {
	
	
	public function handleLogin()
	{
	
		$message = false;
		
		$credentials = Input::only(['email', 'password']);		
        
		$validator = Validator::make(
            $credentials,
            [
                'email' => 'required|email|min:8',
                'password' => 'required|min:5',
            ]
        );

        if($validator->fails()){
            return Redirect::route('login')->withErrors($validator)->withInput();
        }		
		
		
		
		try
		{
			$user = Sentry::authenticate($credentials, false);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			$message = 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			$message = 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
			$message = 'Wrong password, try again.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			$message = 'User was not found.';
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			$message = 'User is not activated.';
		}
		
		// The following is only required if the throttling is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
			$message = 'User is suspended.';
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
			$message = 'User is banned.';
		}		
		
		if ($message)
			return Redirect::route('login')->with('message',$message);			
		
		/* $user = User::login($data);

		if (!$user) 
		{ 
			
			return Redirect::route('login')->withInput()->with('message', Lang::get('messages.error'));
			//Session::flash('message', Lang::get('messages.error'));
		} */
		
        return Redirect::route('home');	
	}


	public function profile()
	{

		$user = Sentry::getUser();
		$user_id = $user->id;
				
		return View::make('users.profile')->with(['user_id' => $user_id, 'user' => $user]);
	}


	public function login()
	{
		return View::make('users.login');
	}
	
	public function logout()
	{
		if(Sentry::check())
		{
			Sentry::logout();
		}
		return Redirect::route('login');
	}	


	public function register()
	{
		return View::make('users.create');
	}


	public function registratioin()
	{
		
		//return 'is store!';
		
		$data = Input::only(['password','email']);
		$data['activated'] = true;
				
		$validator = Validator::make(
			$data,
			[
				'email' => 'required|email|min:5|unique:users',
				'password' => 'required|min:5',							
			]
		);
		
		if($validator->fails())
		{
			return Redirect::route('register')->withErrors($validator)->withInput();
		}	
		

		// пробуем зарегистрироваться
		try
		{
			$user = Sentry::createUser($data);
			Sentry::login($user, true);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			echo 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			echo 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			echo 'User with this login already exists.';
		}			


        return Redirect::route('home')->withInput();		
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		//
	}

	
	
	public function updateUser()
	{
		try
		{
			// Find the user using the user id
			$user = Sentry::getUser();
		
			// Update the user details
			// $user->email = 'john.doe@example.com';
			$user->first_name = 'Плеханов';
			$user->last_name = 'Сергей';
			// $user->phone = '79172421229';
		
			// Update the user
			if ($user->save())
			{
				echo 'Данные о пользователе изменены';
			}
			else
			{
				echo 'Ошибка!';
			}
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			echo 'User with this login already exists.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			echo 'User was not found.';
		}		
	}
	
	
	

	public function destroy($id)
	{
		//
	}


}