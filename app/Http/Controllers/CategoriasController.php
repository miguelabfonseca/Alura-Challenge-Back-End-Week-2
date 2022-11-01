<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoriasController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Categoria::get()->toArray() , 200);
    }

    public function show($id): JsonResponse
    {
        $categoria = Categoria::find($id);
        if(!$categoria) {
            return response()->json(['status' => 'error', 'message' => 'Category not found!'], 404);
        }
        return response()->json($categoria->toArray(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            [
                'titulo'  =>  $request->titulo,
                'cor' => $request->cor,
            ],
            [
                'titulo'  => 'required|min:1',
                'cor' => 'required|min:1',
            ]
        );

        if ($validator->fails()) {
            $errorMessage = '';
            foreach($validator->errors()->all() as $message) {
                $errorMessage .= $message . '; ';
            }
            return response()->json(['status' => 'error', 'message' => $errorMessage], 206);
        }

        $categoria = Categoria::create([
            'titulo' => $request->titulo,
            'cor' => $request->cor
        ]);
        return response()->json($categoria->toArray(), 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $categoria = Categoria::find($id);
        if(!$categoria) {
            return response()->json(['status' => 'error', 'message' => 'Category not found!'], 404);
        }
        $validator = Validator::make(
            [
                'titulo'  =>  $request->titulo,
                'cor' => $request->cor
            ],
            [
                'titulo'  => 'required|min:1',
                'cor' => 'required|min:1',
            ]
        );

        if ($validator->fails()) {
            $errorMessage = '';
            foreach($validator->errors()->all() as $message) {
                $errorMessage .= $message . '; ';
            }
            return response()->json(['status' => 'error', 'message' => $errorMessage], 206);
        }
        $categoria->fill($request->all());
        $categoria->save();

        return response()->json($categoria->toArray(), 200);
    }

    public function destroy($id): JsonResponse
    {
        $categoria = Categoria::find($id);
        if(!$categoria) {
            return response()->json(['status' => 'error', 'message' => 'Category not found!'], 404);
        }
        $categoria->delete();
        return response()->json(['status' => 'ok', 'message' => 'Category deleted with success!'], 200);
    }

    public function videos($id)
    {
        $videos = Video::where('categoriaId', $id)->with('categoria')->get();
        if($videos->count() == 0)
        {
            return response()->json(['status' => 'error', 'message' => 'No videos found on the selected category!'], 404);
        }
        return response()->json($videos->toArray(), 200);
    }



}
