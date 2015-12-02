<?php

class ContactsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::User()) {
			$contacts = Auth::User()->contacts()->get();
			return View::make('contacts.show')->with('contacts',$contacts);
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
		dd('store contact');
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
		dd("edit contact $id");
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		dd("update contact $id");
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		dd("delete contact $id");
	}


	/**
	 * 'asterisk' the search items to better FT search them.
	 *
	 * @param  string  $search
	 * @return JSON
	 */
	public function asteriskIt($words)
	{
		$wordList = explode(' ',$words);
		$searchList = [];
		foreach($wordList as $w) {
			$searchList[] = trim($w).'*';
		}
		return implode(' ',$searchList);
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
			$search = $this->asteriskIt($input['search']);
			$contacts = Auth::User()->contacts()->whereRaw(
				'MATCH (name, surname, email, phone, field1, field2, field3, field4, field5) AGAINST ("'.$search.'" IN BOOLEAN MODE)'
				)->get()->toArray();
		} else {
			$contacts = Auth::User()->contacts()->get()->toArray();
		}
		return Response::json($contacts);
	}


}
