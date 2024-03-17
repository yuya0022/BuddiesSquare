<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Chat;
use App\Models\Room;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function index()
    {
        // $chats(自身が属するチャットで, 1回以上メッセージのやり取りがあるもの. たちのコレクション)の定義
        $myUserId = auth()->user()->id;
        
        $chats = Room::with(['messages', 'owner', 'guest'])
                ->where(function($query) use ($myUserId) {
                    $query->has('messages')->where('owner_id', $myUserId);     
                })
                ->orWhere(function($query) use ($myUserId) {
                    $query->has('messages')->where('guest_id', $myUserId);
                })
                ->get();
        
        // $sorted_chats($chatsを最新のメッセージの順で並べ替えた 配列)の定義
        $sorted_chats = array();
        
        foreach($chats as $chat){
            $date = (new Carbon($chat->messages()->orderBy('updated_at', 'DESC')->first()->updated_at))->toDateTimeString();
            $sorted_chats[$date] = $chat;
        }
        
        krsort($sorted_chats);
        
        // viewの返却
        return view('chats.index')->with(['sorted_chats' => $sorted_chats]);
    }
    
    public function openChat(User $user)
    {
        // 自分と相手のIDを取得
        $myUserId = auth()->user()->id;
        $otherUserId = $user->id;
        
        // データベース内でチャットが存在するかを確認
        $chat = Room::where(function($query) use ($myUserId, $otherUserId) {
            $query->where('owner_id', $myUserId)
                ->where('guest_id', $otherUserId);
        })->orWhere(function($query) use ($myUserId, $otherUserId) {
            $query->where('owner_id', $otherUserId)
                ->where('guest_id', $myUserId);
        })->first();
        
        // チャットが存在しない場合、新しいチャットを作成
        if (!$chat) {
            $chat = new Room();
            $chat->owner_id = $myUserId;
            $chat->guest_id = $otherUserId;
            $chat->save();
        }
        
        $messages = Message::where('chat_id', $chat->id)->orderBy('updated_at', 'DESC')->get();
        
        return view('chats.chat')->with(['chat' => $chat, 'messages' => $messages, 'user' => $user]);
    }
    
    public function sendMessage(Message $message, Request $request)
    {
        $user = auth()->user();
        $strUserId = $user->id;
        $strUsername = $user->name;
        $strMessage = $request->input('message');

        // メッセージオブジェクトの作成
        $chat = new Chat;
        $chat->body = $strMessage;
        $chat->chat_id = $request->input('chat_id');
        $chat->userName = $strUsername;
        MessageSent::dispatch($chat);    

        //データベースへの保存処理
        $message->user_id = $strUserId;
        $message->body = $strMessage;
        $message->chat_id = $request->input('chat_id');
        $message->save();

        return response()->json(['message' => 'Message sent successfully']);
    }
}
