<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Event;
use App\Models\EventInfo;
use App\Models\Member;
use App\Models\Song;
use App\Models\SubImage;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Cloudinary;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Member $member, Song $song, EventInfo $eventinfo): View
    {
        return view('auth.register')->with([
            'members' => $member->get(),
            'songs' => $song->get(),
            'collection_of_eventinfo' => $eventinfo->get(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'main_image' => ['required'], 
            // 'sub_images' はバリデーション不要
            // 'bithday' はバリデーション不要
            // 'sex' はバリデーション不要
            'residence' => ['required', 'string', 'max:255'],
            'x_user_name' => ['nullable', 'string', 'min:4', 'max:16'],
            'status_message' => ['required', 'string', 'max:50'],
            // 'fan_career' はバリデーション不要
            'members' => ['required'],
            'self-introduction' => ['required', 'string', 'max:1000'],
            'songs' => ['required'],
            // 'collection_of_eventinfo' はバリデーション不要
            'answer_1' => ['nullable', 'string', 'max:1000'],
            'answer_2' => ['nullable', 'string', 'max:1000'],
            'answer_3' => ['nullable', 'string', 'max:1000'],
            'answer_4' => ['nullable', 'string', 'max:1000'],
            'answer_5' => ['nullable', 'string', 'max:1000'],
            'answer_6' => ['nullable', 'string', 'max:1000'],
        ]);

        $main_image_url = Cloudinary::upload($request->file('main_image')->getRealPath())->getSecurePath();
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'main_image' => $main_image_url,
            'birthday' => $request->birthday,
            'sex' => intval($request->sex),
            'residence' => $request->residence,
            'x_user_name' => $request->x_user_name,
            'status_message' => $request->status_message,
            'fan_career' => $request->fan_career,
            'self-introduction' => $request['self-introduction'],
        ]);
        
        //sub_imagesテーブルへの保存処理
        $files = $request->file('sub_images');
        if(isset($files)) {
            foreach($files as $file){
                $file_url = Cloudinary::upload($file->getRealPath())->getSecurePath();
                SubImage::create([
                    'user_id' => $user->id,
                    'path' => $file_url,
                ]);
            }
        }
        
        //answersテーブルへの保存処理
        Answer::create([
            'user_id' => $user->id,
            'answer_1' => $request->answer_1,
            'answer_2' => $request->answer_2,
            'answer_3' => $request->answer_3,
            'answer_4' => $request->answer_4,
            'answer_5' => $request->answer_5,
            'answer_6' => $request->answer_6,
        ]);
        
        //member_userテーブルへの保存処理
        $user->members()->attach($request->members);
        
        //song_userテーブルへの保存処理
        $user->songs()->attach($request->songs);
        
        //event_info_userテーブルへの保存処理
        $user->event_info()->attach($request->collection_of_eventinfo);


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
