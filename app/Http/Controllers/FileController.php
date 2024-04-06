<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\File\CreateFileService;
use App\Http\Services\File\RemoveFileService;
use App\Models\File;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    protected $createFileService;
    protected $removeFileService;

    public function __construct(CreateFileService $createFileService, RemoveFileService $removeFileService)
    {
        $this->createFileService = $createFileService;
        $this->removeFileService = $removeFileService;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $file = $request->file('photo');
            $body = $request->input();
            $file = $this->createFileService->handle('photos', $file, 'imagem');

            DB::commit();

            return $file;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao criar o arquivo'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $file = File::find($id);

            if (!$file) {
                return response()->json(['message' => 'Arquivo não encontrado'], 404);
            }

            $fileUrl = $file->url;
            $id = $file->id;

            $this->removeFileService->handle($fileUrl, $id);
            $file->delete();

            DB::commit();

            return response()->json(['message' => 'Arquivo excluído com sucesso'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao excluir o arquivo'], 500);
        }
    }
}
