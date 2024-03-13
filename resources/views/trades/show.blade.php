<x-app-layout>
    
    <div>
        <a href="/trades">トレード一覧に戻る</a>
    </div>
    
    <!--トレード投稿-->
    <div>
        <!--投稿者情報-->
        <a href="/profile/{{ $trade->user->id }}">
            <div>
                <div class="icon">
                    <img src="{{ $trade->user->main_image }}" alt="画像が読み込めません。"/>
                </div>
                <p>{{ $trade->user->name }}</p>
                <p>{{ \Carbon\Carbon::parse($trade->user->birthday)->age }}歳</p>
            </div>
        </a>
        
        <div>
            <!--トレード方法-->
            <p>【トレード方法】</p>
            @foreach($trade->methods as $method)
                @if($method->id == 1)
                    <p>郵送</p>
                @else
                    <p>{{ $method->pivot->event_info->event->name }}　{{ $method->pivot->event_info->date }}　{{ $method->pivot->event_info->venue }}</p>
                @endif
            @endforeach
            
            <!--提供-->
            <p>【提供】</p>
            @foreach($offers_divided_by_series as $offers)
                <p>●{{ $offers[0]->series->name }}</p>
                @php
                    $offers_divided_by_member = $offers->groupBy('member_id');
                @endphp
                        
                @foreach($offers_divided_by_member as $offers_2)
                    <span>{{ $offers_2[0]->member->name }}：</span>
                    @foreach($offers_2 as $offer)
                        <span>{{ $offer->type->name }}、</span>
                    @endforeach
                    <br>
                @endforeach
            @endforeach
                    
            <!--要求-->
            <p>【要求】</p>
            @foreach($requests_divided_by_series as $requests)
                <p>●{{ $requests[0]->series->name }}</p>
                @php
                    $requests_divided_by_member = $requests->groupBy('member_id');
                @endphp
                        
                @foreach($requests_divided_by_member as $requests_2)
                    <span>{{ $requests_2[0]->member->name }}：</span>
                    @foreach($requests_2 as $request)
                        <span>{{ $request->type->name }}、</span>
                    @endforeach
                    <br>
                @endforeach
            @endforeach
                    
            <!--注意事項など-->
            <p>【注意事項など】</p>
            <p>{{ $trade->note }}</p>
        </div>    
    </div>
    
    <!--編集ボタン-->
    @if(Auth::user()->id == $trade->user_id)
        <div>
            <a href="/trades/{{ $trade->id }}/edit">編集する</a>
        </div>
        <form action="/trades/{{ $trade->id }}" id="form_{{ $trade->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" onclick="deleteTrade({{ $trade->id }})">削除する</button>
        </form>
    @endif
    
    <!--エラーメッセージ-->
    <div>
        <p style="background-color:black"><font color="yellow">{{ session('message') }}</font></p>
    </div>
    
    <!--コメントフォーム-->
    <form action="/trades/{{ $trade->id }}" method="POST">
        @csrf
        <div>
            <x-input-label for="comment" :value="__('【内容】')" />
            <textarea id="comment" name="comment">{{ old('comment') }}</textarea>
            <p>※ 300字以内で入力してください</p>
            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
        </div>
        <input type="submit" value="コメントする"/>
    </form>
    
    <!--コメントの件数表示-->
    @if (count($comments) > 0)
        <p>全{{ $comments->total() }}件中  
           {{ ($comments->currentPage() - 1) * $comments->perPage() + 1 }} - 
           {{ ($comments->currentPage() - 1) * $comments->perPage() + count($comments) }}件のコメントが表示されています。</p>
    @else
        <p>コメントがありません。</p>
    @endif
    
    <!--コメント一覧-->
    <div>
        @foreach($comments as $comment)
            <a href="/profile/{{ $comment->user->id }}">
                <div>
                    <div class="icon">
                        <img src="{{ $comment->user->main_image }}" alt="画像が読み込めません。"/>
                    </div>
                    <p>{{ $comment->user->name }}</p>
                    <p>{{ \Carbon\Carbon::parse($comment->user->birthday)->age }}歳</p>
                </div>
            </a>
            
            <div>{{ $comment->comment }}</div>
            @if(Auth::user()->id == $comment->user_id)
                <form action="/trades/comments/{{ $comment->id }}" id="comment_form_{{ $comment->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deleteTradeComment({{ $comment->id }})">削除する</button>
                </form>
            @endif
        @endforeach
    </div>
    <div class='paginate'>
        {{ $comments->links() }}
    </div>
    
    <script>
        function deleteTrade(id) {
            'use strict'
    
            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
        
        function deleteTradeComment(id) {
            'use strict'
            
            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`comment_form_${id}`).submit();
            }
        }
    </script>
</x-app-layout>