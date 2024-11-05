<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.room.{room}', function (User $user, Room $room) {
    return $room->users->contains($user);
});
