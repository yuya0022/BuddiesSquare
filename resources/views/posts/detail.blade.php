<x-app-layout>
    <div>
        <div class="icon">
            <img src="{{ $post->user->main_image }}" alt="画像が読み込めません。"/>
        </div>
        <p>{{ $post->user->name }}</p>
        <div class="post">{{ $post->body }}</div>
    </div>
</x-app-layout>