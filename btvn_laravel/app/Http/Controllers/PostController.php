<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    // Hien thi danh sach bai viet
    public function index()
    {
        $posts = DB::table('posts')->get();

        return view('home', ['posts' => $posts]);
    }

    // Hien thi bai viet theo ID
    public function show($id)
    {
        $post = DB::table('posts')
                    ->where('id', $id)
                    ->first();

        return view('post_show', ['post' => $post]);
    }
}
