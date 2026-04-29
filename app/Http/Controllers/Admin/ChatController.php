<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $conversationQuery = ChatConversation::with(['sender', 'receiver'])
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
            })
            ->latest('last_message_at')
            ->latest();

        $conversations = $conversationQuery
            ->paginate(8, ['*'], 'conversation_page')
            ->withQueryString();
        $selectedConversation = null;
        $showCreateForm = $request->boolean('new') || $request->session()->has('errors');
        $messages = null;
        $receivers = User::query()->orderBy('name')->get();

        if ($request->filled('conversation')) {
            $conversationId = (int) $request->integer('conversation');
            $selectedConversation = $conversationQuery->whereKey($conversationId)->first();
            if ($selectedConversation) {
                $messages = $selectedConversation->messages()
                    ->with('sender')
                    ->paginate(12, ['*'], 'message_page')
                    ->withQueryString();
            }
        }

        return view('admin.chat.index', compact('conversations', 'selectedConversation', 'showCreateForm', 'messages', 'receivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'receiver_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $conversation = ChatConversation::query()->create([
            'title' => $validated['title'],
            'sender_id' => $request->user()->id,
            'receiver_id' => (int) $validated['receiver_id'],
            'last_message_at' => now(),
        ]);

        return redirect()
            ->route('admin.chat.index', ['conversation' => $conversation->id])
            ->with('status', 'Conversation created successfully.');
    }

    public function sendMessage(Request $request, ChatConversation $chatConversation)
    {
        $user = $request->user();
        if (! in_array($user->id, [$chatConversation->sender_id, $chatConversation->receiver_id], true)) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:3000'],
        ]);

        ChatMessage::query()->create([
            'chat_conversation_id' => $chatConversation->id,
            'sender_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $chatConversation->update(['last_message_at' => now()]);

        return redirect()->route('admin.chat.index', ['conversation' => $chatConversation->id]);
    }
}
