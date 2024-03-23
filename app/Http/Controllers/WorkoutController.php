<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Services\Workout\CreateWorkoutService;
use App\Models\Workout;
use App\Traits\HttpResponses;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    use HttpResponses;

    public function store(StoreWorkoutRequest $request, CreateWorkoutService $createWorkoutService)
    {
        try {
            //verifica se os dados enviados são exatamente os que a aplicação espera.
            //faz uma comparação entre o array enviado e o esperado e conta quantas difirenças são encontradas
            //caso houver diferenças, é retornada a mensagem de erro "informações inválidas".
            if (count(array_diff(array_keys($request->all()), ['student_id', 'exercise_id', 'repetitions', 'weight', 'break_time', 'day', 'observations', 'time'])) > 0) {
                return response()->json(['message' => 'Informações inválidas'], 400);
            }

            $data = $request->all();

            //verifica se o estudante em questão já possui o exercicio cadastrado à fim de evitar duplicatas.
            $exerciseExists = Workout::where('student_id', $data['student_id'])->where('day', $data['day'])->where('exercise_id', $data['exercise_id'])->exists();
            if ($exerciseExists) {
                return response()->json(['message' => 'Exercício já cadastrado para esse dia'], 409);
            }

            $workout = $createWorkoutService->handle($data);
            return response()->json($workout, 201);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}