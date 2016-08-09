<?php

namespace PHPMap;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;

use PHPMap\Models\BlogEntry;
use PHPMap\Models\UserPost;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, AlgoliaEloquentTrait, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'avatar', 'email', 'slack_webhook_url', 'password', 'lat', 'lng', 'address', 'city', 'county', 'company', 'website', 'github_url', 'twitter_url', 'facebook_url', 'linkedin_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'slack_webhook_url'
    ];

    public static $autoIndex = true;
    public static $autoDelete = true;
    public $indices = ['users'];

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return $this->slack_webhook_url;
    }

    public static function findByUsername($username)
    {
        return self::where('username', $username)->first();
    }

    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    public static function findByCity($city)
    {
        return self::where('city', $city)->get();
    }

    public static function follow_user($user)
    {
        return false;
    }

    public function blog_entries()
    {
        return $this->hasMany(BlogEntry::class);
    }

    public function posts()
    {
        return $this->hasMany(UserPost::class);
    }
}
