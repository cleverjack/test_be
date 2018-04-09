<?php

Route::get('/', 'HomeController@index');

Route::get('update', ['middleware' => ['admin', 'disableOnDemoSite'], 'uses' => 'UpdateController@index']);
Route::post('run-update', ['middleware' => ['admin', 'disableOnDemoSite'], 'uses' => 'UpdateController@runUpdate']);

//SOCIAL AUTHENTICATION
Route::get('auth/social/{provider}', 'SocialAuthController@connectToProvider');
Route::get('auth/social/{provider}/login', 'SocialAuthController@loginCallback');
Route::post('auth/social/request-email-callback', 'SocialAuthController@requestEmailCallback');
Route::post('auth/social/connect-accounts', 'SocialAuthController@connectAccounts');

//AUTH
/*Route::post('password/change', 'Auth\PasswordChangeController@change');
Route::get('register/verify/{code}', 'AuthController@verifyEmail');*/

/*Route::controllers([
    'auth'    => 'AuthController',
    'password' => 'Auth\PasswordController',
]);*/

//SHARING
Route::post('send-links', 'SendLinksController@send');

Route::post('loginUser', 'UsersAuthController@loginUser');
Route::post('registerUser', 'UsersAuthController@signUpUser');
Route::post('forgotPassword', 'UsersAuthController@forgotPassword');
Route::group(['middleware' => 'jwt.auth', 'jwt.refresh'], function () {

    //TRACKS
    Route::resource('track', 'TrackController', ['only' => ['update', 'index', 'store']]);
    Route::get('get-track/{id}', 'TrackController@show');
    Route::post('delete-tracks', 'TrackController@destroy');
    Route::get('tracks/top', 'TrackController@getTopSongs');
    Route::get('track/{id}/{mime}/stream', 'TrackStreamController@stream');

    //Albums
    Route::post('topAlbums', 'AlbumController@getTopAlbumsApi');
    Route::post('topSongsApi', 'TrackController@getTopSongsApi');
    Route::post('latest-releases', 'AlbumController@getLatestAlbumsApi');

    //PLAYLIST
    Route::group(['prefix' => 'api/v1'], function () {
        Route::post('get-playlist/{id}', 'PlaylistController@showApi');
        Route::post('playlist/add-tracks', 'PlaylistTracksController@addTracksApi');
    });

    //PLAYLISTS
    Route::resource('playlists', 'PlaylistController', ['except' => ['edit']]);
    Route::get('get-playlist/{id}', 'PlaylistController@show');
    Route::post('playlist/{id}/add-tracks', 'PlaylistTracksController@addTracks');
    Route::post('playlist/{id}/remove-track', 'PlaylistTracksController@removeTrack');
    Route::post('playlist/{id}/follow', 'PlaylistController@follow');
    Route::post('playlist/{id}/unfollow', 'PlaylistController@unfollow');
    Route::put('playlist/{id}/update-order', 'PlaylistTracksController@updateTracksOrder');
    Route::post('playlist/{id}/upload-image', 'PlaylistController@uploadImage');
    Route::post('menu_playlists', 'PlaylistController@addPlaylistToMenu');

    //Menulist
    Route::resource('menulists', 'MenulistController');
    // Route::get('get-menulist/{id}', 'MenulistController@show');
    Route::post('menulist/{id}/add-tracks', 'MenulistController@addTracks');
    Route::post('menulist/{id}/add-albums', 'MenulistController@addAlbums');
    Route::post('menulist/{id}/add-artists', 'MenulistController@addArtists');
    Route::post('menulist/{id}/remove-track', 'MenulistController@removeTrack');
    Route::post('menulist/{id}/remove-album', 'MenulistController@removeAlbum');
    Route::post('menulist/{id}/remove-artist', 'MenulistController@removeArtist');
    Route::post('menulist/{id}/upload-image', 'MenulistController@uploadImage');

    //LYRICS
    Route::post('get-lyrics', 'LyricsController@getLyrics');

    //SEARCH
    Route::get('get-search-results/{q}', 'SearchController@search');
    Route::get('search-audio/{artist}/{track}', 'SearchController@searchAudio');

    //RADIO
    Route::post('radio/artist', 'RadioController@artistRadio');
    Route::post('radio/artist/next', 'RadioController@nextSong');
    Route::post('radio/artist/more-like-this', 'RadioController@moreLikeThis');
    Route::post('radio/artist/less-like-this', 'RadioController@lessLikeThis');

    //USER LIBRARY
    Route::post('user-library/add-tracks', 'UserLibraryController@addTracks');
    Route::post('user-library/remove-tracks', 'UserLibraryController@removeTracks');
    Route::get('user-library/get-all', 'UserLibraryController@getAll');

    //USERS
    Route::post('users', 'UsersController@destroyAll');
    Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'index', 'destroy']]);
    Route::post('changeAvatar', 'UsersAuthController@changeAvatar');
    Route::post('logOut', 'UsersAuthController@logOut');
    Route::post('changePassword', 'UsersAuthController@changePassword');
    Route::post('updateProfile', 'UsersAuthController@updateProfile');
    Route::post('getUserProfile', 'UsersAuthController@getUserProfile');
    Route::post('users/{id}/avatar', 'AvatarController@change');
    Route::delete('users/{id}/avatar', 'AvatarController@remove');
    Route::post('users/{id}/follow', 'UsersController@follow');
    Route::post('users/{id}/unfollow', 'UsersController@unfollow');
    Route::get('users/{id}/followers', 'UsersController@followers');
    Route::get('users/{id}/followed_users', 'UsersController@followedUsers');

    //ARTISTS
    Route::get('artist', 'ArtistController@index');
    Route::put('artist/{id}', 'ArtistController@update');
    Route::post('get-artist', 'ArtistController@getArtistData');
    Route::post('artist', 'ArtistController@store');
    Route::post('artist/{id}/get-bio', 'ArtistController@getBio');
    Route::post('get-artist-top-tracks/{artist_name}', 'ArtistController@getTopTracks');
    Route::get('artists/most-popular', 'ArtistController@getMostPopularArtists');
    Route::post('delete-artists', 'ArtistController@destroy');
    Route::post('artist/{id}/upload-image', 'ArtistController@uploadImage');

    //GENRES
    Route::get('all_genres', 'GenreController@getAllGenres');
    Route::get('genres', 'GenreController@getGenres');
    Route::post('topGenres', 'GenreController@getGenresApi');
    Route::get('genres/{names}/paginate-artists', 'GenreController@paginateArtists');
    Route::post('genres/{names}/paginate-artists', 'GenreController@paginateArtists');

    //ALBUMS
    Route::get('album', 'AlbumController@index');
    Route::put('album/{id}', 'AlbumController@update');
    Route::post('album', 'AlbumController@store');
    Route::post('get-album', 'AlbumController@getAlbumData');
    Route::post('albums/latest-releases', 'AlbumController@getLatestAlbums');
    Route::get('albums/top', 'AlbumController@getTopAlbums');
    Route::post('delete-albums', 'AlbumController@destroy');
    Route::post('album/{id}/upload-image', 'AlbumController@uploadImage');

    //ADMIN
    Route::get('translations', 'TranslationsController@getLinesAndLocales');
    Route::get('translation-lines/{locale}', 'TranslationsController@getLines');
    Route::post('new-locale', 'TranslationsController@createNewLocale');
    Route::delete('locale/{name}', 'TranslationsController@deleteLocale');
    Route::post('update-translations', 'TranslationsController@updateLines');
    Route::post('reset-translations', 'TranslationsController@resetTranslations');
    Route::get('admin-stats', 'AdminStatsController@getStats');

    //Musician
    Route::get('musician/get-artist', 'MusicianController@getArtist');
    Route::get('musician/get-albums', 'MusicianController@getAlbums');
    Route::post('musician/{id}/get-album', 'MusicianController@getAlbum');
    Route::get('musician/{id}/get-track', 'MusicianController@getTrack');
    Route::get('musician/get-tracks', 'MusicianController@getTracks');
    Route::get('musician/get-populars', 'MusicianController@getPopularSongs');
    Route::get('musician/get-fans', 'MusicianController@getFans');
    Route::post('musician/add-album', 'MusicianController@addAlbum');
    Route::post('musician/add-track', 'MusicianController@addTrack');
    Route::post('musician/add-artist', 'MusicianController@addArtist');
    Route::post('musician/{id}/update-profile', 'MusicianController@updateProfile');
    Route::post('musician/{id}/update-album', 'MusicianController@updateAlbum');
    Route::post('musician/{id}/update-track', 'MusicianController@updateTrack');
    Route::post('musician/{id}/get-tracks', 'MusicianController@getAlbumTracks');
    Route::post('musician/authorization', 'MusicianController@authorization');
    Route::post('musician/upload-popular', 'MusicianController@addPopular');
    Route::post('musician/{id}/remove-track', 'MusicianController@removeTrack');
    Route::post('musician/{id}/remove-album', 'MusicianController@removeAlbum');
    Route::post('musician/{id}/remove-popular', 'MusicianController@removePopular');
    Route::post('musician/{id}/update-popular', 'MusicianController@updatePopular');

    //Templates
    Route::get('mail/templates', 'MailController@getTemplates');
    Route::post('mail/template/{name}', 'MailController@saveTemplate');

    // Settings
    Route::post('update-settings',
        ['middleware' => 'disableOnDemoSite', 'uses' => 'SettingsController@UpdateSettings']);
    Route::get('settings', 'SettingsController@GetAllSettings');
    Route::post('settings/upload-logo',
        ['middleware' => 'disableOnDemoSite', 'uses' => 'SettingsController@uploadLogo']);
    Route::post('settings/clear-cache',
        ['middleware' => 'disableOnDemoSite', 'uses' => 'SettingsController@clearCache']);

    //APPEARANCE
    Route::get('sass-files', 'AppearanceController@getSassFiles');
    Route::get('available-stylesheets', 'AppearanceController@getAvailableStylesheets');
    Route::post('create-new-stylesheet', 'AppearanceController@createNewStylesheet');
    Route::put('update-stylesheet', 'AppearanceController@updateStylesheet');
    Route::delete('stylesheet/{name}', 'AppearanceController@deleteStylesheet');
    Route::post('stylesheet/{name}/reset', 'AppearanceController@resetStylesheetVariables');
    Route::put('rename-stylesheet/{name}', 'AppearanceController@renameStylesheet');

});

//Route::post('verifyToken', 'UsersAuthController@verifyToken');


//SITEMAP
Route::get('generate-sitemap', 'SitemapController@generate');
Route::get('sitemap.xml', 'SitemapController@showIndex');

// Route::get('spider-artists', function() {
//     $crawler = App::make('App\Services\Crawlers\SpotifyCrawler');
//     $crawler->crawlArtists();
// })->middleware('admin');

// Route::get('spider-albums', function() {
//     $crawler = App::make('App\Services\Crawlers\SpotifyCrawler');
//     $crawler->crawlAlbums();
// })->middleware('admin');