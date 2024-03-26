<x-app-layout>
    <div class='posts_container'>
    
        <!--投稿作成画面への導線-->
        <a class='post_create_button_style' href='/trades/create'>トレード投稿を作成する</a>
        
        <!--条件検索フォーム-->
        <x-input-label class='conditional_search' :value="__('条件検索')" />
        <form class='post' action="/trades/search" method="GET">
            @csrf
            
            <!--トレード方法-->
            <div class='condition_trade_methods'>
                 <x-input-label class='heading' :value="__('【トレード方法】')" />
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
                <x-input-label class='heading' :value="__('【あなたが提供するもの】')" />
                
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
            <div class='condition_requests'>
                <x-input-label class='heading' :value="__('【あなたが要求するもの】')" />
                
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
            <div class='submit_container'>
                <button type='submit' class='submit_button'>検索する</button>
            </div>
        </form>
        
        <!--検索結果-->
        <div>
            <x-input-label class='search_results' :value="__('検索結果')" />
            
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
            
            <!--トレード投稿-->
            <div>
                @foreach($trades as $trade)
                    <div class='post'>
                        
                        <!--投稿者情報-->
                        <div class='icon_container'>
                            <a href="/profile/{{ $trade->user->id }}">
                                <div class="icon">
                                    <img src="{{ $trade->user->main_image }}" alt="画像が読み込めません。"/>
                                </div>
                            </a>
                        </div>
                        <a href="/profile/{{ $trade->user->id }}">{{ $trade->user->name }} &ensp; {{ \Carbon\Carbon::parse($trade->user->birthday)->age }}歳</a>
                        
                        <!--投稿内容-->
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