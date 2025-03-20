<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateScreeningCreationRequest;
use App\Http\Requests\ValidateScreeningUpdateRequest;
use App\Interfaces\IRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Screenings', description: 'API Endpoints for Screenings')]
class ScreeningController extends Controller
{


    public function __construct(private readonly IRepository $screeningRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */

    #[OA\Get(
        path: '/screenings/list',
        operationId: 'all',
        description: 'Retrieve screenings from the database',
        summary: 'Retrieve screenings from the database',
        tags: ['Screenings'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful retrieval of screening data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2001-01-05 22:18:15'),
                        new OA\Property(property: 'available_seats', type: 'integer', example: 17),
                        new OA\Property(
                            property: 'movie',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 4),
                                new OA\Property(property: 'title', type: 'string', example: 'Ut minima aspernatur omnis.'),
                                new OA\Property(property: 'description', type: 'string', example: 'Quos quia aliquam quo inventore aliquam modi. Officia et ex id sit. Dolore dignissimos non iure consequuntur perspiciatis voluptas aperiam.'),
                                new OA\Property(property: 'age_limit', type: 'integer', example: 16),
                                new OA\Property(property: 'language', type: 'string', example: 'English'),
                                new OA\Property(property: 'cover_art', type: 'string', format: 'uri', example: 'https://via.placeholder.com/200x300.png/006600?text=movies+poster+nesciunt'),
                            ]
                        ),
                    ]
                    ,
                )
            ),
            new OA\Response(
                response: 204,
                description: 'No screenings found',

            ),
        ]
    )]
    public function index(): JsonResponse
    {
        try {
            return response()->json($this->screeningRepository->all());
        } catch (ModelNotFoundException $e) {
            return response()->json(Response::HTTP_NO_CONTENT);
        }
    }

    #[OA\Post(
        path: '/screenings/create',
        operationId: 'create',
        description: 'Create a new screening',
        summary: 'Create new screening from post data',
        tags: ['Screenings'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['date', 'available_seats', 'movie_id'],
                    properties: [
                        new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2023-05-15 19:30:00'),
                        new OA\Property(property: 'available_seats', type: 'integer', example: 30, maximum: 50),
                        new OA\Property(property: 'movie_id', type: 'integer', example: 4),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful creation of screening data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2001-01-05 22:18:15'),
                        new OA\Property(property: 'available_seats', type: 'integer', example: 17),
                        new OA\Property(
                            property: 'movie',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 4),
                                new OA\Property(property: 'title', type: 'string', example: 'Ut minima aspernatur omnis.'),
                                new OA\Property(property: 'description', type: 'string', example: 'Quos quia aliquam quo inventore aliquam modi. Officia et ex id sit. Dolore dignissimos non iure consequuntur perspiciatis voluptas aperiam.'),
                                new OA\Property(property: 'age_limit', type: 'integer', example: 16),
                                new OA\Property(property: 'language', type: 'string', example: 'English'),
                                new OA\Property(property: 'cover_art', type: 'string', format: 'uri', example: 'https://via.placeholder.com/200x300.png/006600?text=movies+poster+nesciunt'),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Error during screening creation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Error during screening creation'),
                    ]
                )
            ),
        ]
    )]
    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidateScreeningCreationRequest $request)
    {
        try {
            return response()->json($this->screeningRepository->create($request->validated()));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during screening creation'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[OA\Get(
        path: '/screenings/get/{id}',
        operationId: 'single-screening',
        description: 'Retrieve a singular screening from the database',
        summary: 'Retrieve a singular screening from the database',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID of the screening to retrieve',
                required: true,
                allowEmptyValue: false,
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1
                )
            )
        ]
        ,
        tags: ['Screenings'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful retrieval of screening data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2001-01-05 22:18:15'),
                        new OA\Property(property: 'available_seats', type: 'integer', example: 17),
                        new OA\Property(
                            property: 'movie',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 4),
                                new OA\Property(property: 'title', type: 'string', example: 'Ut minima aspernatur omnis.'),
                                new OA\Property(property: 'description', type: 'string', example: 'Quos quia aliquam quo inventore aliquam modi. Officia et ex id sit. Dolore dignissimos non iure consequuntur perspiciatis voluptas aperiam.'),
                                new OA\Property(property: 'age_limit', type: 'integer', example: 16),
                                new OA\Property(property: 'language', type: 'string', example: 'English'),
                                new OA\Property(property: 'cover_art', type: 'string', format: 'uri', example: 'https://via.placeholder.com/200x300.png/006600?text=movies+poster+nesciunt'),
                            ]
                        ),
                    ]
                    ,
                )
            ),
            new OA\Response(
                response: 204,
                description: 'No screenings found',
            ),
        ]
    )]
    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            return response()->json($this->screeningRepository->find($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(Response::HTTP_NO_CONTENT);
        }
    }

    #[OA\Post(
        path: '/screenings/update/{id}',
        operationId: 'update',
        description: 'Update an existing screening',
        summary: 'Update an existing screening from post data',
        tags: ['Screenings'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2023-05-15 19:30:00'),
                        new OA\Property(property: 'available_seats', type: 'integer', example: 30, maximum: 50),
                        new OA\Property(property: 'movie_id', type: 'integer', example: 4),
                    ]
                )
            )
        ),
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID of the screening to update',
                required: true,
                allowEmptyValue: false,
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful updating of screening data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'date', type: 'string', format: 'date-time', example: '2001-01-05 22:18:15'),
                        new OA\Property(property: 'available_seats', type: 'integer', example: 17),
                        new OA\Property(
                            property: 'movie',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 4),
                                new OA\Property(property: 'title', type: 'string', example: 'Ut minima aspernatur omnis.'),
                                new OA\Property(property: 'description', type: 'string', example: 'Quos quia aliquam quo inventore aliquam modi. Officia et ex id sit. Dolore dignissimos non iure consequuntur perspiciatis voluptas aperiam.'),
                                new OA\Property(property: 'age_limit', type: 'integer', example: 16),
                                new OA\Property(property: 'language', type: 'string', example: 'English'),
                                new OA\Property(property: 'cover_art', type: 'string', format: 'uri', example: 'https://via.placeholder.com/200x300.png/006600?text=movies+poster+nesciunt'),
                            ]
                        ),
                    ]
                    ,
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Error during updating screening data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Error during screening update'),
                    ]
                )
            ),
        ]
    )]
    /**
     * Update the specified resource in storage.
     */

    public function update(ValidateScreeningUpdateRequest $request, string $id)
    {
        try {
            return response()->json($this->screeningRepository->update($id, $request->validated()));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during screening update'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[OA\Delete(
        path: '/screenings/delete/{id}',
        operationId: 'delete',
        description: 'Update an existing screening',
        summary: 'Update an existing screening from post data',
        tags: ['Screenings'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID of the screening to retrieve',
                required: true,
                allowEmptyValue: false,
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Screening deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Screening deleted successfully'),
                    ],
                )
            ),
            new OA\Response(
                response: 204,
                description: 'Screening deleted successfully',
            ),
            new OA\Response(
                response: 500,
                description: 'Error during screening deletion',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Error during screening deletion'),
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
            $isDeleteSuccessful = $this->screeningRepository->delete($id);
            if ($isDeleteSuccessful) {
                return response()->json(['message' => 'Screening deleted successfully']);
            }
            return response()->json( Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during screening deletion'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
