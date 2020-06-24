<?php
use App\User;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('admin', function (User $user) {
    return $user->isAdmin();
});

Broadcast::channel('reportText', function (User $user) {
    return $user->isAdmin();
});
