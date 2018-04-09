<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Album
 *
 * @property int $id
 * @property string $name
 * @property string $release_date
 * @property string $image
 * @property int $artist_id
 * @property bool $spotify_popularity
 * @property bool $fully_scraped
 * @property string $temp_id
 * @property-read \App\Artist $artist
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Track[] $tracks
 * @method static \Illuminate\Database\Query\Builder|\App\Album whereArtistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Album whereFullyScraped($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Album whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Album whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Album whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Album whereReleaseDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Album whereSpotifyPopularity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Album whereTempId($value)
 */
	class Album extends \Eloquent {}
}

namespace App{
/**
 * App\Artist
 *
 * @property int $id
 * @property string $name
 * @property int $spotify_followers
 * @property bool $spotify_popularity
 * @property string $image_small
 * @property string $image_large
 * @property bool $fully_scraped
 * @property \Carbon\Carbon $updated_at
 * @property string $bio
 * @property string $wiki_image_large
 * @property string $wiki_image_small
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Album[] $albums
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Genre[] $genres
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Artist[] $similar
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereBio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereFullyScraped($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereImageLarge($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereImageSmall($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereSpotifyFollowers($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereSpotifyPopularity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereWikiImageLarge($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Artist whereWikiImageSmall($value)
 */
	class Artist extends \Eloquent {}
}

namespace App{
/**
 * App\Genre
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Artist[] $artists
 * @method static \Illuminate\Database\Query\Builder|\App\Genre whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Genre whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Genre whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Genre whereUpdatedAt($value)
 */
	class Genre extends \Eloquent {}
}

namespace App{
/**
 * App\Playlist
 *
 * @property int $id
 * @property string $name
 * @property bool $public
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $image
 * @property string $description
 * @property-read mixed $is_owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Track[] $tracks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Playlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playlist whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playlist whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playlist whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playlist whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playlist wherePublic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playlist whereUpdatedAt($value)
 */
	class Playlist extends \Eloquent {}
}

namespace App{
/**
 * App\Setting
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App{
/**
 * App\Social
 *
 * @property int $id
 * @property int $user_id
 * @property string $service
 * @property string $token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Social whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Social whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Social whereService($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Social whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Social whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Social whereUserId($value)
 */
	class Social extends \Eloquent {}
}

namespace App{
/**
 * App\Track
 *
 * @property int $id
 * @property string $name
 * @property string $album_name
 * @property bool $number
 * @property int $duration
 * @property array $artists
 * @property string $youtube_id
 * @property bool $spotify_popularity
 * @property int $album_id
 * @property string $temp_id
 * @property string $url
 * @property-read \App\Album $album
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Playlist[] $playlists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereAlbumId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereAlbumName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereArtists($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereSpotifyPopularity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereTempId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Track whereYoutubeId($value)
 */
	class Track extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar_url
 * @property string $gender
 * @property string $permissions
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $confirmed
 * @property string $confirmation_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $followedUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $followers
 * @property-read mixed $followers_count
 * @property-read bool $is_admin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Social[] $oauth
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Playlist[] $playlists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Track[] $tracks
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereConfirmationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePermissions($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\UserSession
 *
 * @property int $user_id
 * @property string $email
 * @property string $password
 * @property string $remember_me
 * @property string $token
 * @property \Carbon\Carbon $created_at
 * @method static \Illuminate\Database\Query\Builder|\App\UserSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserSession whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserSession wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserSession whereRememberMe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserSession whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserSession whereUserId($value)
 */
	class UserSession extends \Eloquent {}
}

