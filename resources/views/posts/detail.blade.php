<x-app-layout>
    <div>
        <div class="icon">
            <img src="{{ $post->user->main_image }}" alt="画像が読み込めません。"/>
        </div>
        <p>{{ $post->user->name }}</p>
        <p>{{ \Carbon\Carbon::parse($post->user->birthday)->age }}歳</p>
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
    <div>
        <p style="background-color:black"><font color="yellow">{{ session('message') }}</font></p>
    </div>
    <div>
        <a href="/posts/{{ $post->event_id }}/{{ $post->category_id }}">投稿一覧に戻る</a>
    </div>
    
    <script>
        function deletePost(id) {
            'use strict'
    
            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
    </script>
</x-app-layout>