<x-app-layout>
    
    @foreach($sorted_chats as $chat)
        @if($chat->owner_id == Auth::user()->id)
            <a href="/chat/{{ $chat->guest->id }}">
                <div>
                    <!--guestの情報-->
                    <div class="icon">
                        <img src="{{ $chat->guest->main_image }}" alt="画像が読み込めません。"/>
                    </div>
                    <p>{{ $chat->guest->name }}</p>
                    
                    <!--最新のメッセージを表示-->
                    <p>{{ $chat->messages()->orderBy('updated_at', 'DESC')->first()->body }}</p>
                </div>
            </a>
        @else
            <a href="/chat/{{ $chat->owner->id }}">
                <div>
                    <!--ownerの情報-->
                    <div class="icon">
                        <img src="{{ $chat->owner->main_image }}" alt="画像が読み込めません。"/>
                    </div>
                    <p>{{ $chat->owner->name }}</p>
                    
                    <!--最新のメッセージを表示-->
                    <p>{{ $chat->messages()->orderBy('updated_at', 'DESC')->first()->body }}</p>
                </div>
            </a>
        @endif
    @endforeach
    
    @if(count($sorted_chats) == 0)
        <p>チャットがありません</p>
    @endif
    
</x-app-layout>