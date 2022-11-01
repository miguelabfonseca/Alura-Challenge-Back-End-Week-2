<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiVideoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        if ($request->search) {
            return $this->search('%' . $request->search . '%');
        }
        return response()->json(Video::get()->toArray(), 200);
    }

    public function show($id): JsonResponse
    {
        $video = Video::find($id);
        if (!$video) {
            return response()->json(['status' => 'error', 'message' => 'Video not found!'], 404);
        }
        return response()->json($video->toArray(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            [
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'url' => $request->url,
            ],
            [
                'titulo' => 'required|min:1',
                'descricao' => 'required|min:1',
                'url' => 'required|url',
            ]
        );

        if ($validator->fails()) {
            $errorMessage = '';
            foreach ($validator->errors()->all() as $message) {
                $errorMessage .= $message . '; ';
            }
            return response()->json(['status' => 'error', 'message' => $errorMessage], 206);
        }

        $video = Video::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'url' => $request->url,
        ]);
        return response()->json($video->toArray(), 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $video = Video::find($id);
        if (!$video) {
            return response()->json(['status' => 'error', 'message' => 'Video not found!'], 404);
        }
        $validator = Validator::make(
            [
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'url' => $request->url,
            ],
            [
                'titulo' => 'required|min:1',
                'descricao' => 'required|min:1',
                'url' => 'required|url',
            ]
        );

        if ($validator->fails()) {
            $errorMessage = '';
            foreach ($validator->errors()->all() as $message) {
                $errorMessage .= $message . '; ';
            }
            return response()->json(['status' => 'error', 'message' => $errorMessage], 206);
        }
        $video->fill($request->all());
        $video->save();

        return response()->json($video->toArray(), 200);
    }

    public function destroy($id): JsonResponse
    {
        $video = Video::find($id);
        if (!$video) {
            return response()->json(['status' => 'error', 'message' => 'Video not found!'], 404);
        }
        $video->delete();
        return response()->json(['status' => 'ok', 'message' => 'Video deleted with success!'], 200);
    }

    private function search($search)
    {
        $video = Video::where('titulo', 'like', $search)
                ->orWhere('descricao', 'like', $search)
                ->get();

        if ($video->count() == 0) {
            return response()->json(['status' => 'error', 'message' => 'No video was found with the search string!'], 404);
        }
        return response()->json($video->toArray(), 200);
    }

}
