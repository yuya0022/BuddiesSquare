<x-app-layout>
    <div class='chats_container'>
        <h1>チャット一覧</h1>
        
        @foreach($sorted_chats as $chat)
            @if($chat->owner_id == Auth::user()->id)
                <a href="/chat/{{ $chat->guest->id }}">
                    <div class='chat_container'>
                        
                        <!--guestのアイコン-->
                        <div class="icon" style="display:inline-block;">
                            <img src="{{ $chat->guest->main_image }}" alt="画像が読み込めません。"/>
                        </div>
                        
                        <div class='chat_right_part' style="display:inline-block;">
                            
                            <!--guestの名前・年齢-->
                            <p class='name_and_age'>{{ $chat->guest->name }} &ensp; {{ \Carbon\Carbon::parse($chat->guest->birthday)->age }}歳</p>
                            
                            <!--最新のメッセージを表示-->
                            <p class='chat_message'>{{ $chat->messages()->orderBy('updated_at', 'DESC')->first()->body }}</p>
                        </div>
                    </div>
                </a>
                
                
            @else
                <a href="/chat/{{ $chat->owner->id }}">
                    <div class='chat_container'>
                        
                        <!--ownerのアイコン-->
                        <div class="icon" style="display:inline-block;">
                            <img src="{{ $chat->owner->main_image }}" alt="画像が読み込めません。"/>
                        </div>
                        
                        <div class='chat_right_part' style="display:inline-block;">
                            
                            <!--ownerの名前・年齢-->
                            <p class='name_and_age'>{{ $chat->owner->name }} &ensp; {{ \Carbon\Carbon::parse($chat->owner->birthday)->age }}歳</p>
                        
                            <!--最新のメッセージを表示-->
                            <p class='chat_message'>{{ $chat->messages()->orderBy('updated_at', 'DESC')->first()->body }}</p>
                        </div>
                    </div>
                </a>
            @endif
        @endforeach
        
        @if(count($sorted_chats) == 0)
            <p>チャットがありません</p>
        @endif
    </div>
</x-app-layout>