<x-app-layout>
    
    <h1>生写真トレード投稿作成</h1>
    <form action="/trades" method="POST">
        @csrf
        
        <!--トレード方法-->
        <div>
            <x-input-label :value="__('【必須】　トレード方法')" />
            <select multiple name="methods[]">
                <option value="0">郵送</option>
                @foreach($collection_of_eventinfo as $eventinfo)
                    <option value="{{ $eventinfo->id }}">{{ $eventinfo->event->name }}　{{ $eventinfo->date }}　{{ $eventinfo->venue }} </option>
                @endforeach
            </select>
        </div>
        
        <!--提供-->
        <div>
            <x-input-label :value="__('【必須】　提供')" />
            
            @for($i = 1; $i <= 10; $i++)
                <!--i番目（location i）-->
                <div>
                    <!--シリーズ選択-->
                    <select onchange="offerviewChange(this, {{ $i }});">
                        <option value="">選択してください</option>
                        @foreach($series_with_pictures as $series)
                            <option value="{{ $series->id }}">{{ $series->name }}</option>
                        @endforeach
                    </select>
                    
                    <!--表示内容-->
                    @foreach($series_with_pictures as $series)
                        @php
                            $pictures_divided_by_member = $series->pictures->groupBy('member_id');
                        @endphp
                        
                        <!--各シリーズの表-->
                        <div id="offerchart_{{ $i }}_{{ $series->id }}" style="display:none;">
                            @foreach($pictures_divided_by_member as $pictures)
                                <span>{{ $pictures[0]->member->name }}：</span>
                                @foreach($pictures as $picture)
                                    <label>
                                        <input type="checkbox" value="{{ $picture->id }}" name="offers[]">{{ $picture->type->name }}</input>
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
            <x-input-label :value="__('【必須】　要求')" />
            
            @for($i = 1; $i <= 10; $i++)
                <!--i番目（location i）--> 
                <div>
                    <!--シリーズ選択-->
                    <select onchange="requestviewChange(this, {{ $i }});">
                        <option value="">選択してください</option>
                        @foreach($series_with_pictures as $series)
                            <option value="{{ $series->id }}">{{ $series->name }}</option>
                        @endforeach
                    </select>
                    
                    <!--表示内容-->
                    @foreach($series_with_pictures as $series)
                        @php
                            $pictures_divided_by_member = $series->pictures->groupBy('member_id');
                        @endphp
                        
                        <!--各シリーズの表-->
                        <div id="requestchart_{{ $i }}_{{ $series->id }}" style="display:none;">
                            @foreach($pictures_divided_by_member as $pictures)
                                <span>{{ $pictures[0]->member->name }}：</span>
                                @foreach($pictures as $picture)
                                    <label>
                                        <input type="checkbox" value="{{ $picture->id }}" name="requests[]">{{ $picture->type->name }}</input>
                                    </label>
                                @endforeach
                                <br>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endfor
        </div>
        
        <!--コメントや注意事項-->
        <div>
            <x-input-label :value="__('コメントや注意事項')" />
            <textarea name="note"></textarea>
        </div>
        
        <!--投稿ボタン-->
        <div>
            <input type="submit" value="投稿する"/>
        </div>
    </form>
    
    <script>
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
    
    function offerviewChange(obj, location_num){
        const index = obj.selectedIndex;
        const value = obj.options[index].value;
        const js_series_with_pictures = <?php echo $php_series_with_pictures; ?>;
        
        for(i = 0; i < js_series_with_pictures.length; i++){
            if(js_series_with_pictures[i] == value){
                document.getElementById(`offerchart_${location_num}_${js_series_with_pictures[i]}`).style.display = "";
            } else {
                document.getElementById(`offerchart_${location_num}_${js_series_with_pictures[i]}`).style.display = "none";
            }
        }
    }
    
    function requestviewChange(obj, location_num){
        const index = obj.selectedIndex;
        const value = obj.options[index].value;
        const js_series_with_pictures = <?php echo $php_series_with_pictures; ?>;
        
        for(i = 0; i < js_series_with_pictures.length; i++){
            if(js_series_with_pictures[i] == value){
                document.getElementById(`requestchart_${location_num}_${js_series_with_pictures[i]}`).style.display = "";
            } else {
                document.getElementById(`requestchart_${location_num}_${js_series_with_pictures[i]}`).style.display = "none";
            }
        }
    }
    </script>
</x-app-layout>