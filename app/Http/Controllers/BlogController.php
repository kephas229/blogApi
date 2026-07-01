<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blogs::orderBy('created_at', 'desc');

        if (!empty($request->keyword)) {
            $blogs->where('title', 'like', '%' . $request->keyword . '%');
        }

        return response()->json(['status' => 'true', 'data' => $blogs->get()]);
    }

    public function show($id)
    {
        $blog = Blogs::find($id);

        if (!$blog) {
            return response()->json(['status' => 'false', 'message' => 'Article introuvable.'], 404);
        }

        $blog['date'] = \Carbon\Carbon::parse($blog->created_at)->format('d-m-Y');

        return response()->json(['status' => 'true', 'data' => $blog]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title'  => 'required|string|max:255',
            'author' => 'required|min:3',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'false',
                'errors' => $validated->errors(),
            ], 422);
        }

        $blog = new Blogs();
        $blog->title       = $request->title;
        $blog->shortDesc   = $request->shortDesc;
        $blog->Description = $request->Description;
        $blog->author      = $request->author;
        $blog->user_id     = $request->user()->id;
        $blog->save();

        $this->handleImageUpload($request, $blog);

        return response()->json(['status' => 'true', 'message' => 'Article créé avec succès !', 'data' => $blog], 201);
    }

    public function update($id, Request $request)
    {
        $blog = Blogs::find($id);

        if (!$blog) {
            return response()->json(['status' => 'false', 'message' => 'Article introuvable.'], 404);
        }

        $validated = Validator::make($request->all(), [
            'title'  => 'required|string|max:255',
            'author' => 'required|min:3',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'false',
                'errors' => $validated->errors(),
            ], 422);
        }

        $blog->title       = $request->title;
        $blog->shortDesc   = $request->shortDesc;
        $blog->Description = $request->Description;
        $blog->author      = $request->author;
        $blog->save();

        if ($request->image_id) {
            $oldPath = public_path('uploads/blogs/' . $blog->image);
            if ($blog->image && !str_starts_with($blog->image, 'http') && File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $this->handleImageUpload($request, $blog);
        }

        return response()->json(['status' => 'true', 'message' => 'Article mis à jour avec succès !', 'data' => $blog]);
    }

    public function delete($id)
    {
        $blog = Blogs::find($id);

        if (!$blog) {
            return response()->json(['status' => 'false', 'message' => 'Article introuvable.'], 404);
        }

        if ($blog->image && !str_starts_with($blog->image, 'http')) {
            File::delete(public_path('uploads/blogs/' . $blog->image));
        }

        $blog->delete();

        return response()->json(['status' => 'true', 'message' => 'Article supprimé avec succès !']);
    }

    private function handleImageUpload(Request $request, Blogs $blog): void
    {
        $tempImage = TempImage::find($request->image_id);

        if (!$tempImage) return;

        $extension   = last(explode('.', $tempImage->name));
        $imageName   = time() . '-' . $blog->id . '.' . $extension;
        $sourcePath  = public_path('uploads/temp/' . $tempImage->name);
        $destPath    = public_path('uploads/blogs/' . $imageName);

        File::copy($sourcePath, $destPath);

        $blog->image = $imageName;
        $blog->save();
    }
}
