<x-app-layout>
    <div class='posts_container'>
        
        <!--投稿-->
        <div class='post'>
            
            <!--投稿者情報-->
            <div class='icon_container'>
                <a href="/profile/{{ $post->user->id }}">
                    <div class='icon'>
                        <img src="{{ $post->user->main_image }}" alt="画像が読み込めません。"/>
                    </div>
                </a>
            </div>
            <a href="/profile/{{ $post->user->id }}">{{ $post->user->name }} &ensp; {{ \Carbon\Carbon::parse($post->user->birthday)->age }}歳</a>
                    
            <!--投稿内容-->
            <div>{{ $post->body }}</div>
                
            <!--編集・削除ボタン-->
            <div class='update_delete_container'>
                @if(Auth::user()->id == $post->user_id)
                    <a class='update_button_style' href="/posts/{{ $post->id }}/edit">編集する</a>
                    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class='delete_button' type="button" onclick="deletePost({{ $post->id }})">削除する</button>
                    </form>
                @endif
            </div>
        </div>
        
        <!--エラーメッセージ-->
        <div>
            <p style="background-color:black"><font color="yellow">{{ session('message') }}</font></p>
        </div>
        
        <!--コメントフォーム-->
        <form class='comment_form' action="/posts/{{ $post->id }}" method="POST">
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
                            <form action="/posts/comments/{{ $comment->id }}" id="comment_form_{{ $comment->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deletePostComment({{ $comment->id }})" class='delete_button'>削除する</button>
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
        function deletePost(id) {
            'use strict'
    
            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
        
        function deletePostComment(id) {
            'use strict'
            
            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`comment_form_${id}`).submit();
            }
        }
    </script>
</x-app-layout>