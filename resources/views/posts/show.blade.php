<x-app-layout>
    <h1>{{ $selected_event->name }}</h1>
    <h2>{{ $selected_category->name }}ページ</h2>
    <div class="categories">
        @foreach($categories as $category)
            <a href="/posts/{{ $selected_event->id }}/{{ $category->id }}">{{ $category->name }}</a>
        @endforeach
    </div>
    <a href="/posts/{{ $selected_event->id }}/{{ $selected_category->id }}/create">{{$selected_event->name}}　{{ $selected_category->name }} の投稿作成</a>
    <div>
        @foreach($selected_posts as $post)
            <div>
                <div class="icon">
                    <img src="{{ $post->user->main_image }}" alt="画像が読み込めません。"/>
                </div>
                <p>{{ $post->user->name }}</p>
                <a href="/posts/{{ $post->id }}">
                    <div>{{ $post->body }}</div>
                </a>
            </div>
        @endforeach
    </div>
    <div class='paginate'>
        {{ $selected_posts->links() }}
    </div>
</x-app-layout>