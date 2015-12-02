<?php

use User;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	 * attributes that are mass assignable
	 *
	 * @var array
	 */
	protected $fillable = array(
		'email',
		'avatar',
		'provider',
		'provider_id',
		'token',
		'token_secret',
		'password'
	);

	/*
	 * A User has many contacts
	 *
	 * @return Contact
	 */
	public function contacts()
	{
		return $this->hasMany('Contact');
	}

}
