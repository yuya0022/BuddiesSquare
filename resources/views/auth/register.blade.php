<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="create_account">
            <h1>アカウント作成</h1>
            
            <!-- 名前（ニックネーム可） -->
            <div>
                <x-input-label for="name" :value="__('【必須】　名前（ニックネーム可）')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            
            <!-- メールアドレス -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('【必須】　メールアドレス')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
            <!-- パスワード -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('【必須】　パスワード')" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- パスワード（確認用） -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('【必須】　パスワード（確認）')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
        
        <div class="create_profile">
            <h1>プロフィール作成</h1>
            
            <!--プロフィール写真（メイン）-->
            <div>
                <x-input-label for="main_image" :value="__('【必須】　プロフィール写真（メイン）')" />
                <input id="main_image" name="main_image" type="file" accept='image/*' onchange="previewImage(this, 1);">
                <img id="preview_1" src="" style="max-width:200px;">
                <x-input-error :messages="$errors->get('main_image')" class="mt-2" />
            </div>
            
            <!--プロフィール写真（サブ）-->
            <div>
                <x-input-label for="sub_image" :value="__('プロフィール写真（サブ）')" />
                <input id="sub_image" name="sub_images[]" type="file" accept='image/*' onchange="previewImage(this, 2);">
                <img id="preview_2" src="" style="max-width:200px;">
                @for($i = 0; $i < 8; $i++)
                    <input name="sub_images[]" type="file" accept='image/*' onchange="previewImage(this, {{ $i + 3 }});">
                    <img id="preview_{{ $i + 3 }}" src="" style="max-width:200px;">
                @endfor
            </div>
            
            <!--生年月日-->
            <div>
                <x-input-label for="birthday" :value="__('【必須, 変更不可】　生年月日')" />
                <input id="birthday" type="date" name="birthday" value="{{old('birthday', '2000-01-01')}}" >
            </div>
            
            <!--性別-->
            <div>
                <x-input-label for="sex" :value="__('【必須, 変更不可】　性別')" />
        　　　　<input id="sex" type="radio" name="sex" value="0" @if( old('sex', '0') === '0' ) checked @endif>女性
        　　　　<input id="sex" type="radio" name="sex" value="1" @if( old('sex') === '1' ) checked @endif>男性
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
                <x-input-label for="residence" :value="__('【必須】　居住地')" />
                <select id="residence" name="residence">
                    <option value="">選択してください</option>
                    @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture }}" @if(old('residence') === $prefecture) selected @endif>{{ $prefecture }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('residence')" class="mt-2" />
            </div>
            
            <!--X（旧Twitter）のユーザー名-->
            <div>
                <x-input-label for="x_user_name" :value="__('X（旧Twitter）のユーザー名')" />
                <x-text-input id="x_user_name" class="block mt-1 w-full" type="text" name="x_user_name" placeholder="@sakurazaka46" :value="old('x_user_name')"/>
                <x-input-error :messages="$errors->get('x_user_name')" class="mt-2" />
            </div>
            
            <!--ひとこと-->
            <div>
                <x-input-label for="status_message" :value="__('【必須】　ひとこと')" />
                <x-text-input id="status_message" class="block mt-1 w-full" type="text" name="status_message" :value="old('status_message')"/>
                <p>※ 50字以内で入力してください</p>
                <x-input-error :messages="$errors->get('status_message')" class="mt-2" />
            </div>
            
            <!--ファン歴-->
            <div>
                <x-input-label for="fan_career" :value="__('【必須】　ファン歴')" />
                <input id="fan_career" type="date" name="fan_career" value="{{old('fan_career', '2020-01-01')}}">　～
            </div>
            
            <!--推しメン-->
            <div>
                <x-input-label for="members" :value="__('【必須】　推しメン')" />
                <select multiple id="members" name="members[]">
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" @if(!empty(old('members')) && in_array("$member->id", old('members'))) selected @endif>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('members')" class="mt-2" />
            </div>
            
            <!--自己紹介-->
            <div>
                <x-input-label for="self-introduction" :value="__('【必須】　自己紹介')" />
                <textarea id="self-introduction" name="self-introduction"> {{ old('self-introduction') }} </textarea>
                <p>※ 1000字以内で入力してください</p>
                <x-input-error :messages="$errors->get('self-introduction')" class="mt-2" />
            </div>
            
            <!--好きな楽曲-->
            <div>
                <x-input-label for="songs" :value="__('【必須】　好きな楽曲')" />
                <select multiple id="songs" name="songs[]">
                    @foreach($songs as $song)
                        <option value="{{ $song->id }}"
                                @if(!empty(old('songs')) && in_array("$song->id", old('songs'))) selected @endif>
                        {{ $song->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('songs')" class="mt-2" />
            </div>
            
            <!--ライブ・イベント参戦歴-->
            <div>
                <x-input-label for="eventinfo" :value="__('ライブ・イベント参戦歴')" />
                <select multiple id="eventinfo" name="collection_of_eventinfo[]">
                    @foreach($collection_of_eventinfo as $eventinfo)
                        <option value="{{ $eventinfo->id }}"
                                @if(!empty(old('collection_of_eventinfo')) && in_array("$eventinfo->id", old('collection_of_eventinfo'))) selected @endif> 
                        {{ $eventinfo->event->name }}　{{ $eventinfo->date }}　{{ $eventinfo->venue }} 
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="q_and_a">
            <h1>質問コーナー</h1>
            <p>※Q1～Q6のいずれも、1000字以内で入力してください</p>
            
            <!--Q1-->
            <div>
                <x-input-label for="answer_1" :value="__('Q1.　欅坂46, 櫻坂46を好きになったきっかけは？')" />
                <textarea id="answer_1" name="answer_1">{{ old('answer_1') }}</textarea>
                <x-input-error :messages="$errors->get('answer_1')" class="mt-2" />
            </div>
            
            <!--Q2-->
            <div>
                <x-input-label for="answer_2" :value="__('Q2.  推しメンを好きになったきっかけは？')" />
                <textarea id="answer_2" name="answer_2">{{ old('answer_2') }}</textarea>
                <x-input-error :messages="$errors->get('answer_2')" class="mt-2" />
            </div>
            
            <!--Q3-->
            <div>
                <x-input-label for="answer_3" :value="__('Q3.  あなたの思う、欅坂46, 櫻坂46の魅力を教えてください！')" />
                <textarea id="answer_3" name="answer_3">{{ old('answer_3') }}</textarea>
                <x-input-error :messages="$errors->get('answer_3')" class="mt-2" />
            </div>
            
            <!--Q4-->
            <div>
                <x-input-label for="answer_4" :value="__('Q4.  あなたの思う、推しメンの魅力を教えてください！')" />
                <textarea id="answer_4" name="answer_4">{{ old('answer_4') }}</textarea>
                <x-input-error :messages="$errors->get('answer_4')" class="mt-2" />
            </div>
            
            <!--Q5-->
            <div>
                <x-input-label for="answer_5" :value="__('Q5.  最も印象に残っているライブについて教えてください！')" />
                <textarea id="answer_5" name="answer_5">{{ old('answer_5') }}</textarea>
                <x-input-error :messages="$errors->get('answer_5')" class="mt-2" />
            </div>
            
            <!--Q6-->
            <div>
                <x-input-label for="answer_6" :value="__('Q6.  握手会・ミーグリでの思い出を教えてください！')" />
                <textarea id="answer_6" name="answer_6">{{ old('answer_6') }}</textarea>
                <x-input-error :messages="$errors->get('answer_6')" class="mt-2" />
            </div>
        </div>
        
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('アカウントをお持ちの方') }}
            </a>
            <x-primary-button class="ml-4">
                {{ __('登録する') }}
            </x-primary-button>
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
    </script>
</x-guest-layout>