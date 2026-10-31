<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class PostController extends Controller
{
    // Trang chu
    public function home()
    {
        $posts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $recentPosts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('posts', 'recentPosts'));
    }

    // Danh sach bai viet
    public function index()
    {
        $posts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('post_index', compact('posts'));
    }

    // Chi tiet bai viet
    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);

        return view('post_show', compact('post'));
    }

    // Form them bai viet
    public function create()
    {
        return view('post_create');
    }

    // Luu bai viet moi
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required' => 'Vui long nhap tieu de.',
            'title.max' => 'Tieu de khong duoc vuot qua 50 ky tu.',
            'content.required' => 'Vui long nhap noi dung.',
            'image.image' => 'Tep tai len phai la hinh anh.',
            'image.mimes' => 'Anh chi duoc co dinh dang JPG, JPEG, PNG hoac WEBP.',
            'image.max' => 'Dung luong anh khong duoc vuot qua 2 MB.',
        ]);

        $duongDanAnh = null;

        if ($request->hasFile('image')) {
            $duongDanAnh = $request->file('image')
                ->store('posts', 'public');
        }

        Post::create([
            // Tu dong gan bai viet cho nguoi dang nhap
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $duongDanAnh,
        ]);

        return redirect()->route('post.index')
            ->with('success', 'Them bai viet thanh cong.');
    }

    // Form sua bai viet
    public function edit($id)
    {
        // Chi chu bai viet moi duoc sua
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('post_edit', compact('post'));
    }

    // Cap nhat bai viet
    public function update(Request $request, $id)
    {
        // Kiem tra quyen so huu bai viet
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:50',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required' => 'Vui long nhap tieu de.',
            'title.max' => 'Tieu de khong duoc vuot qua 50 ky tu.',
            'content.required' => 'Vui long nhap noi dung.',
            'image.image' => 'Tep tai len phai la hinh anh.',
            'image.mimes' => 'Anh chi duoc co dinh dang JPG, JPEG, PNG hoac WEBP.',
            'image.max' => 'Dung luong anh khong duoc vuot qua 2 MB.',
        ]);

        $duongDanAnhCu = $post->image;

        $duLieu = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        // Neu chon anh moi
        if ($request->hasFile('image')) {
            $duongDanAnhMoi = $request->file('image')
                ->store('posts', 'public');

            $duLieu['image'] = $duongDanAnhMoi;
        }

        $post->update($duLieu);

        // Xoa anh cu sau khi cap nhat thanh cong
        if (
            $request->hasFile('image')
            && $duongDanAnhCu
            && $duongDanAnhCu != $post->image
        ) {
            Storage::disk('public')->delete($duongDanAnhCu);
        }

        return redirect()->route('post.index')
            ->with('success', 'Cap nhat bai viet thanh cong.');
    }

    // Xoa bai viet
    public function destroy($id)
    {
        // Chi chu bai viet moi duoc xoa
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Xoa file anh neu bai viet co anh
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('post.index')
            ->with('success', 'Xoa bai viet thanh cong.');
    }
}
