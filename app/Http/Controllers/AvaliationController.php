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
        try {
            $data = $request->validated();

            // Usando CreateFileService para manipular o upload do arquivo
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                // Substitua 'folderPath' pelo caminho desejado dentro do seu armazenamento
                $folderPath = 'avaliations';

                // Note: A função handle espera um nome, que você pode obter do arquivo ou gerar como preferir
                $name = time() . '_' . $file->getClientOriginalName();

                $createdFile = $this->createFileService->handle($folderPath, $file, $name);

                // Assumindo que o método handle retorna a instância do arquivo com um id
                $data['file_id'] = $createdFile->id;
            } else {
                throw new \Exception("Falha no upload do arquivo.");
            }

            // Criar avaliação com os dados validados e o ID do arquivo
            $createdAvaliation = $this->avaliationRepository->createAvaliation($data);

            return response()->json($createdAvaliation, Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}



