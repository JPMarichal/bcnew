<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function upload(Request $request, $postId)
    {
        // Validación del postId que viene en la URL
        $validator = Validator::make(['postId' => $postId], [
            'postId' => 'required|integer|exists:posts,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        try {
            $cdnUrl = $this->imageUploadService->uploadImageToCDN($postId);
            return response()->json(['success' => true, 'url' => $cdnUrl], 200);
        } catch (\Exception $e) {
            Log::error('Error durante la subida al CDN: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
