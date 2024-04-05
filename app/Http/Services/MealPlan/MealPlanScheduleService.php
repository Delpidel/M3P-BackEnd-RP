<?php

namespace App\Http\Services\MealPlan;

use App\Interfaces\MealPlanScheduleRepositoryInterface;
use App\Interfaces\MealPlanScheduleServiceInterface;
use App\Models\MealPlanSchedule;
use App\Models\Student;
use App\Traits\HttpResponses;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MealPlanScheduleService implements MealPlanScheduleServiceInterface
{
    use HttpResponses;

    private $mealPlanScheduleRepository;

    public function __construct(MealPlanScheduleRepositoryInterface $mealPlanScheduleRepository)
    {
        $this->mealPlanScheduleRepository = $mealPlanScheduleRepository;
    }

    public function getAll()
    {
        return $this->mealPlanScheduleRepository->getAll();
    }

    public function findById($id)
    {
        $meal = MealPlanSchedule::with('student')->where('student_id', $id)->get();

        if($meal->isEmpty()) throw new ErrorException('id não encontrado', 404);

        return $meal;
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'meal_plan_id' => 'int|required',
            'student_id' => 'int|required',
            'hour' => 'string',
            'title' => 'string|required',
            'description' => 'string|required',
            'day' => 'required|in:SEGUNDA,TERCA,QUARTA,QUINTA,SEXTA,SABADO,DOMINGO',
        ]);

        return $this->mealPlanScheduleRepository->create($data);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        return $this->mealPlanScheduleRepository->update($id, $data);
    }

    public function delete($id)
    {
        $meal = $this->mealPlanScheduleRepository->findById($id);

        if(!$meal) throw new ErrorException('id não encontrado', 404);

        $this->mealPlanScheduleRepository->delete($id);

        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
