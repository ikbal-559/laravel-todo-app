<?php

namespace App\Services;


use function Symfony\Component\Translation\t;

class AccessService
{

    public function hasTaskAccess($task, $user){
        if ($user->role == config('app.roles.user')) {
            if ($task->created_by != $user->id && $task->assign_to != $user->id) {
                return false;
            }
        }
        return true;
    }

}