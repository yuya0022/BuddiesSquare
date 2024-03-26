<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    
    <div>
        <x-input-label class='profile_major_heading margin_top_-1px' :value="__('基本情報')" />
   
        <!--ここからメイン写真-->
        <div>
            <x-input-label class='profile_heading' :value="__('【必須】　プロフィール写真（メイン）')" />
            
            <!--メイン写真表示-->
            <img src="{{ $user->main_image }}" style="max-width:200px;">
            
            <!--変更する-->
            <form class='margin_top_5px' action="/main_image" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label for="main_image_change" class='update_button_style'>変更する</label>
                <input id="main_image_change" class='profile_image' type="file" name="main_image" accept='image/*' onchange="submit(this.form)">
            </form>
        </div>
        <!--ここまでメイン写真-->
        
        
        <!--ここからサブ写真-->     
        <x-input-label class='profile_heading' :value="__('プロフィール写真（サブ）')" />
        
        @for($i = 0; $i < count($sub_images); $i++)
            <!--サブ写真表示-->
            <img src="{{ $sub_images[$i]->path }}" style="max-width:200px;">
            
            <div class='margin_bottom_25px margin_top_5px'>
                <!--変更する-->
                <form action="/sub_images/{{ $sub_images[$i]->id }}" method="POST" enctype="multipart/form-data" style="display:inline-block;">
                    @csrf
                    @method('PUT')
                    <label for="sub_image_change_{{ $i }}" class='update_button_style'>変更する</label>
                    <input id="sub_image_change_{{ $i }}" class='profile_image' type="file" name="sub_image" accept='image/*' onchange="submit(this.form)">
                </form>
                
                <!--削除する-->
                <form action="/sub_images/{{ $sub_images[$i]->id }}" id="form_{{ $sub_images[$i]->id }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class='delete_button' type="button" onclick="deleteSubImage({{ $sub_images[$i]->id }})">削除する</button>
                </form>
            </div>
        @endfor
        @for($i = count($sub_images); $i < 9; $i++)
            <!--ダミー画像-->
            <img src="https://placehold.jp/300x200.png" style="max-width:200px;">
            
            <!--追加する-->
            <form class='margin_bottom_25px margin_top_5px' action="/sub_images" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="sub_image_add_{{ $i }}" class='add_button_style'>追加する</label>
                <input id="sub_image_add_{{ $i }}" class='profile_image' type="file" name="sub_image" accept='image/*' onchange="submit(this.form)">
            </form>
        @endfor
        <!--ここまでサブ写真-->
        
    
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')
            
            <!--アカウント-->
            <div>
                <!-- 名前（ニックネーム可） -->
                <div>
                    <x-input-label for="name" class='profile_heading' :value="__('【必須】　名前（ニックネーム可）')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required  autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
        
                <!-- メールアドレス -->
                <div>
                    <x-input-label for="email" class='profile_heading' :value="__('【必須】　メールアドレス')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
        
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}
        
                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>
        
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <!--プロフィール-->
            <div>
                <!--生年月日-->
                <div>
                    <x-input-label for="birthday" class='profile_heading' :value="__('【必須, 変更不可】　生年月日')" />
                    <input id="birthday" type="date" name="birthday" value="{{ $user->birthday }}" disabled>
                </div>
                
                <!--性別-->
                <div>
                    <x-input-label for="sex" class='profile_heading' :value="__('【必須, 変更不可】　性別')" />
            　　　　<input id="sex" type="radio" name="sex" value="0" @if( $user->sex === 0 ) checked @endif disabled>女性
               　　　<input id="sex" type="radio" name="sex" value="1" @if( $user->sex === 1 ) checked @endif disabled>男性
                </div>
                
                <!--居住地-->
                @php
                    $prefectures = [
                        "北海道", "青森県", "岩手県", "宮城県", "秋田県", "山形県", "福島県", "茨城県", "栃木県", "群馬県",
                        "埼玉県", "千葉県", "東京都", "神奈川県", "新潟県", "富山県", "石川県", "福井県", "山梨県", "長野県",
                        "岐阜県", "静岡県", "愛知県", "三重県", "滋賀県", "京都府", "大阪府", "兵庫県", "奈良県", "和歌山県",
                        "鳥取県", "島根県", "岡山県", "広島県", "山口県", "徳島県", "香川県", "愛媛県", "高知県", "福岡県",
                        "佐賀県", "長崎県", "熊本県", "大分県", "宮崎県", "鹿児島県", "沖縄県", "海外"
                    ];
                @endphp
                <div>
                    <x-input-label for="residence" class='profile_heading' :value="__('【必須】　居住地')" />
                    <select id="residence" name="residence">
                        <option value="">選択してください</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture }}" @if(old('residence', $user->residence) === $prefecture) selected @endif>{{ $prefecture }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('residence')" class="mt-2" />
                </div>        
                
                <!--X（旧Twitter）のユーザー名-->
                <div>
                    <x-input-label for="x_user_name" class='profile_heading' :value="__('X（旧Twitter）のユーザー名')" />
                    <x-text-input id="x_user_name" class="block mt-1 w-full" type="text" name="x_user_name" placeholder="@sakurazaka46" :value="old('x_user_name', $user->x_user_name)"/>
                    <x-input-error :messages="$errors->get('x_user_name')" class="mt-2" />
                </div>
        
                <!--ひとこと-->
                <div>
                    <x-input-label for="status_message" class='profile_heading' :value="__('【必須】　ひとこと')" />
                    <x-text-input id="status_message" class="block mt-1 w-full" type="text" name="status_message" :value="old('status_message', $user->status_message)"/>
                    <p>※ 50字以内で入力してください</p>
                    <x-input-error :messages="$errors->get('status_message')" class="mt-2" />
                </div>
                
                <!--ファン歴-->
                <div>
                    <x-input-label for="fan_career" class='profile_heading' :value="__('【必須】　ファン歴')" />
                    <input id="fan_career" type="date" name="fan_career" value="{{ old('fan_career', $user->fan_career) }}">　～
                </div>
                
                <!--推しメン-->
                <div>
                    <x-input-label for="members" class='profile_heading' :value="__('【必須】　推しメン')" />
                    <select multiple id="members" name="members[]">
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" 
                                @if(!empty(old('members', $favorite_members)) && in_array("$member->id", old('members', $favorite_members))) selected @endif>
                                    {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('members')" class="mt-2" />
                </div>
                
                <!--自己紹介-->
                <div>
                    <x-input-label for="self-introduction" class='profile_heading' :value="__('【必須】　自己紹介')" />
                    <textarea id="self-introduction" class='script_text' name="self-introduction"> {{ old('self-introduction', $user['self-introduction']) }} </textarea>
                    <p>※ 1000字以内で入力してください</p>
                    <x-input-error :messages="$errors->get('self-introduction')" class="mt-2" />
                </div>
                
                <!--好きな楽曲-->
                <div>
                    <x-input-label for="songs" class='profile_heading' :value="__('【必須】　好きな楽曲')" />
                    <select multiple id="songs" name="songs[]">
                        @foreach($songs as $song)
                            <option value="{{ $song->id }}"
                                    @if(!empty(old('songs', $favorite_songs)) && in_array("$song->id", old('songs', $favorite_songs))) selected @endif>
                            {{ $song->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('songs')" class="mt-2" />
                </div>
                
                <!--ライブ・イベント参戦歴-->
                <div>
                    <x-input-label for="eventinfo" class='profile_heading' :value="__('ライブ・イベント参戦歴')" />
                    <select multiple id="eventinfo" name="collection_of_eventinfo[]">
                        @foreach($collection_of_eventinfo as $eventinfo)
                            <option value="{{ $eventinfo->id }}"
                                    @if(!empty(old('collection_of_eventinfo', $attended_eventinfo)) && in_array("$eventinfo->id", old('collection_of_eventinfo', $attended_eventinfo))) selected @endif> 
                            {{ $eventinfo->event->name }}　{{ $eventinfo->date }}　{{ $eventinfo->venue }} 
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!--質問コーナー-->
            <div class='padding_top_10px'>
                <x-input-label class='profile_major_heading' :value="__('質問コーナー')" />
                <p class='question_note'>※ Q1~Q6 のいずれも, 1000字以内で入力してください</p>
                
                <!--Q1-->
                <div>
                    <x-input-label class='profile_heading' for="answer_1" :value="__('Q1.  欅坂46, 櫻坂46を好きになったきっかけは？')" />
                    <textarea id="answer_1" class='script_text' name="answer_1">{{ old('answer_1', $answer->answer_1) }}</textarea>
                    <x-input-error :messages="$errors->get('answer_1')" class="mt-2" />
                </div>
                
                <!--Q2-->
                <div>
                    <x-input-label class='profile_heading' for="answer_2" :value="__('Q2.  推しメンを好きになったきっかけは？')" />
                    <textarea id="answer_2" class='script_text' name="answer_2">{{ old('answer_2', $answer->answer_2) }}</textarea>
                    <x-input-error :messages="$errors->get('answer_2')" class="mt-2" />
                </div>
                
                <!--Q3-->
                <div>
                    <x-input-label class='profile_heading' for="answer_3" :value="__('Q3.  あなたの思う、欅坂46, 櫻坂46の魅力を教えてください！')" />
                    <textarea id="answer_3" class='script_text' name="answer_3">{{ old('answer_3', $answer->answer_3) }}</textarea>
                    <x-input-error :messages="$errors->get('answer_3')" class="mt-2" />
                </div>
                
                <!--Q4-->
                <div>
                    <x-input-label class='profile_heading' for="answer_4" :value="__('Q4.  あなたの思う、推しメンの魅力を教えてください！')" />
                    <textarea id="answer_4" class='script_text' name="answer_4">{{ old('answer_4', $answer->answer_4) }}</textarea>
                    <x-input-error :messages="$errors->get('answer_4')" class="mt-2" />
                </div>
                
                <!--Q5-->
                <div>
                    <x-input-label class='profile_heading' for="answer_5" :value="__('Q5.  最も印象に残っているライブについて教えてください！')" />
                    <textarea id="answer_5" class='script_text' name="answer_5">{{ old('answer_5', $answer->answer_5) }}</textarea>
                    <x-input-error :messages="$errors->get('answer_5')" class="mt-2" />
                </div>
                
                <!--Q6-->
                <div>
                    <x-input-label class='profile_heading' for="answer_6" :value="__('Q6.  握手会・ミーグリでの思い出を教えてください！')" />
                    <textarea id="answer_6" class='script_text' name="answer_6">{{ old('answer_6', $answer->answer_6) }}</textarea>
                    <x-input-error :messages="$errors->get('answer_6')" class="mt-2" />
                </div>
            </div>
            
    
            <div class="flex items-center gap-4">
                <div class='submit_container_2'>
                    <x-primary-button>{{ __('保存する') }}</x-primary-button>
                </div>
    
                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('保存されました') }}</p>
                @endif
            </div>
        </form>
    </div>
    
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
    
    function previewImage(obj, num)
    {
        if(obj.files.length === 0) {
            document.getElementById(`preview_${num}`).src = ''
            ;
        } else {
            var fileReader = new FileReader();
        	fileReader.onload = (function() {
        		document.getElementById(`preview_${num}`).src = fileReader.result;
        	});
        	fileReader.readAsDataURL(obj.files[0]);
        }
    }
    
    function deleteSubImage(id) {
        'use strict'

        if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
            document.getElementById(`form_${id}`).submit();
        }
    }
    </script>
</section>