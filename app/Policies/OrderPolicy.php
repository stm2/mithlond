<?php
namespace App\Policies;

use App\Faction;
use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user, Order $order = null)
    {
        return $this->authorizeGame($user, $order);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\Order $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        return $this->authorize($user, $order);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @param \App\Faction $user
     * @return mixed
     */
    public function create(User $user, Order $order = null)
    {
        return $this->authorize($user, $order);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\Order $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        return $this->authorize($user, $order);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\Order $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        return $this->authorize($user, $order);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User $user
     * @param \App\Order $order
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User $user
     * @param \App\Order $order
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        return false;
    }

    protected function authorize(User $user, Order $order = null)
    {
        return is_null($order) ? $user->exists : $order->faction->user_id == $user->id;
    }

    protected function authorizeGame(User $user, Order $order = null)
    {
        if (! is_null($order)) {
            $auth = $order->faction->game->user_id == $user->id;
        } else {
            $auth = $user->exists;
        }
        return $auth;
    }
}
