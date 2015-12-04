<?php

use AC\ActiveCampaign;

Route::get('/', function()
{
	return View::make('pages.home');
});

Route::get('/ac', function()
{
        $config_array = Config::get('services.activecampaign');
        $config = new \AC\Arguments\Config($config_array);
        $ac = new ActiveCampaign($config);
        if (!(int)$ac->credentials_test()) {
            Log::info('Access denied: Invalid credentials (URL and/or API key).');
        } else {
            Log::info('Credentials valid! Proceeding...');
        }
        $ac_contact = [
            'email'      => 'test@example.com',
            'first_name' => 'FirstName',
            'last_name'  => 'LastName',
            'phone'      => '+1 312 201 0300',
            'orgname'    => 'Acme, Inc.',
            'tags'       => 'api',
            'field[1,0]' => 'f1',
            'field[2,0]' => 'f2',
            'field[3,0]' => 'f3',
            'field[4,0]' => 'f4',
            'field[5,0]' => 'f5',
            "p[1]"       => 1,
            "status[1]"  => 1, // "Active" status
        ];
        $result = $ac->api('contact/add', $ac_contact);

        if ((int)$result->success) {
                // successful request
                $contact_id = (int)$result->subscriber_id;
                Log::info("Contact add successfully (ID {$contact_id})!");
                echo "<p>Contact synced successfully (ID {$contact_id})!</p>";
        }
        else {
                // request failed
                Log::info("Contact add failed. Error returned: " . $result->error);
                echo "<p>Syncing contact failed. Error returned: " . $result->error . "</p>";
        }
});


// Authentication routes
Route::get( 'auth/login',            'AuthController@getLogin'    );
Route::post('auth/login',            'AuthController@postLogin'   );
Route::get( 'auth/logout',           'AuthController@getLogout'   );
Route::get( 'auth/register',         'AuthController@getRegister' );
Route::post('auth/register',         'AuthController@postRegister');
// OAuth Authentication routes
Route::get('auth/{driver}',          'AuthController@redirectToProvider'    );
Route::get('auth/{driver}/callback', 'AuthController@handleProviderCallback');

// Contacts Search AJAX
Route::post('contact/search', 'ContactsController@search');
// Contacts controller
Route::resource('contact', 'ContactsController');
