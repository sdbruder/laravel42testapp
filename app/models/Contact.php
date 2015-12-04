<?php

//use Contact;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Contact extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contacts';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	/**
	 * attributes that are mass assignable
	 *
	 * @var array
	 */
	protected $fillable = array(
		'user_id',
		'name',
		'surname',
		'email',
		'phone',
		'field1',
		'field2',
		'field3',
		'field4',
		'field5'
	);

	/**
	 * virtual field concatenating all extra fields
	 *
	 * @return string
	 */
	public function getExtraFieldsAttribute($value)
	{
		$result  = $this->attributes['field1'] ? $this->attributes['field1'] . ', ' : '';
		$result .= $this->attributes['field2'] ? $this->attributes['field2'] . ', ' : '';
		$result .= $this->attributes['field3'] ? $this->attributes['field3'] . ', ' : '';
		$result .= $this->attributes['field4'] ? $this->attributes['field4'] . ', ' : '';
		$result .= $this->attributes['field5'] ? $this->attributes['field5']        : '';
		return trim($result, ' ,');
	}

	/*
	 * A Contact belongs to a User
	 *
	 * @return User
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

}
