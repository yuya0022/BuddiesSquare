<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class PostController extends Controller
{
    public function index(Event $event)
    {
        return view('posts.index')->with(['events' => $event->getPaginateByLimit()]);
    }
}
