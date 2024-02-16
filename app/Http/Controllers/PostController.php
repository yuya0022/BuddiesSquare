<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;

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
}
