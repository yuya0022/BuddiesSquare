<x-app-layout>
    <div class='posts_container'>
        <h1>生写真トレード投稿 編集ページ</h1>
        
        <form class='post comment_form' action="/trades/{{ $trade->id }}" method="POST">
            @csrf
            @method('PUT')
            
            <!--トレード方法-->
            <div class='condition_trade_methods'>
                <x-input-label class='heading' :value="__('【必須】　トレード方法')" />
                <select multiple name="methods[]">
                    <option value="0" @if(in_array("0", $selected_methods)) selected @endif>郵送</option>
                    @foreach($collection_of_eventinfo as $eventinfo)
                        <option value="{{ $eventinfo->id }}" @if(in_array("$eventinfo->id", $selected_methods)) selected @endif>
                            {{ $eventinfo->event->name }}　{{ $eventinfo->date }}　{{ $eventinfo->venue }} 
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('methods')" class="mt-2" />
            </div>
            
            <!--提供-->
            <div>
                <x-input-label class='heading' :value="__('【必須】　提供')" />
                
                @for($location_num = 0; $location_num < 5; $location_num++)
                    
                    <!--location-$location_num-->
                    <div>
                        <!--シリーズ選択-->
                        <select id="offer_series_location-{{ $location_num }}" onchange="offerViewChange({{ $location_num }});"
                                name="offer_series[location-{{ $location_num }}]">
                            <option value="">選択してください</option>
                            @foreach($series_with_pictures as $series)
                                <option value="{{ $series->id }}" @if($selected_offer_series["location-" . $location_num] == $series->id) selected @endif>
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
                                                    @if(!empty($selected_offers["location-" . $location_num]) && 
                                                        in_array("$picture->id", $selected_offers["location-" . $location_num])) checked @endif>
                                                                                    
                                                {{ $picture->type->name }}
                                            </input>
                                        </label>
                                    @endforeach
                                    <br>
                                @endforeach
                            </div>
                        @endforeach
                        
                        <!--全解除ボタン-->
                        <button id="offer_uncheck_location-{{ $location_num }}" type="button" onclick="offerUncheckAll({{ $location_num }});" style="display:none;">
                            全解除
                        </button>
                    </div>
                @endfor
                
                <x-input-error :messages="$errors->get('offers')" class="mt-2" />
            </div>
            
            <!--要求-->
            <div class='condition_requests'>
                <x-input-label class='heading' :value="__('【必須】　要求')" />
                
                @for($location_num = 0; $location_num < 5; $location_num++)
                    
                    <!--location-$location_num--> 
                    <div>
                        <!--シリーズ選択-->
                        <select id="request_series_location-{{ $location_num }}" onchange="requestViewChange({{ $location_num }});"
                                name="request_series[location-{{ $location_num }}]">
                            <option value="">選択してください</option>
                            @foreach($series_with_pictures as $series)
                                <option value="{{ $series->id }}" @if($selected_request_series["location-" . $location_num] == $series->id) selected @endif>
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
                                                    @if(!empty($selected_requests["location-" . $location_num]) && 
                                                        in_array("$picture->id", $selected_requests["location-" . $location_num])) checked @endif>
                                                {{ $picture->type->name }}
                                            </input>
                                        </label>
                                    @endforeach
                                    <br>
                                @endforeach
                            </div>
                        @endforeach
                        
                        <!--全解除ボタン-->
                        <button id="request_uncheck_location-{{ $location_num }}" type="button" onclick="requestUncheckAll({{ $location_num }});" style="display:none;">
                            全解除
                        </button>
                    </div>
                @endfor
                
                <x-input-error :messages="$errors->get('requests')" class="mt-2" />
            </div>
            
            <!--注意事項など-->
            <div>
                <x-input-label class='heading' :value="__('注意事項など')" />
                <textarea name="note" class='script_comment'>{{ $trade->note }}</textarea>
                <x-input-error :messages="$errors->get('note')" class="mt-2" />
                <p>※ 500字以内で入力してください</p>
            </div>
            
            <!--保存ボタン-->
            <div class='submit_container'>
                <button type='submit' class='submit_button'>保存する</button>
            </div>
        </form>
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
        document.getElementById(`offer_uncheck_location-${location_num}`).click();
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
        document.getElementById(`request_uncheck_location-${location_num}`).click();
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