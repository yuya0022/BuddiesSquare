<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index')->with(['events' => Event::with('event_info')->orderBy('id', 'DESC')->paginate(10)]);
    }
    
    public function show(Event $event, Category $category)
    {
        return view('posts.show')->with([
            'categories' => Category::get(),
            'selected_event' => $event,
            'selected_category' => $category,
            'selected_posts' => $event->posts()->with('user')->where('category_id', $category->id)->orderBy('updated_at', 'DESC')->paginate(10),
        ]);
    }
    
    public function showDetail(Post $post)
    {
        return view('posts.detail')->with(['post' => $post]);
    }
    
    public function create(Event $event, Category $category)
    {
        return view('posts.create')->with([
            'event' => $event,
            'category' => $category,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);
        
        $post = Post::create([
            'user_id' => $request->user()->id,
            'event_id' => $request->event_id,
            'category_id' => $request->category_id,
            'body' => $request->body,
        ]);
        
        return redirect('/posts/' . $post->id);
    }
    
    public function edit(Post $post)
    {
        if (auth()->user()->id == $post->user_id) {
            return view('posts.edit')->with(['post' => $post]);
        } else {
            return redirect('/posts/' . $post->id)->with('message', '※ 自分以外の投稿を編集することはできません');
        }
    }
    
    public function update(Request $request, Post $post)
    {
        if (auth()->user()->id == $post->user_id) {
            $request->validate([
                'body' => ['required', 'string', 'max:1000'],
            ]);
            
            $post->fill(['body' => $request->body])->save();
            
            return redirect('/posts/' . $post->id);
            
        } else {
            return redirect('/posts/' . $post->id)->with('message', '※ 自分以外の投稿を編集することはできません');
        }
    }
    
    public function delete(Post $post)
    {
        if (auth()->user()->id == $post->user_id) {
            $post->delete();
            return redirect('/posts/' . $post->event_id . '/' . $post->category_id);
        } else {
            return redirect('/posts/' . $post->id)->with('message', '※ 自分以外の投稿を削除することはできません');    
        }
    }
}
