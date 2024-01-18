<?php

namespace App\Http\Services\Comment;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CommentService
{
    public function getPostComments($postId)
    {
        // Retrieve comments for a specific post
        return Comment::where('post_id', $postId)->with('replies')->get();
    }

    public function addComment(Request $request,$parentId = null)
    {
        try {
            // dd($request->input());
            if (!$request->input("user_id")) {
                throw new Exception('Cần đăng nhập để bình luận'); // You can customize the exception message.
            }
            // Your existing code to create and save the comment goes here...
            $comment = new Comment([
                'post_id' => $request->input("post_id"),
                'content' => $request->input("content"),
                'user_id' => $request->input("user_id"),
                'parent_id' => $parentId,
            ]);
    
            $comment->save();
    
            return redirect()->back();
        } catch (Exception $e) {
            Alert::warning('Warning Title', $e->getMessage());
            // Handle the exception (log, redirect, or other actions)
            return redirect()->back(); // or redirect()->back(); or any other response
        }
    }
    
}