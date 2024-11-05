<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Send a message to a specified room.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request, Room $room)
    {
        // Validate request data
        $request->validate([
            'content' => 'required|string|max:1000',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240', // 10MB
        ]);

        $filepath = null;

        // Check if a media file is uploaded
        if ($request->hasFile('media')) {
            // Store the media file in the "media" directory
            $filepath = $request->file('media')->store('media', 'public');
        }

        // Create a new message record in the specified room
        $message = $room->messages()->create([
            'content' => $request->input('content'),
            'media' => $filepath,
            'user_id' => auth()->id(),
        ]);

        // Return a JSON response indicating success
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => $message,
        ], 201);
    }
}
