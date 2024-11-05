<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

const MAX_MEMBERS = 255;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Room::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $room = Room::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Room created successfully.',
            'data' => $room,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        Room::destroy($room->id);
    }

    /**
     * Join the current user to the room.
     */
    public function join(Room $room)
    {
        $count = Cache::get('room:'.$room->id, function () {
            return 0;
        });

        if ($count >= $MAX_MEMBERS) {
            return response()->json([
                'success' => false,
                'message' => 'Room is full.',
            ], 400);
        }

        Cache::increment('room:'.$room->id);

        $room->users()->attach(auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Joined room successfully.',
        ]);
    }

    /**
     * Leave the current user from the room.
     */
    public function leave(Room $room)
    {
        // check user is in the room.
        if ($room->users()->where('user_id', auth()->id())->exists()) {
            Cache::decrement('room:'.$room->id);

            $room->users()->detach(auth()->id());
        }

        return response()->json([
            'success' => true,
            'message' => 'Left room successfully.',
        ]);
    }
}
