<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Fotexnet Teszt API",
    description: "API Documentation for the test."
)]
#[OA\Server(
    url: "https://localhost/api",
    description: "Local development server"
)]
class SwaggerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

}
