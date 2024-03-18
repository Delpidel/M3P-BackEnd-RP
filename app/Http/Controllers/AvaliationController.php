<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvaliationController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Validação dos dados da requisição
            $validatedData = $request->validate([
                'student_id' => 'required|integer',
                'date' => 'required|date_format:d/m/Y H:i',
                'weight' => 'required|numeric',
                'height' => 'required|numeric',
                'age' => 'required|integer',
                'observations_to_student' => 'nullable|string',
                'observations_to_nutritionist' => 'nullable|string',
                'image.front' => 'required|url',
                'image.back' => 'required|url',
                'image.right' => 'required|url',
                'image.left' => 'required|url',
                'measures.torax' => 'required|numeric',
                'measures.braco_direito' => 'required|numeric',
                'measures.braco_esquerdo' => 'required|numeric',
                'measures.cintura' => 'required|numeric',
                'measures.antebraco' => 'required|numeric',
                'measures.abdome' => 'required|numeric',
                'measures.coxa_direita' => 'required|numeric',
                'measures.coxa_esquerda' => 'required|numeric',
                'measures.quadril' => 'required|numeric',
                'measures.panturrilha_direita' => 'required|numeric',
                'measures.panturilha_esquerda' => 'required|numeric',
                'measures.punho' => 'required|numeric',
                'measures.b_femoral' => 'required|numeric',
            ]);

            // Retornar os dados validados como JSON
            return response()->json($validatedData, 200);
        } catch (\Exception $e) {
            // Se ocorrer uma exceção, retornar uma resposta de erro
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
