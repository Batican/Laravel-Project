<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public function index()
    {
        $this->authorize('view', Product::class);

        return Product::all();
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $this->authorize('create', Product::class);

        $product = Product::create($request->validated());

        return $this->sendResponse($product, 'Product created successfully.');
    }

    public function show($id): JsonResponse
    {
        $this->authorize('view', Product::class);

        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse($product, 'Product retrieved successfully.');
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', Product::class);

        $product->update($request->validated());

        return $this->sendResponse($product, 'Product updated successfully.');
    }


    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('delete', Product::class);

        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
