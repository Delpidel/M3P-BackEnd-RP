<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvaliationRequest;
use App\Http\Repositories\AvaliationRepository; // Repositório de Avaliações
use App\Http\Services\File\CreateFileService; // Serviço para criar arquivos
use App\Http\Controllers\Request;
use App\Http\Controllers\Avaliation;
use Illuminate\Http\Response;


class AvaliationController extends Controller
{
    protected $avaliationRepository;
    protected $createFileService;

    public function __construct(AvaliationRepository $avaliationRepository, CreateFileService $createFileService)
    {
        $this->avaliationRepository = $avaliationRepository;
        $this->createFileService = $createFileService;
    }

    public function store(StoreAvaliationRequest $request)
    {

        // Validação e processamento dos dados da terceira etapa

        try {
            $data = $request->input();
            $back = $request->file('back');
            $front = $request->file('front');
            $left = $request->file('left');
            $right = $request->file('right');

            $folderPath = 'avaliations';

            $createdFileBack = $this->createFileService->handle($folderPath, $back, 'foto_costas');
            $createdFileFront = $this->createFileService->handle($folderPath, $front, 'foto_frente');
            $createdFileLeft = $this->createFileService->handle($folderPath, $left, 'foto_esquerda');
            $createdFileRight = $this->createFileService->handle($folderPath, $right, 'foto_direita');

            return;

            $createdAvaliation = $this->avaliationRepository->createAvaliation([...$data, 'back'=>$createdFileBack->id, 'front'=>$createdFileFront->id,
            'left'=>$createdFileLeft->id, 'right'=>$createdFileRight->id
        ]);

            return response()->json($createdAvaliation, Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAvaliationsByStudentId(Request $request, $student_id)
    {
        try {
            $avaliation = Avaliation::where('student_id', $student_id)->with("imagemFront", "imagemBack", "imagemLeft", "imagemRight")->get();

            if ($avaliation->isEmpty()) {
                return response()->json(['message' => 'Nenhuma avaliação encontrada para este estudante'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($avaliation, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}


