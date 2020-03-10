<?php

namespace App\Observers;

use Illuminate\Support\Facades\Hash;
use App\User;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->password= Hash::make($user->password);
    }

    /**
     * Handle the User "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updating" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        $user->password= Hash::make($user->password);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "saving" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function saving(User $user)
    {
        //
    }

    /**
     * Handle the User "saved" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function saved(User $user)
    {
        //
    }

    /**
     * Handle the User "deleting" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restoring" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restoring(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }
}
