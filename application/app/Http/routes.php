<?php

Route::get('/', 'HomeController@index');

Route::get('update', ['middleware' => ['admin', 'disableOnDemoSite'], 'uses' => 'UpdateController@index']);
Route::post('run-update', ['middleware' => ['admin', 'disableOnDemoSite'], 'uses' => 'UpdateController@runUpdate']);

//SHARING
Route::post('send-links', 'SendLinksController@send');

Route::post('loginUser', 'UsersAuthController@loginUser');


Route::group(['middleware' => 'jwt.auth', 'jwt.refresh'], function () {

    //Musician
    Route::get('musician/get-artist', 'MusicianController@getArtist');
    Route::get('musician/{id}/get', 'MusicianController@getArtistById');
    
    //PROFILE
    Route::get('profile/get-artist-detail/{id}', 'ProfileController@getArtistDetail');
    Route::get('profile/get-listener-selfdata', 'ProfileController@getListenerSelfData');
    Route::get('profile/get-listener-profile/{id}', 'ProfileController@getListenerDetail');
    Route::get('profile/artists', 'ProfileController@getArtists');
    
});
