<?php 
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	public $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'first_name', 'last_name', 'username', 'avatar', 'gender', 'confirmation_code', 'confirmed', 'city', 'state', 'location', 'provider', 'provider_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['remember_token'];

	protected $appends = array('isAdmin', 'followers_count');

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'confirmed' => 'integer',
    ];

	public function artists(){
		return $this->belongsToMany('App\Artist');
	}

	public function roles(){
		return $this->belongsToMany('App\Role');
	}
	public function followers()
	{
		return $this->belongsToMany('App\User', 'follows', 'followed_id', 'follower_id');
	}
	/**
	 * Return if user this model belongs to is admin.
	 *
	 * @return bool
	 */
	public function getIsAdminAttribute()
	{

		if($this->roles->isEmpty())
			return 0;
		return $this->roles[0]->name == 'admin';
	}

	/**
	 * Return if user this model belongs to is moderator.
	 *
	 * @return bool
	 */
	public function getIsModeratorAttribute()
	{

		if($this->roles->isEmpty())
			return 0;
		return $this->roles[0]->name == 'moderator';
	}

	/**
	 * Return if user this model belongs to is listener.
	 *
	 * @return bool
	 */
	public function getIsListenerAttribute()
	{
		if($this->roles->isEmpty())
			return 0;
		return $this->roles[0]->name == 'listener';
	}

	/**
	 * Return if user this model belongs to is artist.
	 *
	 * @return bool
	 */
	public function getIsArtistAttribute()
	{
		if($this->roles->isEmpty())
			return 0;
		return $this->roles[0]->name == 'artist';
	}

	public function getFollowersCountAttribute()
	{
		return $this->followers()->count();
	}

	public function getPermissionsAttribute()
	{
		return isset($this->attributes['permissions']) ? json_decode($this->attributes['permissions']) : [];
	}

	public function setPermissionsAttribute($value)
	{
		$this->attributes['permissions'] = json_encode($value);
	}

	/**
	 * Return users name, if doesn't have any then return email.
	 *
	 * @return string
	 */
	public function getNameOrEmail() {
		$name = '';

		if ($this->first_name) {
			$name = $this->first_name;
		}

		if ($name && $this->last_name) {
			$name .= ' ' . $this->last_name;
		}

		if ($name) {
			return $name;
		} else {
			return explode('@', $this->email)[0];
		}
	}
}