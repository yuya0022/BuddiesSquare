<x-app-layout>
    <h1>{{ $selected_event->name }}</h1>
    <h2>{{ $selected_category->name }}ページ</h2>
    
    <div class="categories">
        @foreach($categories as $category)
            <a href="/posts/{{ $selected_event->id }}/{{ $category->id }}">{{ $category->name }}</a>
        @endforeach
    </div>
    
    <a href="/posts/{{ $selected_event->id }}/{{ $selected_category->id }}/create">{{$selected_event->name}}　{{ $selected_category->name }} の投稿作成</a>
    
    <!--件数表示-->
    @if (count($selected_posts) > 0)
        <p>全{{ $selected_posts->total() }}件中  
           {{ ($selected_posts->currentPage() - 1) * $selected_posts->perPage() + 1 }} - 
           {{ ($selected_posts->currentPage() - 1) * $selected_posts->perPage() + count($selected_posts) }}件の投稿が表示されています。</p>
    @else
        <p>投稿がありません。</p>
    @endif
    
    <!--投稿-->
    <div>
        @foreach($selected_posts as $post)
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