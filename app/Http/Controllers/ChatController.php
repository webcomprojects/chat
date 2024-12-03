<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Contact;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;
use App\Models\verification_code;
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
            return response()->json(['status' => 'شما عضو این گروه نیستید!'], 403);
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

        return response()->json(['status' => 'پیام با موفقیت ارسال شد!']);
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
        $messages->current_user_role = $Conversation->getRole(Auth::id());

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

        return response()->json(['status' => 'گروه با موفقیت ساخته شد!', 'conversation' => $conversation]);

    }

    public function joinRoom(Request $request)
    {
        $room_id = $request->room_id;

        if (in_array($room_id, $request->user()->conversations->pluck('room_id')->toArray())) {
            return response()->json(['status' => 'کاربر در گروه وجود دارد!'], 404);
        }

        $conversation = Conversation::where('room_id', $room_id)->first();
        $conversation->users()->attach($request->user()->id);

        return response()->json(['status' => 'کاربر با موفقیت به گروه پیوست!', 'conversation' => $conversation]);
    }

    public function addRoom(Request $request)
    {
        $room_id = $request->room_id;
        $user_id = $request->user_id;
        $owner_id = $request->user()->id;

        $Conversation = Conversation::where('room_id', $room_id);
        $current_user_role = $Conversation->getRole($owner_id);

        if(!in_array($current_user_role, ['owner', 'admin']) or !in_array($room_id, $request->user()->conversations->pluck('room_id')->toArray())){
            return response()->json(['status' => 'شما مجوز انجام این عملیات را ندارید!'], 403);
        }

        $user = User::findOrFail($user_id);

        if (in_array($room_id, $user->conversations->pluck('room_id')->toArray())) {
            return response()->json(['status' => 'کاربر قبلا به این گروه اضافه شده است!'], 404);
        }

        $Conversation->users()->attach($user->id);

        return response()->json(['status' => 'کاربر با موفقیت اضافه شد!', 'conversation' => $Conversation]);
    }

    public function addContact(Request $request)
    {
        $mobile = $request->mobile;
        $current_user = $request->user();

        $request->validate([
            'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/',
        ]);

        $existingUser = verification_code::where('mobile' , $mobile)->exists();
        if(!$existingUser){
            return response()->json(['status' => 'هنوز اکانتی برای این شماره موبایل وجود ندارد!']);
        }

        $contact = Contact::create([
            'user_id' => $current_user->id,
            'mobile' => $mobile,
        ]);

        return response()->json(['status' => 'مخاطب با موفقیت اضافه شد!', 'contact' => $contact]);
    }

    public function contacts(Request $request)
    {
        $contacts = $request->user()->allcontacts();
        return response()->json($contacts);
    }

}
