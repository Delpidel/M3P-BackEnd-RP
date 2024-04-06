<?php

namespace App\Http\Controllers;
use App\Http\Repositories\AvaliationRepository; // Repositório de Avaliações
use App\Http\Requests\StoreAvaliationRequest;
use App\Http\Requests\AvaliationFirstStep;
use App\Http\Services\File\CreateFileService; // Serviço para criar arquivos
use App\Models\Avaliation;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AvaliationController extends Controller
{
    protected $avaliationRepository;
    protected $createFileService;

    public function __construct(AvaliationRepository $avaliationRepository, CreateFileService $createFileService)
    {
        $this->avaliationRepository = $avaliationRepository;
        $this->createFileService = $createFileService;
    }

    public function index($student_id)
    {
        try {

            $students = Avaliation::all();
            return $students;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }

    public function step1(AvaliationFirstStep $request)
    {
          // Validação dos dados recebidos na requisição

         $validatedData = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'age' => ['required', 'integer', 'min:0'],
            'date' => ['required', 'date_format:Y-m-d H:i:s'],
            'weight' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],
            'observations_to_student' => ['nullable', 'string'],
            'observations_to_nutritionist' => ['nullable', 'string'],
        ], );

        // Crie uma instância de Avaliation e preenche com os dados validados
        $avaliation = new Avaliation();

        $avaliation->student_id = $validatedData['student_id'];
        $avaliation->age = $validatedData['age'];
        $avaliation->date = $validatedData['date'];
        $avaliation->weight = $validatedData['weight'];
        $avaliation->height = $validatedData['height'];
        $avaliation->observations_to_student = $validatedData['observations_to_student'];
        $avaliation->observations_to_nutritionist = $validatedData['observations_to_nutritionist'];
        $avaliation->measures = [];

        // Salve a avaliação no banco de dados
        $avaliation->save();

        return response()->json(['Mensagem' => 'Dados da etapa 1 salvos com sucesso'], Response::HTTP_OK);
    }


    public function step2(StoreAvaliationRequest $request)
    {
        // Validação e processamento dos dados da segunda etapa
    }
    public function step3(StoreAvaliationRequest $request)
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



