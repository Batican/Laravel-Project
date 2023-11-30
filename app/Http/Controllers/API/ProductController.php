<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public function index(Request $request)
    {
        $this->authorize('view', Product::class);

        $users = Product::query();

        $per_page = $request->query('per_page') ? $request->query('per_page') : 10;
        $sortBy = $request->query('sortBy');

        if ($request->query('search_key')) {
            $users->where(function ($query) use ($request) {
                $query->where("name", 'LIKE', "%" . $request->query('search_key') . "%");
                $query->orWhere("description", 'LIKE', "%" . $request->query('search_key') . "%");
                $query->orWhere("price", 'LIKE', "%" . $request->query('search_key') . "%");
            });
        }

        if ($sortBy) {
            foreach ($sortBy as $key => $sort) {
                $users->orderBy($sort['key'], $sort['order']);
            }
        }

        return $users->paginate($per_page);
    }

    public function getAll()
    {
        $this->authorize('view', Product::class);

        return Product::all();
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Product::class);

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Product::create($input);

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

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', Product::class);

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->update($input);

        return $this->sendResponse($product, 'Product updated successfully.');
    }


    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('delete', Product::class);

        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
