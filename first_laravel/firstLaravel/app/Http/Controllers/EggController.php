<?php

namespace App\Http\Controllers;

use App\Models\Egg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EggController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'texture' => 'required|string',
            'preview' => 'required|string'
        ]);

        $texturePath = $this->saveBase64Image($request->texture, 'eggs/textures');
        $previewPath = $this->saveBase64Image($request->preview, 'eggs/previews');

        $egg = Auth::user()->eggs()->create([
            'texture_path' => $texturePath,
            'preview_path' => $previewPath,
        ]);

        return response()->json(['success' => true, 'egg' => $egg]);
    }

    public function destroy(Egg $egg)
    {
        if ($egg->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete([$egg->texture_path, $egg->preview_path]);
        $egg->delete();

        return response()->json(['success' => true]);
    }

    private function saveBase64Image($base64String, $folder)
    {
        $image_parts = explode(";base64,", $base64String);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        
        $filename = $folder . '/' . Str::random(40) . '.' . $image_type;
        Storage::disk('public')->put($filename, $image_base64);
        
        return $filename;
    }
}
