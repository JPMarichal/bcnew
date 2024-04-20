<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImageUploadService;

class UploadPostImageToCDN extends Command
{
    protected $signature = 'cdn:upload-image {postId : The ID of the post}';
    protected $description = 'Uploads post image to BunnyCDN and updates database with the new image URL';

    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        parent::__construct();
        $this->imageUploadService = $imageUploadService;
    }

    public function handle()
    {
        $postId = $this->argument('postId');

        try {
            $cdnUrl = $this->imageUploadService->uploadImageToCDN($postId);
            $this->info("Image uploaded and database updated successfully!");
            $this->info($cdnUrl);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
