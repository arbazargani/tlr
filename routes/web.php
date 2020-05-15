<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'HomeController@Index')/*->middleware('SessionAnalysis')*/->name('Index');
Route::post('/submit', 'LinkController@Submit')->name('Link > Submit');
Route::get('/{tiny}','LinkController@Redirect')->name('Link > Redirect');

Route::prefix('c67x')->middleware('auth')->group(function () {
    Route::get('/home', 'AdminController@Index')->name('Admin');
    Route::get('/links', 'AdminController@FindLinks')->name('Admin > Links');

    Route::get('/links/add/{multiple?}', 'AdminController@AddLink')->name('Admin > Links > Add');

    Route::post('/links/activate/{id}', 'AdminController@ActivateLink')->name('Admin > Links > Activate');
    Route::post('/links/deactivate/{id}', 'AdminController@DeactivateLink')->name('Admin > Links > Deactivate');
    Route::post('/links/delete/{id}', 'AdminController@DeleteLink')->name('Admin > Links > Delete');
});

Route::prefix('panel')->middleware('auth')->group(function () {
    Route::get('/home', 'UserController@Index')->name('Panel');
    Route::get('/links', 'UserController@Links')->name('Panel > Links');
});

Route::get('/info/all', function () {
    return [
        'admin' => [
            'info@arbazargani.ir' => '09308990856',
            'info@sazgar.ir' => 'siamak'
        ],
        'user' => [
            'info@khosravi.ir' => 'khosravi'
        ]
    ];
});



// helper routes
Route::get('/user/agent', 'LinkController@ShowAllAbout');