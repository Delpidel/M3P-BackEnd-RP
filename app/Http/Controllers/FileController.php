<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\File\CreateFileService;

class FileController extends Controller
{

    public function store(
        Request $request,
        CreateFileService $createFileService,
    ) {

        $file = $request->file('photo');
        $body = $request->all();
        $file = $createFileService->handle('photos', $file, $body['name']);
        return $file;
    }
}
