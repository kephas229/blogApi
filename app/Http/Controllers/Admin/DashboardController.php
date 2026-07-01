<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs; 
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function getStats(): JsonResponse
    {
        $totalBlogs    = Blogs::count();
        $totalComments = Comment::count();

        $latestBlogs = Blogs::select('id', 'title', 'author', 'created_at')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($blog) => [
                'id'     => $blog->id,
                'title'  => $blog->title,
                'author' => $blog->author,
                'date'   => $blog->created_at->format('d/m/Y'),
            ]);

        return response()->json([
            'totalBlogs'    => $totalBlogs,
            'totalComments' => $totalComments,
            'LatestBlogs'   => $latestBlogs,
        ]);
    }
}
