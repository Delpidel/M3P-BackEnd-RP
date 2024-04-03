<?php

namespace App\Http\Services\File;

use Illuminate\Support\Facades\Storage;

class RemoveFileService
{
    public function handle($fileUrl)
    {
        $filePath = parse_url($fileUrl);
        Storage::disk('s3')->delete($filePath);
    }
}
