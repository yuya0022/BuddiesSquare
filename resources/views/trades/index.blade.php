<x-app-layout>
    
    <!--投稿作成画面への導線-->
    <a href='/trades/create'>投稿を作成する</a>
    
    <!--件数表示-->
    @if (count($trades) > 0)
        <p>全{{ $trades->total() }}件中  
           {{ ($trades->currentPage() - 1) * $trades->perPage() + 1 }} - 
           {{ ($trades->currentPage() - 1) * $trades->perPage() + count($trades) }}件の投稿が表示されています。</p>
    @else
        <p>投稿がありません。</p>
    @endif
    
    <!--トレード投稿-->
    <div>
        @foreach($trades as $trade)
        
            <!--投稿者情報-->
            <div class="icon">
                <img src="{{ $trade->user->main_image }}" alt="画像が読み込めません。"/>
            </div>
            <p>{{ $trade->user->name }}</p>
            <p>{{ \Carbon\Carbon::parse($trade->user->birthday)->age }}歳</p>
            
            <!--投稿内容-->
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
</x-app-layout>