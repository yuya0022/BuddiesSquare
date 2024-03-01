<x-app-layout>
    
    <div>
        <a href="/trades">トレード一覧に戻る</a>
    </div>
    
    <!--トレード投稿-->
    <div>
        <!--投稿者情報-->
        <div class="icon">
            <img src="{{ $trade->user->main_image }}" alt="画像が読み込めません。"/>
        </div>
        <p>{{ $trade->user->name }}</p>
        <p>{{ \Carbon\Carbon::parse($trade->user->birthday)->age }}歳</p>
        
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
                    
            <!--コメントや注意事項-->
            <p>【コメントや注意事項】</p>
            <p>{{ $trade->note }}</p>
        </div>    
    </div>
</x-app-layout>