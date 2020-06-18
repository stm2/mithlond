<?php
namespace App\Policies;

use App\Faction;
use App\Submission;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user, Submission $submission = null)
    {
        return $this->authorizeGame($user, $submission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\Submission $submission
     * @return mixed
     */
    public function view(User $user, Submission $submission)
    {
        return $this->authorize($user, $submission);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @param \App\Faction $user
     * @return mixed
     */
    public function create(User $user, Submission $submission = null)
    {
        return $this->authorize($user, $submission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\Submission $submission
     * @return mixed
     */
    public function update(User $user, Submission $submission)
    {
        return $this->authorize($user, $submission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\Submission $submission
     * @return mixed
     */
    public function delete(User $user, Submission $submission)
    {
        return $this->authorize($user, $submission);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User $user
     * @param \App\Submission $submission
     * @return mixed
     */
    public function restore(User $user, Submission $submission)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User $user
     * @param \App\Submission $submission
     * @return mixed
     */
    public function forceDelete(User $user, Submission $submission)
    {
        return false;
    }

    protected function authorize(User $user, Submission $submission = null)
    {
        return is_null($submission) ? $user->exists : $submission->faction->user_id == $user->id;
    }

    protected function authorizeGame(User $user, Submission $submission = null)
    {
        if (! is_null($submission)) {
            $auth = $submission->faction->game->user_id == $user->id;
        } else {
            $auth = $user->exists;
        }
        return $auth;
    }
}
