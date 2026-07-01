<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getCommentsByBlog($blogId)
    {
        $blog = Blogs::find($blogId);

        if (!$blog) {
            return response()->json(['message' => 'Article non trouvé.'], 404);
        }

        $comments = Comment::where('blog_id', $blogId)->latest()->get();

        return response()->json(['status' => 'success', 'data' => $comments]);
    }

    public function store(Request $request, $blogId)
    {
        $request->validate([
            'nom'     => 'required|string|max:100',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|min:3',
        ]);

        $comment = Comment::create([
            'blog_id'       => $blogId,
            'visitor_name'  => $request->nom,
            'visitor_email' => $request->email,
            'message'       => $request->message,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Commentaire publié avec succès !',
            'data'    => $comment,
        ], 201);
    }

    public function index()
    {
        $comments = Comment::with('blog:id,title')->latest()->get();

        return response()->json(['status' => 'success', 'data' => $comments]);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Commentaire introuvable.'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Commentaire supprimé avec succès !']);
    }
}
