<?php

namespace App\Http\Controllers;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TempImageController extends Controller
{
    //
    public function store(Request $request)
    {
      $validator=Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        // upload image here
        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $extension;

        // Store the image in database
        $tempImage = new TempImage();
        $tempImage->name = $imageName;
        $tempImage->save();

        // Move the image to the public/images directory
        $image->move(public_path('uploads/temp'), $imageName);

        return response()->json([
            'status' => 'true',
            'message' => 'Image chargé avec succès',
            'image' => $tempImage
        ]);
    }
}
