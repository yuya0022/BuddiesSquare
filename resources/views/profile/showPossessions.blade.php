<x-app-layout>
    
    <!--ライブ・イベント投稿-->
    <div>
        <p>★ライブ・イベント投稿</p>

        <!--件数表示-->
        @if (count($posts) > 0)
            <p>全{{ $posts->total() }}件中  
               {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }} - 
               {{ ($posts->currentPage() - 1) * $posts->perPage() + count($posts) }}件の投稿が表示されています。</p>
        @else
            <p>投稿がありません。</p>
        @endif
        
        <!--投稿-->
        @foreach($posts as $post)
            <a href="/posts/{{ $post->id }}">
                <div>{{ $post->body }}</div>
            </a>
        @endforeach
    </div>
    
    <div class='paginate'>
        {{ $posts->links() }}
    </div>
    
    <!--ライブ・イベント投稿へのコメント-->
    <div>
        <p>★ライブ・イベント投稿へのコメント</p>
        
        <!--コメントの件数表示-->
        @if (count($post_comments) > 0)
            <p>全{{ $post_comments->total() }}件中  
               {{ ($post_comments->currentPage() - 1) * $post_comments->perPage() + 1 }} - 
               {{ ($post_comments->currentPage() - 1) * $post_comments->perPage() + count($post_comments) }}件のコメントが表示されています。</p>
        @else
            <p>コメントがありません。</p>
        @endif
        
        <!--コメント一覧-->
        @foreach($post_comments as $post_comment)
            <a href="/posts/{{ $post_comment->post->id }}">
                <div>{{ $post_comment->comment }}</div>
            </a>
        @endforeach
    </div>
    
    <div class='paginate'>
        {{ $post_comments->links() }}
    </div>
    
    <!--生写真トレード投稿-->
    <div>
        <p>★生写真トレード投稿</p>
        
        <!--件数表示-->
        @if (count($trades) > 0)
            <p>全{{ $trades->total() }}件中  
               {{ ($trades->currentPage() - 1) * $trades->perPage() + 1 }} - 
               {{ ($trades->currentPage() - 1) * $trades->perPage() + count($trades) }}件の投稿が表示されています。</p>
        @else
            <p>投稿がありません。</p>
        @endif
        
        <!--生写真トレード投稿-->
        @foreach($trades as $trade)
            <a href="/trades/{{ $trade->id }}">
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
                    @php
                        $offers_divided_by_series = $trade->pictures()->where('kind', 0)->get()->groupBy('series_id');
                    @endphp
                    
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
                    @php
                        $requests_divided_by_series = $trade->pictures()->where('kind', 1)->get()->groupBy('series_id');
                    @endphp
                        
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
            </a>
        @endforeach
    </div>
    
    <div class='paginate'>
        {{ $trades->links() }}
    </div>
    
    <!--生写真トレード投稿へのコメント-->
    <div>
        <p>★生写真トレード投稿へのコメント</p>
        
        <!--コメントの件数表示-->
        @if (count($trade_comments) > 0)
            <p>全{{ $trade_comments->total() }}件中  
               {{ ($trade_comments->currentPage() - 1) * $trade_comments->perPage() + 1 }} - 
               {{ ($trade_comments->currentPage() - 1) * $trade_comments->perPage() + count($trade_comments) }}件のコメントが表示されています。</p>
        @else
            <p>コメントがありません。</p>
        @endif
        
        <!--コメント一覧-->
        @foreach($trade_comments as $trade_comment)
            <a href="/trades/{{ $trade_comment->trade->id }}">
                <div>{{ $trade_comment->comment }}</div>
            </a>
        @endforeach
    </div>
    
    <div class='paginate'>
        {{ $trade_comments->links() }}
    </div>
    
    
</x-app-layout>