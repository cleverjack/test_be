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
    Route::get('musician/payment-info', 'MusicianController@getPaymentInfo');
    Route::post('musician/payment-info', 'MusicianController@savePaymentInfo');
    Route::get('musician/plan-info', 'MusicianController@getPlanInfo');
    Route::post('musician/plan-info', 'MusicianController@savePlanInfo');
    
    //PROFILE
    Route::get('profile/get-artist-detail/{id}', 'ProfileController@getArtistDetail');
    Route::get('profile/get-listener-selfdata', 'ProfileController@getListenerSelfData');
    Route::get('profile/get-listener-profile/{id}', 'ProfileController@getListenerDetail');
    Route::get('profile/artists', 'ProfileController@getArtists');

    // Subscription User
    Route::post('subscribe-artist', 'UsersController@subscribeArtist');
    // Subscription Artist
    Route::post('subscribe-web', 'MusicianController@subscribeWeb');
});

Route::get('paypal-subscription-complete/{id}', 'UsersController@paypalPlanSubscriptionComplete');
Route::post('stripe-webhook-handler', 'WebhookController@stripeWebhookHandler');
Route::post('paypal-webhook-handler', 'WebhookController@paypalWebhookHandler');