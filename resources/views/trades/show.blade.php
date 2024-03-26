<x-app-layout>
    <div class='posts_container'>
        
        <!--トレード投稿-->
        <div class='post'>
            
            <!--投稿者情報-->
            <div class='icon_container'>
                <a href="/profile/{{ $trade->user->id }}">
                    <div class="icon">
                        <img src="{{ $trade->user->main_image }}" alt="画像が読み込めません。"/>
                    </div>
                </a>
            </div>
            <a href="/profile/{{ $trade->user->id }}">{{ $trade->user->name }} &ensp; {{ \Carbon\Carbon::parse($trade->user->birthday)->age }}歳</a>
        
            <!--投稿内容-->
            <div>
                <!--トレード方法-->
                <x-input-label class='heading' :value="__('【トレード方法】')" />
                <div class='box'>
                    @foreach($trade->methods as $method)
                        @if($method->id == 1)
                            <p>郵送</p>
                        @else
                            <p>{{ $method->pivot->event_info->event->name }}　{{ $method->pivot->event_info->date }}　{{ $method->pivot->event_info->venue }}</p>
                        @endif
                    @endforeach
                </div>
                
                <!--提供-->
                <div>
                    <x-input-label class='heading' :value="__('【提供】')" />
                    @foreach($offers_divided_by_series as $offers)
                        <div class='box'>
                            <p class='series_name'>{{ $offers[0]->series->name }}</p>
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
                        </div>
                    @endforeach
                </div>
                        
                <!--要求-->
                <div>
                    <x-input-label class='heading' :value="__('【要求】')" />
                    @foreach($requests_divided_by_series as $requests)
                        <div class='box'>
                            <p class='series_name'>{{ $requests[0]->series->name }}</p>
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
                        </div>
                    @endforeach
                </div>
                        
                <!--注意事項など-->
                <x-input-label class='heading' :value="__('【注意事項など】')" />
                <div class='box'>
                    <p>{{ $trade->note }}</p>
                </div>
            </div> 
            
            <!--編集・削除ボタン-->
            <div class='update_delete_container'>
                @if(Auth::user()->id == $trade->user_id)
                    <a class='update_button_style' href="/trades/{{ $trade->id }}/edit">編集する</a>
                    <form action="/trades/{{ $trade->id }}" id="form_{{ $trade->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class='delete_button' type="button" onclick="deleteTrade({{ $trade->id }})">削除する</button>
                    </form>
                @endif
            </div>
        </div>
        
        <!--エラーメッセージ-->
        <div>
            <p style="background-color:black"><font color="yellow">{{ session('message') }}</font></p>
        </div>
        
        <!--コメントフォーム-->
        <form class='comment_form' action="/trades/{{ $trade->id }}" method="POST">
            @csrf
            <x-input-label for="comment" :value="__('【コメント内容】')" />
            <textarea id="comment" name="comment" class='script_comment'>{{ old('comment') }}</textarea>
            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
            <p>※ 300字以内で入力してください</p>
            <div class='comment_container'>
                <button type='submit' class='comment_button'>コメントする</button>
            </div>
        </form>
        
        <!--コメントの件数表示-->
        <div class='number_of_comments'>
            @if (count($comments) > 0)
                <p>全{{ $comments->total() }}件中  
                   {{ ($comments->currentPage() - 1) * $comments->perPage() + 1 }} - 
                   {{ ($comments->currentPage() - 1) * $comments->perPage() + count($comments) }}件のコメントが表示されています。</p>
            @else
                <p>コメントがありません。</p>
            @endif
        </div>
        
        <!--コメント一覧-->
        <div>
            @foreach($comments as $comment)
                <div class='post'>
                    
                    <!--投稿者情報-->
                    <div class='icon_container'>
                        <a href="/profile/{{ $comment->user->id }}">
                            <div class="icon">
                                <img src="{{ $comment->user->main_image }}" alt="画像が読み込めません。"/>
                            </div>
                        </a>
                    </div>
                    <a href="/profile/{{ $comment->user->id }}">{{ $comment->user->name }} &ensp; {{ \Carbon\Carbon::parse($comment->user->birthday)->age }}歳</a>
                        
                    <!--投稿内容-->
                    <div>{{ $comment->comment }}</div>
                    
                    <!--削除ボタン-->
                    <div class='delete_container'>
                        @if(Auth::user()->id == $comment->user_id)
                            <form action="/trades/comments/{{ $comment->id }}" id="comment_form_{{ $comment->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteTradeComment({{ $comment->id }})" class='delete_button'>削除する</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $comments->links() }}
        </div>
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