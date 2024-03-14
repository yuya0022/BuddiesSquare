<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\EventInfo;
use App\Models\Member;
use App\Models\Song;
use App\Models\SubImage;
use App\Models\User;
use Cloudinary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'sub_images' => $request->user()->sub_images,
            'answer' => $request->user()->answer,
            'members' => Member::get(),
            'favorite_members' => $request->user()->members->pluck('id')->all(),
            'songs' => Song::get(),
            'favorite_songs' => $request->user()->songs->pluck('id')->all(),
            'collection_of_eventinfo' => EventInfo::get(),
            'attended_eventinfo' => $request->user()->event_info->pluck('id')->all(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // usersテーブルの更新
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        
        $request->user()->save();
        
        // answersテーブルの更新
        $answers = [
            'answer_1' => $request->answer_1,
            'answer_2' => $request->answer_2,
            'answer_3' => $request->answer_3,
            'answer_4' => $request->answer_4,
            'answer_5' => $request->answer_5,
            'answer_6' => $request->answer_6,
        ];
        
        $request->user()->answer->fill($answers)->save();
        
        // member_userテーブルの更新
        $request->user()->members()->sync($request->members);
        
        // song_userテーブルの更新
        $request->user()->songs()->sync($request->songs);
        
        // event_info_userテーブルの更新
        $request->user()->event_info()->sync($request->collection_of_eventinfo);
        
        // リダイレクト
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    
    // プロフィール閲覧
    public function show(User $user)
    {
        if($user->id == auth()->user()->id){
            return redirect('/profile');
        } else {
            return view('profile.show')->with(['user' => $user]);
        }
    }
    
    // メイン写真
    public function main_image_update(Request $request)
    {
        $main_image_url = Cloudinary::upload($request->file('main_image')->getRealPath())->getSecurePath();
        
        $request->user()->main_image = $main_image_url;
        
        $request->user()->save();
        
        return Redirect::route('profile.edit');
    }
    
    
    // サブ写真
    public function sub_image_store(Request $request)
    {
        $sub_image_url = Cloudinary::upload($request->file('sub_image')->getRealPath())->getSecurePath();
        
        SubImage::create([
            'user_id' => auth()->user()->id,
            'path' => $sub_image_url,
        ]);
        
        return Redirect::route('profile.edit');
    }
    
    public function sub_image_update(Request $request, SubImage $sub_image)
    {
        $sub_image_url = Cloudinary::upload($request->file('sub_image')->getRealPath())->getSecurePath();
        
        $sub_image->path = $sub_image_url;
        
        $sub_image->save();
        
        return Redirect::route('profile.edit');
    }
    
    public function sub_image_delete(SubImage $sub_image)
    {
        $sub_image->delete();
        
        return Redirect::route('profile.edit');
    }
    
}