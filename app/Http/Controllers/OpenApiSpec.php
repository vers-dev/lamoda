<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Api documentation',
)]

#[OA\Schema(
    schema: 'AppException',
    properties: [
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Error'
        ),
        new OA\Property(
            property: 'status',
            type: 'boolean',
            example: false
        ),
    ],
)]
class OpenApiSpec
{
}
