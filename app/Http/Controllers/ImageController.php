<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\StoreRequest;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    private $image_service;

    public function __construct()
    {
        $this->image_service = new ImageService;
    }
    public function index()
    {
        $images = Image::all();

        $grouped_images = $this->image_service->groupByIndex($images);

        return response()->json($grouped_images);
    }

    public function store(StoreRequest $request)
    {
        $image_file = $request->file('image_file');
        $index = $request->get('index');

        $image = new Image;
        $image->image_url = $this->image_service->uploadImage($image_file);
        $image->index = $index;
        $image->save();

        return response()->json($image);
    }

    public function delete($id)
    {
        $image = Image::find($id);
        $image->delete();

        return response()->json([
            'message' => 'Image deleted'
        ]);
    }

    public function deleteAll()
    {
        DB::table('images')->delete();

        return response()->json([
            'message' => 'Images record are cleared'
        ]);
    }

    public function generateCombinations()
    {
        $images = Image::get();

        $image_service = new ImageService;
        $image_combinations = $image_service->getCombinations($images);

        return response()->json($image_combinations);
    }

}
