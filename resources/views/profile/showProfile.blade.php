<x-app-layout>
    
    <!--チャットページへの導線-->
    <div>
        <a href="/chat/{{ $user->id }}">{{ $user->name }}さん とチャットする</a>
    </div>
    
    <!--メイン写真-->
    <div>
         <x-input-label :value="__('プロフィール写真（メイン）')" />
         <img src="{{ $user->main_image }}" style="max-width:200px;">
    </div>
    
    <!--サブ写真-->
    <div>
        <x-input-label :value="__('プロフィール写真（サブ）')" />
        
        @for($i = 0; $i < count($user->sub_images); $i++)
            <img src="{{ $user->sub_images[$i]->path }}" style="max-width:200px;">
        @endfor
    </div>
    
    <!--名前-->
    <div>
        <x-input-label :value="__('名前（ニックネーム可）')" />
        <p>{{ $user->name }}</p>
    </div>
    
    <!--年齢-->
    <div>
        <x-input-label :value="__('年齢')" />
        <p>{{ \Carbon\Carbon::parse($user->birthday)->age }}歳</p>
    </div>
    
    <!--居住地-->
    <div>
        <x-input-label :value="__('居住地')" />
        <p>{{ $user->residence }}</p>
    </div>
    
    <!--X（旧Twitter）のユーザー名-->
    <div>
        <x-input-label :value="__('X（旧Twitter）のユーザー名')" />
        @if($user->x_user_name == "")
            <p>登録されていません</p>
        @else
            <p>{{ $user->x_user_name }}</p>
        @endif
    </div>
    
    <!--ひとこと-->
    <div>
        <x-input-label :value="__('ひとこと')" />
        <p>{{ $user->status_message }}</p>
    </div>
    
    <!--ファン歴-->
    <div>
        <x-input-label :value="__('ファン歴')" />
        <p>{{ $user->fan_career }} ～</p>
    </div>
    
    <!--推しメン-->
    <div>
        <x-input-label :value="__('推しメン')" />
        @foreach($user->members as $member)
            <p>{{ $member->name }}</p>
        @endforeach
    </div>
    
    <!--自己紹介-->
    <div>
        <x-input-label :value="__('自己紹介')" />
        <p>{{ $user['self-introduction'] }}</p>
    </div>
    
    <!--好きな楽曲-->
    <div>
        <x-input-label :value="__('好きな楽曲')" />
        @foreach($user->songs as $song)
            <p>{{ $song->name }}</p>
        @endforeach
    </div>
    
    <!--ライブ・イベント参戦歴-->
    <div>
        <x-input-label :value="__('ライブ・イベント参戦歴')" />
        @if(count($user->event_info) == 0)
            <p>登録されていません</p>
        @else
            @foreach($user->event_info as $event_info)
                <p>{{ $event_info->event->name }}　{{ $event_info->date }}　{{ $event_info->venue }}</p>
            @endforeach
        @endif
    </div>
    
    <!--質問コーナー-->
    <div>
        <h1>質問コーナー</h1>
        
        @php
            $questions = [
                "Q1.　欅坂46, 櫻坂46を好きになったきっかけは？", 
                "Q2.  推しメンを好きになったきっかけは？", 
                "Q3.  あなたの思う、欅坂46, 櫻坂46の魅力を教えてください！",
                "Q4.  あなたの思う、推しメンの魅力を教えてください！",
                "Q5.  最も印象に残っているライブについて教えてください！",
                "Q6.  握手会・ミーグリでの思い出を教えてください！"
            ];
        @endphp
        
        @for($i = 0; $i < 6; $i++)
            <div>
                <x-input-label :value="__($questions[$i])" />
                @if($user->answer["answer_" . $i + 1])
                    <p>{{ $user->answer["answer_" . $i + 1] }}</p>
                @else
                    <p>未回答</p>
                @endif
            </div>
        @endfor
    </div>
    
</x-app-layout>