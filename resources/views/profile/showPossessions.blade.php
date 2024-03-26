<x-app-layout>
    <div class='posts_container'>
    
        <!--ライブ・イベント投稿-->
        <div>
            <x-input-label class='conditional_search' :value="__('ライブ・イベント投稿')" />
    
            <!--件数表示-->
            <div class='number_of_posts'>
                @if (count($posts) > 0)
                    <p>全{{ $posts->total() }}件中  
                       {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }} - 
                       {{ ($posts->currentPage() - 1) * $posts->perPage() + count($posts) }}件の投稿が表示されています。</p>
                @else
                    <p>投稿がありません。</p>
                @endif
            </div>
            
            <!--投稿-->
            <div>
                @foreach($posts as $post)
                    <div class='post'>
                        <a href="/posts/{{ $post->id }}">
                            <div>{{ $post->body }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $posts->links() }}
            </div>
        </div>
        
        <!--ライブ・イベント投稿へのコメント-->
        <div>
            <x-input-label class='conditional_search' :value="__('ライブ・イベント投稿へのコメント')" />
            
            <!--コメントの件数表示-->
            <div class='number_of_posts'>
                @if (count($post_comments) > 0)
                    <p>全{{ $post_comments->total() }}件中  
                       {{ ($post_comments->currentPage() - 1) * $post_comments->perPage() + 1 }} - 
                       {{ ($post_comments->currentPage() - 1) * $post_comments->perPage() + count($post_comments) }}件のコメントが表示されています。</p>
                @else
                    <p>コメントがありません。</p>
                @endif
            </div>
            
            <!--コメント一覧-->
            <div>
                @foreach($post_comments as $post_comment)
                    <div class='post'>
                        <a href="/posts/{{ $post_comment->post->id }}">
                            <div>{{ $post_comment->comment }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $post_comments->links() }}
            </div>
        </div>
        
        <!--生写真トレード投稿-->
        <div>
            <x-input-label class='conditional_search' :value="__('生写真トレード投稿')" />
            
            <!--件数表示-->
            <div class='number_of_posts'>
                @if (count($trades) > 0)
                    <p>全{{ $trades->total() }}件中  
                       {{ ($trades->currentPage() - 1) * $trades->perPage() + 1 }} - 
                       {{ ($trades->currentPage() - 1) * $trades->perPage() + count($trades) }}件の投稿が表示されています。</p>
                @else
                    <p>投稿がありません。</p>
                @endif
            </div>
            
            <!--生写真トレード投稿-->
            <div>
                @foreach($trades as $trade)
                    <div class='post'>
                        <a href="/trades/{{ $trade->id }}">
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
                                @php
                                    $offers_divided_by_series = $trade->pictures()->where('kind', 0)->get()->groupBy('series_id');
                                @endphp
                                
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
                                @php
                                    $requests_divided_by_series = $trade->pictures()->where('kind', 1)->get()->groupBy('series_id');
                                @endphp
                                
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
                        </a>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $trades->links() }}
            </div>
        </div>
        
        <!--生写真トレード投稿へのコメント-->
        <div>
            <x-input-label class='conditional_search' :value="__('生写真トレード投稿へのコメント')" />
            
            <!--コメントの件数表示-->
            <div class='number_of_posts'>
                @if (count($trade_comments) > 0)
                    <p>全{{ $trade_comments->total() }}件中  
                       {{ ($trade_comments->currentPage() - 1) * $trade_comments->perPage() + 1 }} - 
                       {{ ($trade_comments->currentPage() - 1) * $trade_comments->perPage() + count($trade_comments) }}件のコメントが表示されています。</p>
                @else
                    <p>コメントがありません。</p>
                @endif
            </div>
            
            <!--コメント一覧-->
            <div>
                @foreach($trade_comments as $trade_comment)
                    <div class='post'>
                        <a href="/trades/{{ $trade_comment->trade->id }}">
                            <div>{{ $trade_comment->comment }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $trade_comments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>