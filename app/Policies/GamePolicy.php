<?php
namespace App\Policies;

use App\Game;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\Game $game
     * @return mixed
     */
    public function view(User $user, Game $game)
    {
        return $user->id == $game->owner_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\Game $game
     * @return mixed
     */
    public function update(User $user, Game $game)
    {
        return $user->id == $game->owner_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\Game $game
     * @return mixed
     */
    public function delete(User $user, Game $game)
    {
        return $user->id == $game->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User $user
     * @param \App\Game $game
     * @return mixed
     */
    public function restore(User $user, Game $game)
    {
        // return $user->id == $game->owner_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User $user
     * @param \App\Game $game
     * @return mixed
     */
    public function forceDelete(User $user, Game $game)
    {
        // return $user->id == $game->owner_id;
    }
}
