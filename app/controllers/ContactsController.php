<?php

class ContactsController extends \BaseController {

	protected $rules = [
		'name'      => 'required:min:3',
		'surname'   => 'required:min:3',
		'email'     => 'required|email',
		'phone'     => 'required'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::User()) {
			$contacts = Auth::User()->contacts()->get();
			return View::make('contacts.show')->with('contacts', $contacts);
		} else {
			return Redirect::to('/auth/login')->with('message', 'You need to be logged in to view contacts');
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		dd('show create form');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), $this->rules);
		if ($validator->fails()) {
			return Response::json( ["error",$validator->messages()] );
		} else {
			$contact = new Contact(Input::all());
			Auth::User()->contacts()->save($contact);
			Queue::push('activeCampaignWorker@storeProcess', $contact);
			return Response::json( ["ok",""] );
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		dd("show contact $id");
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$contact = Contact::findOrFail($id);
		if ($contact->user->id == Auth::User()->id) {
			return Response::json(["ok", $contact]);
		} else {
			return Response::json(["error", "Contact doesn't exist or not from the authenticaded user."]);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$contact = Contact::findOrFail($id);
		if ($contact->user->id == Auth::User()->id) {
			$validator = Validator::make(Input::all(), $this->rules);
			if ($validator->fails()) {
				return Response::json( ["error",$validator->messages()] );
			} else {
				$contact->update(Input::all());
				Queue::push('activeCampaignWorker@updateProcess', $contact);
				return Response::json(["ok", ""]);
			}
		} else {
			return Response::json(["error", "Contact doesn't exist or not from the authenticaded user."]);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$contact = Contact::findOrFail($id);
		if ($contact->user->id == Auth::User()->id) {
			$contact->delete();
			Queue::push('activeCampaignWorker@deleteProcess', $contact);
			return Response::json(["ok",""]);
		} else {
			return Response::json(["error", "Contact doesn't exist or not from the authenticaded user."]);
		}
	}


	/**
	 * Javascript code don't need to know details about MySQL's FTS.
	 * 'asterisk' the search items to better FT search them and substitute @'s.
	 *
	 * @param  string  $search
	 * @return JSON
	 */
	public function prepFTS($words)
	{
		$wordList = explode(' ', $words);
		$searchList = [];
		foreach($wordList as $w) {
			$searchList[] = trim(str_replace('@', '.', $w)).'*';
		}
		return implode(' ', $searchList);
	}


	/**
	 * AJAX Search method
	 *
	 * @param  string  $search
	 * @return JSON
	 */
	public function search()
	{
		$input = Input::all();
		if (array_key_exists('search', $input) && $input['search']) {
			$search = $this->prepFTS($input['search']);
			$contacts = Auth::User()->contacts()->whereRaw(
				'MATCH (name, surname, email, phone, field1, field2, field3, field4, field5) AGAINST ("'.$search.'" IN BOOLEAN MODE)'
				)->get()->toArray();
		} else {
			$contacts = Auth::User()->contacts()->get()->toArray();
		}
		return Response::json($contacts);
	}


}
