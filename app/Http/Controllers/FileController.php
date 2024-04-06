<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\File\CreateFileService;
use App\Http\Services\File\RemoveFileService;
use App\Models\File;

class FileController extends Controller
{
    protected $createFileService;
    protected $removeFileService;

    public function __construct(CreateFileService $createFileService, RemoveFileService $removeFileService)
    {
        $this->createFileService = $createFileService;
        $this->removeFileService = $removeFileService;
    }

    public function store(
        Request $request,
        CreateFileService $createFileService,
    ) {

        $file = $request->file('photo');
        $body = $request->input();
        $file = $createFileService->handle('photos', $file, 'imagem');
        return $file;
    }

    public function destroy($id)
    {
        $file = File::find($id);

        if (!$file) {
            return response()->json(['message' => 'Arquivo não encontrado'], 404);
        }

        $fileUrl = $file->url;
        $id = $file->id;

        try {
            $this->removeFileService->handle($fileUrl, $id);
            $file->delete();
            return response()->json(['message' => 'Arquivo excluído com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao excluir o arquivo'], 500);
        }
    }
}
