<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
//        return Auth::id() == $topic->user_id;
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
