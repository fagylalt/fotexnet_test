<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateMovieCreationRequest;
use App\Http\Requests\ValidateMovieUpdateRequest;
use App\Repositories\MovieRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MovieController extends Controller
{



    public function __construct(private readonly MovieRepository $movieRepository)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json($this->movieRepository->all());
        }catch (\Exception $e){
            return response()->json(['message' => 'Error during fetching movies'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    // In your MovieController
    public function store(ValidateMovieCreationRequest $request)
    {
        try {
            return response()->json($this->movieRepository->create($request->validated()));
        }catch (\Exception $e){
            return response()->json(['message' => 'Error during movie creation'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     */
    public function find(string $id): JsonResponse
    {
        try {
            return response()->json($this->movieRepository->find($id));
        }catch (ModelNotFoundException $e){
            return response()->json(['message' => 'Movie not found'], Response::HTTP_NOT_FOUND);
        }
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(ValidateMovieUpdateRequest $request, string $id): JsonResponse
    {
        try {
            return response()->json($this->movieRepository->update($id, $request->validated()));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during movie update'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $isDeleteSuccessful = $this->movieRepository->delete($id);
            if ($isDeleteSuccessful) {
                return response()->json(['message' => 'Movie deleted successfully']);
            }
            return response()->json(['message' => 'Movie not found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during movie deletion'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
