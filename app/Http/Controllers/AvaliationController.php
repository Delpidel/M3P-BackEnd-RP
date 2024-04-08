<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvaliationRequest;
use App\Http\Repositories\AvaliationRepository; // Repositório de Avaliações
use App\Http\Services\File\CreateFileService; // Serviço para criar arquivos
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

            $createdAvaliation = $this->avaliationRepository->createAvaliation([...$data
        ]);

            return response()->json($createdAvaliation, Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}


