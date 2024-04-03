<?php

namespace App\Http\Services\File;

use App\Http\Repositories\FileRepository;
use Illuminate\Support\Facades\Storage;

class RemoveFileService
{
    private $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function handle($fileUrl, $fileId)
    {
        $filePath = parse_url($fileUrl);
        Storage::disk('s3')->delete($filePath);

        $this->fileRepository->delete($fileId);
    }
}
