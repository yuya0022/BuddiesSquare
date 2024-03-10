<x-app-layout>
    
    <!--投稿作成画面への導線-->
    <a href='/trades/create'>投稿を作成する</a>
    
    <!--条件検索フォーム-->
    <h1>【条件検索】</h1>
    <form action="/trades/search" method="GET">
        @csrf
        
        <!--トレード方法-->
        <div>
             <x-input-label :value="__('トレード方法')" />
             <select multiple name="methods[]">
                <option value="0" @if(!empty($methods) && in_array("0", $methods)) selected @endif>郵送</option>
                @foreach($collection_of_eventinfo as $eventinfo)
                    <option value="{{ $eventinfo->id }}" @if(!empty($methods) && in_array("$eventinfo->id", $methods)) selected @endif>
                        {{ $eventinfo->event->name }}　{{ $eventinfo->date }}　{{ $eventinfo->venue }} 
                    </option>
                @endforeach
            </select>
        </div>
        
        <!--提供-->
        <div>
            <x-input-label :value="__('あなたが提供するもの')" />
            
            @for($location_num = 0; $location_num < 5; $location_num++)
                
                <!--location-$location_num-->
                <div>
                    <!--シリーズ選択-->
                    <select id="offer_series_location-{{ $location_num }}" onchange="offerViewChange({{ $location_num }});"
                            name="offer_series[location-{{ $location_num }}]">
                        <option value="">選択してください</option>
                        @foreach($series_with_pictures as $series)
                            <option value="{{ $series->id }}" @if($offer_series["location-" . $location_num] == $series->id) selected @endif>
                                {{ $series->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!--シリーズ選択時の表示内容-->
                    @foreach($series_with_pictures as $series)
                        @php
                            $pictures_divided_by_member = $series->pictures->groupBy('member_id');
                        @endphp
                        
                        <!--各シリーズの表-->
                        <div id="offer_chart_location-{{ $location_num }}_{{ $series->id }}" style="display:none;">
                            @foreach($pictures_divided_by_member as $pictures)
                                <span>{{ $pictures[0]->member->name }}：</span>
                                @foreach($pictures as $picture)
                                    <label>
                                        <input class="offer_checks_location-{{ $location_num }}" type="checkbox" 
                                                value="{{ $picture->id }}" name="offers[location-{{ $location_num }}][]"
                                                @if(!empty($offers["location-" . $location_num]) && 
                                                    in_array("$picture->id", $offers["location-" . $location_num]) ) checked @endif>
                                            {{ $picture->type->name }}
                                        </input>
                                    </label>
                                @endforeach
                                <br>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endfor
        </div>
        
        <!--要求-->
        <div>
            <x-input-label :value="__('あなたが要求するもの')" />
            
            @for($location_num = 0; $location_num < 5; $location_num++)
                
                <!--location-$location_num--> 
                <div>
                    <!--シリーズ選択-->
                    <select id="request_series_location-{{ $location_num }}" onchange="requestViewChange({{ $location_num }});"
                            name="request_series[location-{{ $location_num }}]">
                        <option value="">選択してください</option>
                        @foreach($series_with_pictures as $series)
                            <option value="{{ $series->id }}" @if($request_series["location-" . $location_num] == $series->id) selected @endif>
                                {{ $series->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!--シリーズ選択時の表示内容-->
                    @foreach($series_with_pictures as $series)
                        @php
                            $pictures_divided_by_member = $series->pictures->groupBy('member_id');
                        @endphp
                        
                        <!--各シリーズの表-->
                        <div id="request_chart_location-{{ $location_num }}_{{ $series->id }}" style="display:none;">
                            @foreach($pictures_divided_by_member as $pictures)
                                <span>{{ $pictures[0]->member->name }}：</span>
                                @foreach($pictures as $picture)
                                    <label>
                                        <input class="request_checks_location-{{ $location_num }}" type="checkbox" 
                                                value="{{ $picture->id }}" name="requests[location-{{ $location_num }}][]"
                                                @if(!empty($requests["location-" . $location_num]) && 
                                                    in_array("$picture->id", $requests["location-" . $location_num]) ) checked @endif>
                                            {{ $picture->type->name }}
                                        </input>
                                    </label>
                                @endforeach
                                <br>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endfor
        </div>
        
        <!--検索ボタン-->
        <div>
            <input type="submit" value="検索する"/>
        </div>
    </form>
    
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
    
    <script async>
    $(function () {
        $('select').multipleSelect({
            width: 200,
            formatSelectAll: function() {
                return 'すべて';
            },
            formatAllSelected: function() {
                return '全て選択されています';
            }
        });
    });
    
    function offerUncheckAll(location_num){
        const elements = document.getElementsByClassName(`offer_checks_location-${location_num}`);
        for (let i = 0; i < elements.length; i++) {
            elements[i].checked = false;
        }
    }
    
    function requestUncheckAll(location_num){
        const elements = document.getElementsByClassName(`request_checks_location-${location_num}`);
        for (let i = 0; i < elements.length; i++) {
            elements[i].checked = false;
        }
    }
    
    function offerViewChange(location_num){
        
        // 表示の切り替え
        const value = document.getElementById(`offer_series_location-${location_num}`).value;
        const js_series_with_pictures = <?php echo $php_series_with_pictures; ?>;
        for(i = 0; i < js_series_with_pictures.length; i++){
            if(js_series_with_pictures[i] == value){
                document.getElementById(`offer_chart_location-${location_num}_${js_series_with_pictures[i]}`).style.display = "";
            } else {
                document.getElementById(`offer_chart_location-${location_num}_${js_series_with_pictures[i]}`).style.display = "none";
            }
        }
        
        // 全解除ボタンを押す
        offerUncheckAll(location_num);
    }
    
    function requestViewChange(location_num){
        
        // 表示の切り替え
        const value = document.getElementById(`request_series_location-${location_num}`).value;
        const js_series_with_pictures = <?php echo $php_series_with_pictures; ?>;
        for(i = 0; i < js_series_with_pictures.length; i++){
            if(js_series_with_pictures[i] == value){
                document.getElementById(`request_chart_location-${location_num}_${js_series_with_pictures[i]}`).style.display = "";
            } else {
                document.getElementById(`request_chart_location-${location_num}_${js_series_with_pictures[i]}`).style.display = "none";
            }
        }
        
        // 全解除ボタンを押す
        requestUncheckAll(location_num);
    }
    
    window.onload = function() {
        for(i = 0; i < 5; i++){
            if(document.getElementById(`offer_series_location-${i}`).value){
                document.getElementById(`offer_chart_location-${i}_${document.getElementById(`offer_series_location-${i}`).value}`).style.display = "";
            }
            if(document.getElementById(`request_series_location-${i}`).value){
                document.getElementById(`request_chart_location-${i}_${document.getElementById(`request_series_location-${i}`).value}`).style.display = "";
            }
        }
    };
    </script>
</x-app-layout>