<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserRegistered;
use App\Events\PostSubmitted;
use App\Events\PostApproved;
use App\Listeners\SendWelcomeEmailListener;
use App\Listeners\PostSubmittedListener;
use App\Listeners\PostApprovedListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            SendWelcomeEmailListener::class,
        ],
        PostSubmitted::class => [
            PostSubmittedListener::class,
        ],
        PostApproved::class => [
            PostApprovedListener::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
