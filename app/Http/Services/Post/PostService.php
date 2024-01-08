<?php


namespace App\Http\Services\Post;


use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostService
{
    const LIMIT = 2;
    public function insert($request)
    {
        try {
            Post::create([
                'title' =>(string) $request->input('title'),
                'content' =>(string) $request->input('content'),
                'thumb' =>(string) $request->input('thumb')
            ]);
            Session::flash('success', 'Thêm bài viết mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Lỗi thêm bài viết');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

   

    public function get()
    {
    
        return Post::orderByDesc('id')->paginate(4);
    }
    public function get_page()
    {
    
        return Post::orderByDesc('id')->paginate(3);
    }

    public function update($request, $post)
    {
        try {
            $post->fill($request->input());
            $post->save();
            Session::flash('success', 'Cập nhật Bài viết thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật Bài viết Lỗi');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function destroy($request)
    {
        $post = Post::where('id', $request->input('id'))->first();
        if ($post) {
            $path = str_replace('storage', 'public', $post->thumb);
            Storage::delete($path);
            $post->delete();
            return true;
        }

        return false;
    }

    public function show()
    {
        return Post::select( 'id','title','content','thumb')
        ->orderbyDesc('id')
        ->limit(self::LIMIT)
        ->get();
    }
    public function show_detail($id)
    {
        return Post::where('id', $id)
            ->firstOrFail();
    }
}
