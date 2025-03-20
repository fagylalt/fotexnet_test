<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateMovieCreationRequest;
use App\Http\Requests\ValidateMovieUpdateRequest;
use App\Repositories\MovieRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Movies', description: 'API Endpoints for movies')]
class MovieController extends Controller
{
    public function __construct(private readonly MovieRepository $movieRepository) {}

    #[OA\Get(
        path: '/movies/list',
        operationId: 'allMovies',
        description: 'Retrieve movies from the database',
        summary: 'Retrieve a list of movies',
        tags: ['Movies'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful retrieval of movie data',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', example: 1),
                            new OA\Property(property: 'title', type: 'string', example: 'Ipsam veritatis deleniti omnis.'),
                            new OA\Property(property: 'description', type: 'string', example: 'Quidem maiores distinctio deleniti eaque pariatur sit nisi. Similique et dolorem tenetur velit facilis vitae. Commodi vel rerum voluptates suscipit.'),
                            new OA\Property(property: 'age_limit', type: 'integer', example: 17),
                            new OA\Property(property: 'language', type: 'string', example: 'Spanish'),
                            new OA\Property(property: 'cover_art', type: 'string', format: 'uri', example: 'https://via.placeholder.com/200x300.png/00aacc?text=movies+poster+blanditiis'),
                        ]
                    ),
                    example: [
                        [
                            'id' => 1,
                            'title' => 'Ipsam veritatis deleniti omnis.',
                            'description' => 'Quidem maiores distinctio deleniti eaque pariatur sit nisi. Similique et dolorem tenetur velit facilis vitae. Commodi vel rerum voluptates suscipit.',
                            'age_limit' => 17,
                            'language' => 'Spanish',
                            'cover_art' => 'https://via.placeholder.com/200x300.png/00aacc?text=movies+poster+blanditiis',
                        ],
                        [
                            'id' => 2,
                            'title' => 'Quibusdam error quo.',
                            'description' => 'Sit sit dolor distinctio impedit quia architecto. Veritatis quisquam modi eum. Suscipit et ab sint vero sit quibusdam itaque velit. Et rerum molestiae ullam aliquid.',
                            'age_limit' => 18,
                            'language' => 'Korean',
                            'cover_art' => 'https://via.placeholder.com/200x300.png/003355?text=movies+poster+qui',
                        ],
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Error during fetching movies',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'An error occurred while retrieving movies.'),
                        new OA\Property(property: 'error', type: 'string', example: 'Internal Server Error'),
                    ]
                )
            ),
        ]
    )]
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json($this->movieRepository->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during fetching movies'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/movies/create',
        operationId: 'createMovie',
        description: 'Create a new movie',
        summary: 'Create a new movie from post data',
        tags: ['Movies'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['title', 'description', 'age_limit', 'language', 'cover_art'],
                    properties: [
                        new OA\Property(property: 'title', type: 'string', maxLength: 255, example: 'Ipsam veritatis deleniti omnis.'),
                        new OA\Property(property: 'description', type: 'string', maxLength: 255, example: 'Quidem maiores distinctio deleniti eaque pariatur sit nisi. Similique et dolorem tenetur velit facilis vitae. Commodi vel rerum voluptates suscipit.'),
                        new OA\Property(property: 'age_limit', type: 'integer', example: 17),
                        new OA\Property(property: 'language', type: 'string', maxLength: 25, example: 'Spanish'),
                        new OA\Property(property: 'cover_art', type: 'string', maxLength: 255, format: 'uri', example: 'https://via.placeholder.com/200x300.png/00aacc?text=movies+poster+blanditiis'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful creation of movie data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Ipsam veritatis deleniti omnis.'),
                        new OA\Property(property: 'description', type: 'string', example: 'Quidem maiores distinctio deleniti eaque pariatur sit nisi. Similique et dolorem tenetur velit facilis vitae. Commodi vel rerum voluptates suscipit.'),
                        new OA\Property(property: 'age_limit', type: 'integer', example: 17),
                        new OA\Property(property: 'language', type: 'string', example: 'Spanish'),
                        new OA\Property(property: 'cover_art', type: 'string', format: 'uri', example: 'https://via.placeholder.com/200x300.png/00aacc?text=movies+poster+blanditiis'),
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Error during movie creation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Error during movie creation'),
                    ]
                )
            ),
        ]
    )]
    public function store(ValidateMovieCreationRequest $request)
    {
        try {
            return response()->json($this->movieRepository->create($request->validated()));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during movie creation'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    #[OA\Get(
        path: '/movies/get/{id}',
        operationId: 'single-movie',
        description: 'Retrieve a single movie from the database',
        summary: 'Retrieve a single movie by its ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID of the movie to retrieve',
                required: true,
                allowEmptyValue: false,
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1
                )
            ),
        ],
        tags: ['Movies'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful retrieval of movie data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Ipsam veritatis deleniti omnis.'),
                        new OA\Property(property: 'description', type: 'string', example: 'Quidem maiores distinctio deleniti eaque pariatur sit nisi. Similique et dolorem tenetur velit facilis vitae. Commodi vel rerum voluptates suscipit.'),
                        new OA\Property(property: 'age_limit', type: 'integer', example: 17),
                        new OA\Property(property: 'language', type: 'string', example: 'Spanish'),
                        new OA\Property(property: 'cover_art', type: 'string', format: 'uri', example: 'https://via.placeholder.com/200x300.png/00aacc?text=movies+poster+blanditiis'),
                    ]
                )
            ),
            new OA\Response(
                response: 204,
                description: 'No movie found',
            ),
        ]
    )]
    /**
     * Display the specified resource.
     */
    public function find(string $id): JsonResponse
    {
        try {
            return response()->json($this->movieRepository->find($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Movie not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[OA\Post(
        path: '/movies/update/{id}',
        operationId: 'updateMovie',
        description: 'Update an existing movie',
        summary: 'Update an existing movie from post data',
        tags: ['Movies'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'title', type: 'string', maxLength: 255, example: 'Updated Movie Title'),
                        new OA\Property(property: 'description', type: 'string', maxLength: 255, example: 'Updated description of the movie.'),
                        new OA\Property(property: 'age_limit', type: 'integer', example: 18),
                        new OA\Property(property: 'language', type: 'string', maxLength: 25, example: 'French'),
                        new OA\Property(property: 'cover_art', type: 'string', format: 'uri', example: 'https://via.placeholder.com/200x300.png/00aacc?text=updated+poster'),
                    ]
                )
            )
        ),
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID of the movie to update',
                required: true,
                allowEmptyValue: false,
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful updating of movie data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Updated Movie Title'),
                        new OA\Property(property: 'description', type: 'string', example: 'Updated description of the movie.'),
                        new OA\Property(property: 'age_limit', type: 'integer', example: 18),
                        new OA\Property(property: 'language', type: 'string', example: 'French'),
                        new OA\Property(property: 'cover_art', type: 'string', format: 'uri', example: 'https://via.placeholder.com/200x300.png/00aacc?text=updated+poster'),
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Error during updating movie data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Error during movie update'),
                    ]
                )
            ),
        ]
    )]
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

    #[OA\Delete(
        path: '/movies/delete/{id}',
        operationId: 'deleteMovie',
        description: 'Delete an existing movie',
        summary: 'Delete a movie from the database',
        tags: ['Movies'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID of the movie to delete',
                required: true,
                allowEmptyValue: false,
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Movie deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Movie deleted successfully'),
                    ]
                )
            ),
            new OA\Response(
                response: 204,
                description: 'Movie deleted successfully',
            ),
            new OA\Response(
                response: 500,
                description: 'Error during movie deletion',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Error during movie deletion'),
                    ]
                )
            ),
        ]
    )]
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
