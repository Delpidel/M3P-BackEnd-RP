<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvaliationRequest;
use App\Http\Repositories\AvaliationRepository;
use App\Http\Services\File\CreateFileService;
use Illuminate\Http\Request;
use App\Models\Avaliation;
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
        try {
            $data = $request->input();

            $createdAvaliation = $this->avaliationRepository->createAvaliation([...$data
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


