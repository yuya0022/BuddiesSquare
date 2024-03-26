<x-app-layout>
    <div class='posts_container'>
        <h1>{{ $selected_event->name }}</h1>
        
        <div class='category_container'>
            <div class='post_categories'>
                @for($i = 0; $i < 6; $i++)
                    <a class='category' href="/posts/{{ $selected_event->id }}/{{ $categories[$i]->id }}">{{ $categories[$i]->name }}</a>
                @endfor
            </div>
            <div class='post_categories'> 
                @for($i = 6; $i < 11; $i++)
                    <a class='category' href="/posts/{{ $selected_event->id }}/{{ $categories[$i]->id }}">{{ $categories[$i]->name }}</a>
                @endfor
            </div>
        </div>
        
        <a class='post_create_button_style' href="/posts/{{ $selected_event->id }}/{{ $selected_category->id }}/create">{{ $selected_category->name }} の投稿作成</a>
        
        <!--件数表示-->
        <div class='number_of_posts'>
            @if (count($selected_posts) > 0)
                <p>全{{ $selected_posts->total() }}件中  
                   {{ ($selected_posts->currentPage() - 1) * $selected_posts->perPage() + 1 }} - 
                   {{ ($selected_posts->currentPage() - 1) * $selected_posts->perPage() + count($selected_posts) }}件の投稿が表示されています。</p>
            @else
                <p>投稿がありません。</p>
            @endif
        </div>
        
        <!--投稿-->
        <div>
            @foreach($selected_posts as $post)
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
                    <a href="/posts/{{ $post->id }}">
                        <div>{{ $post->body }}</div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $selected_posts->links() }}
        </div>
    </div>
</x-app-layout>