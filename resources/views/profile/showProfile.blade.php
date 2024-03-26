<x-app-layout>
    <div class='profile_container'>
        
        <h1>{{ $user->name }}さん&ensp;のプロフィール</h1>
        
        <div>
            <!--チャットページへの導線-->
            <a class='possessions_button_style' href="/chat/{{ $user->id }}">{{ $user->name }}さん とチャットする</a>
            
            <!--投稿・コメント一覧への導線-->
            <a class='possessions_button_style margin_left_10px' href="/possessions/{{ $user->id }}">{{ $user->name }}さんの投稿・コメント一覧</a>
        </div>
        
        <div class='profile_body'>
            
            <x-input-label class='profile_major_heading' :value="__('基本情報')" />
        
            <!--メイン写真-->
            <div>
                 <x-input-label class='profile_heading' :value="__('プロフィール写真（メイン）')" />
                 <img class='margin_left_10px' src="{{ $user->main_image }}" style="max-width:200px;">
            </div>
            
            <!--サブ写真-->
            <div>
                <x-input-label class='profile_heading' :value="__('プロフィール写真（サブ）')" />
                
                @for($i = 0; $i < count($user->sub_images); $i++)
                    <img class='margin_bottom_15px margin_left_10px' src="{{ $user->sub_images[$i]->path }}" style="max-width:200px;">
                @endfor
                
                @if(count($user->sub_images) == 0)
                    <p class='margin_left_10px'>登録されていません</p>
                @endif
            </div>
            
            <!--名前-->
            <div>
                <x-input-label class='profile_heading' :value="__('名前（ニックネーム可）')" />
                <p class='margin_left_10px'>{{ $user->name }}</p>
            </div>
            
            <!--年齢-->
            <div>
                <x-input-label class='profile_heading' :value="__('年齢')" />
                <p class='margin_left_10px'>{{ \Carbon\Carbon::parse($user->birthday)->age }}歳</p>
            </div>
            
            <!--居住地-->
            <div>
                <x-input-label class='profile_heading' :value="__('居住地')" />
                <p class='margin_left_10px'>{{ $user->residence }}</p>
            </div>
            
            <!--X（旧Twitter）のユーザー名-->
            <div>
                <x-input-label class='profile_heading' :value="__('X（旧Twitter）のユーザー名')" />
                @if($user->x_user_name == "")
                    <p class='margin_left_10px'>登録されていません</p>
                @else
                    <p class='margin_left_10px'>{{ $user->x_user_name }}</p>
                @endif
            </div>
            
            <!--ひとこと-->
            <div>
                <x-input-label class='profile_heading' :value="__('ひとこと')" />
                <p class='margin_left_10px'>{{ $user->status_message }}</p>
            </div>
            
            <!--ファン歴-->
            <div>
                <x-input-label class='profile_heading' :value="__('ファン歴')" />
                <p class='margin_left_10px'>{{ $user->fan_career }} ～</p>
            </div>
            
            <!--推しメン-->
            <div>
                <x-input-label class='profile_heading' :value="__('推しメン')" />
                @foreach($user->members as $member)
                    <p class='margin_left_10px'>{{ $member->name }}</p>
                @endforeach
            </div>
            
            <!--自己紹介-->
            <div>
                <x-input-label class='profile_heading' :value="__('自己紹介')" />
                <p class='margin_left_10px'>{{ $user['self-introduction'] }}</p>
            </div>
            
            <!--好きな楽曲-->
            <div>
                <x-input-label class='profile_heading' :value="__('好きな楽曲')" />
                @foreach($user->songs as $song)
                    <p class='margin_left_10px'>{{ $song->name }}</p>
                @endforeach
            </div>
            
            <!--ライブ・イベント参戦歴-->
            <div>
                <x-input-label class='profile_heading' :value="__('ライブ・イベント参戦歴')" />
                @if(count($user->event_info) == 0)
                    <p class='margin_left_10px'>登録されていません</p>
                @else
                    @foreach($user->event_info as $event_info)
                        <p class='margin_left_10px'>{{ $event_info->event->name }}　{{ $event_info->date }}　{{ $event_info->venue }}</p>
                    @endforeach
                @endif
            </div>
            
            <!--質問コーナー-->
            <div>
                <x-input-label class='profile_major_heading' :value="__('質問コーナー')" />
                
                @php
                    $questions = [
                        "Q1.  欅坂46, 櫻坂46を好きになったきっかけは？", 
                        "Q2.  推しメンを好きになったきっかけは？", 
                        "Q3.  あなたの思う、欅坂46, 櫻坂46の魅力を教えてください！",
                        "Q4.  あなたの思う、推しメンの魅力を教えてください！",
                        "Q5.  最も印象に残っているライブについて教えてください！",
                        "Q6.  握手会・ミーグリでの思い出を教えてください！"
                    ];
                @endphp
                
                @for($i = 0; $i < 6; $i++)
                    <div>
                        <x-input-label class='profile_heading' :value="__($questions[$i])" />
                        @if($user->answer["answer_" . $i + 1])
                            <p class='margin_left_10px'>{{ $user->answer["answer_" . $i + 1] }}</p>
                        @else
                            <p class='margin_left_10px'>未回答</p>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-app-layout>