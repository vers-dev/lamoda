<?php

namespace App\Http\Controllers\Product;

use App\Contracts\Product\ProductServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\GetProductRequest;
use App\Http\Resources\Product\ProductInfoResource;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{

    public function __construct(
        private readonly ProductServiceContract $productService
    )
    {
    }

    #[OA\Get(
        path: '/api/get-products',
        tags: ['Продукты'],
        parameters: [
            new OA\Parameter(
                name: 'storage_id',
                description: 'Id Склада',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1,
                    nullable: false,
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Ok',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/ProductInfoResource'
                    ),
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Ошибка выполнения запроса',
                content: new OA\JsonContent(
                    ref: "#/components/schemas/AppException",
                )
            ),
        ]
    )]
    public function getProductsByStorageId(GetProductRequest $request)
    {
        $response = $this->productService->getProductsByStorageId($request->integer('storage_id'));

        return $this->successResponse(ProductInfoResource::collection($response));
    }
}
