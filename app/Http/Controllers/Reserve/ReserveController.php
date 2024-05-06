<?php

namespace App\Http\Controllers\Reserve;

use App\Contracts\Reserve\ReserveProductServiceContract;
use App\Dto\Reserve\ReserveProductRequestDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reserve\ReserveProductsRequest;
use OpenApi\Attributes as OA;

class ReserveController extends Controller
{
    public function __construct(
        private readonly ReserveProductServiceContract $reserveProductService
    )
    {
    }

    #[OA\Post(
        path: '/api/reserve-products',
        description: 'Резервация Товаров',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: "#/components/schemas/ReserveProductsRequest",
            )
        ),
        tags: ['Резервация Товаров'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Ok',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string'
                        ),
                        new OA\Property(
                            property: 'status',
                            type: 'boolean'
                        ),
                    ]
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
    public function reserveProducts(ReserveProductsRequest $request)
    {
        $products = [];

        foreach ($request->products as $product) {
            $products[] = new ReserveProductRequestDto(
                productId: $product['product_id'],
                count: $product['count'],
            );
        }

        $this->reserveProductService->reserveProducts($products);

        return $this->successResponse(['message' => 'Products Successful Reserved.', 'success' => true]);
    }

    #[OA\Post(
        path: '/api/un-reserve-products',
        description: 'Разрезервация Товаров',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: "#/components/schemas/ReserveProductsRequest",
            )
        ),
        tags: ['Резервация Товаров'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Ok',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string'
                        ),
                        new OA\Property(
                            property: 'status',
                            type: 'boolean'
                        ),
                    ]
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
    public function unReserveProducts(ReserveProductsRequest $request)
    {
        $products = [];

        foreach ($request->products as $product) {
            $products[] = new ReserveProductRequestDto(
                productId: $product['product_id'],
                count: $product['count'],
            );
        }

        $this->reserveProductService->unReserveProducts($products);

        return $this->successResponse(['message' => 'Products Successful UnReserved.', 'success' => true]);
    }

}
