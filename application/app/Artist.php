<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artists';

    protected $fillable = ['username', 'name', 'gender', 'image_small', 'image_large', 'bio', 'contact', 'location', 'payment_address', 'monthly_rate', 'locked', 'website'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'       => 'integer',
        'spotify_popularity' => 'integer',
        'fully_scraped' => 'integer',
    ];

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsToMany('App\User');
    }
}
