<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class ChatController extends Controller
{

    public function index()
    {
        $conversationId = 'i0Foouh8l8JUA3';
        $conversation = Conversation::where('room_id', $conversationId)->with('messages', 'messages.user')->first();
        return view('admin.chat.index', compact(['conversationId', 'conversation']));
    }

    public function sendMessage(Request $request)
    {

        $room_id = $request->room_id;

        if (!in_array($room_id, $request->user()->conversations->pluck('room_id')->toArray())) {
            return response()->json(['status' => 'You are not a member of this group!'], 403);
        }

        $user = $request->user();
        $conversation = Conversation::where('room_id', $room_id)->first();

        $message = Message::create([
            'content' => $request->input('content'),
            'type' => $request->input('type', 'text'),
            'user_id' => $user->id,
            'conversation_id' => $conversation->id,
        ]);

        broadcast(new ChatEvent($message, $room_id));

        return response()->json(['status' => 'Message sent successfully!']);
    }

    public function conversations(Request $request)
    {
        return response()->json($request->user()->conversations);
    }

    public function conversation(Request $request)
    {
        $conversationId = $request->room_id;
        $Conversation = Conversation::where('room_id', $conversationId);
        $messages = $Conversation->dataConversation();
        $messages->current_user_role = $Conversation->getRole();

        return response()->json($messages);
    }

    public function createRoom(Request $request)
    {

        $conversation = Conversation::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'room_id' => Str::random(14),
        ]);

        $conversation->users()->attach($request->user()->id);

        return response()->json(['status' => 'Room created successfully!', 'conversation' => $conversation]);

    }

    public function joinRoom(Request $request)
    {
        $room_id = $request->room_id;

        if (in_array($room_id, $request->user()->conversations->pluck('room_id')->toArray())) {
            return response()->json(['status' => 'user already joined!'], 404);
        }

        $conversation = Conversation::where('room_id', $room_id)->first();
        $conversation->users()->attach($request->user()->id);

        return response()->json(['status' => 'user joined successfully!', 'conversation' => $conversation]);

    }


}
