<x-app-layout>
    <div>
        <a href="/posts/{{ $post->event_id }}/{{ $post->category_id }}">投稿一覧に戻る</a>
    </div>
    
    <!--投稿-->
    <div>
        <div>
            <a href="/profile/{{ $post->user->id }}">
                <div>
                    <div class="icon">
                        <img src="{{ $post->user->main_image }}" alt="画像が読み込めません。"/>
                    </div>
                    <p>{{ $post->user->name }}</p>
                    <p>{{ \Carbon\Carbon::parse($post->user->birthday)->age }}歳</p>
                </div>    
            </a>
            
            <div class="post">{{ $post->body }}</div>
        </div>
        @if(Auth::user()->id == $post->user_id)
            <div>
                <a href="/posts/{{ $post->id }}/edit">編集する</a>
            </div>
            <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="deletePost({{ $post->id }})">削除する</button>
            </form>
        @endif
    </div>
    
    <!--エラーメッセージ-->
    <div>
        <p style="background-color:black"><font color="yellow">{{ session('message') }}</font></p>
    </div>
    
    <!--コメントフォーム-->
    <form action="/posts/{{ $post->id }}" method="POST">
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
            <div>
                <div>
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
                </div>
                @if(Auth::user()->id == $comment->user_id)
                    <form action="/posts/comments/{{ $comment->id }}" id="comment_form_{{ $comment->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePostComment({{ $comment->id }})">削除する</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
    <div class='paginate'>
        {{ $comments->links() }}
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