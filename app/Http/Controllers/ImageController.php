<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function destroy(Image $image)
    {
        $image->delete();

        if (! Storage::delete($image->url)) {
            return redirect()->back()->withErrors(['image' => 'Error deleting image']);
        }

        return redirect()->back()->with('success', 'Image deleted successfully');
    }
}
