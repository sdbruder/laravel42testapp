<?php

class AuthController extends \BaseController {

	// URL to redirect to when logged in with success.
	public $redirectTo = '/contact';

	// login URL.
	public $loginURL = '/auth/login';

	/**
	 * get Login Form.
	 *
	 * @return Response
	 */
	public function getLogin()
	{
		return Response::view('auth.login');
	}

	/**
	 * process Login Form.
	 *
	 * @return Response
	 */
	public function postLogin()
	{
		$input = Input::all();
		if (array_key_exists('login', $input) && $input['login'])  {
			$ret = $this->doLogin($input);
		} else {
			$ret = $this->doRegister($input);
		}
		return $ret;
	}

	/**
	 * do Login process.
	 *
	 * @return Response
	 */
	public function doLogin($input)
	{
		if (Auth::attempt(['email' => $input['email'], 'password' => $input['password'], 'provider' => 'email'])) {
			return Redirect::to($this->redirectTo);
		} else {
			return Redirect::to($this->loginURL)->with('message', 'User not found or password incorrect.');
		}
	}

	/**
	 * do Logout process.
	 *
	 * @return Response
	 */
	public function getLogout()
	{
		if (Auth::User()) {
			Auth::logout();
			return Redirect::to($this->loginURL)->with('message', 'User logged out.');
		} else {
			return Redirect::to($this->loginURL)->with('message', 'User not found or password incorrect.');
		}
	}

	/**
	 * do Register process.
	 *
	 * @return Response
	 */
	public function doRegister($input)
	{
		if (User::where('provider_id', '=', $input['email'])->where('provider', '=', 'email')->count() == 0) {
			$user = User::create([
				'email'       => $input['email'],
				'password'    => Hash::make($input['password']),
				'provider'    => 'email',
				'provider_id' => $input['email']
			]);
			$user->save();
			Auth::login($user);
			return Redirect::to($this->redirectTo);
		} else {
			return Redirect::to($this->loginURL)->with('message', 'User already exists.');
		}
	}

	/**
	 * OAuth redirect to provider
	 *
	 * @return Response
	 */
	public function redirectToProvider($driver)
	{
		$oa = OAuth::consumer( $driver, url("/auth/$driver/callback") );
		// get provider authorization
		$url = $oa->getAuthorizationUri();
		// return to the provider login url
		Log::
		return Redirect::to( (string)$url );
	}


	/**
	 * OAuth Facebook User information method
	 *
	 * @return Array ['id','email']
	 */
	protected function getFacebookIdEmail($oa) {
		$result = json_decode( $oa->request( 'me?fields=name,email' ), true ); // get user info with it.
		return [
			'id'    => $result['id'],
			'email' => $result['email']
		];
	}

	/**
	 * OAuth Github User information method
	 *
	 * @return Array ['id','email']
	 */
	protected function getGithubIdEmail($oa) {
		$emails = json_decode( $oa->request( 'user/emails' ), true ); // get emails
		$result = json_decode( $oa->request( 'user' ), true ); //     get user info
		return [
			'id'    => $result['id'],
			'email' => $emails[0]
		];
	}


	/**
	 * OAuth handle provider Callback
	 *
	 * @return Response
	 */
	public function handleProviderCallback($driver)
	{
		$oa = OAuth::consumer( $driver, url("/auth/$driver/callback") );
		$code  = Input::get('code');
		$state = Input::get('state');
		if ($code) {
			$token = $oa->requestAccessToken( $code ); // get the token

			$idEmail = [
				'Facebook' => function($oa) { return $this->getFacebookIdEmail($oa);},
				'GitHub'   => function($oa) { return $this->getGithubIdEmail($oa);  },
			];
			$result = $idEmail[$driver]($oa); // better than a ugly switch.

			$user = User::where('provider', '=', $driver)->where('provider_id', '=', $result['id'])->get()->toArray();
			if ($user) {
				Auth::loginUsingId($user[0]['id']);
				return Redirect::to($this->redirectTo);
			} else {
				$user = User::create([
					'email'       => $result['email'],
					'provider'    => $driver,
					'provider_id' => $result['id'],
					'token'       => $token->getAccessToken()
				]);
				$user->save();
				Auth::login($user);
				return Redirect::to($this->redirectTo);
			}
		} else {
			return Redirect::to($this->loginURL)->with('message', 'OAuth login attempt without corresponding code.');
		}
	}

}
