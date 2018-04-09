<?php namespace App\Providers;

use App\Classes\response\Api;
use Event;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'event.name' => [
            'EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        Event::listen('tymon.jwt.invalid', function () {
            return Api::error(5020, [], 'Token');
        });
        // fired when the token has expired
        Event::listen('tymon.jwt.expired', function () {
            return Api::error(5030, [], 'Token');
        });

        // fired when the token could not be found in the request
        Event::listen('tymon.jwt.absent', function () {
            return Api::error(1040, [], 'Token');
        });
        // fired if the user could not be found (shouldn't really happen)
        Event::listen('tymon.jwt.user_not_found', function () {
            return Api::error(5040, [], 'User');
        });

        // fired when the token is valid (User is passed along with event)
        Event::listen('tymon.jwt.valid', function () {
            return Api::success(2070, [], 'Token');
        });
        parent::boot($events);
    }
}
