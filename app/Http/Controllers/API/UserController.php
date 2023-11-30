<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = User::query();

        $per_page = $request->query('per_page') ? $request->query('per_page') : 10;
        $sortBy = $request->query('sortBy');

        if ($request->query('search_key')) {
            $users->where(function ($query) use ($request) {
                $query->where("first_name", 'LIKE', "%" . $request->query('search_key') . "%");
                $query->orWhere("middle_name", 'LIKE', "%" . $request->query('search_key') . "%");
                $query->orWhere("last_name", 'LIKE', "%" . $request->query('search_key') . "%");
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
        return User::all();
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'nullable|exists:App\Models\Role,id',
            'password' => 'required|min:7|regex:/[@$!%*#?&]/|required_with:confirm_password|same:confirm_password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::create($input);

        return $this->sendResponse($user, 'User created successfully.');
    }

    public function show($id): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', User::class);

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'nullable|exists:App\Models\Role,id',
            'password' => 'required|min:7|regex:/[@$!%*#?&]/|required_with:confirm_password|same:confirm_password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (!isset($input['password'])) {
            unset($input['password']);
        }

        $user->update($input);

        return $this->sendResponse($user, 'User updated successfully.');
    }

    public function assignRole(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:App\Models\Role,id',
        ]);

        $user->update([
            'role_id' => $request->role_id
        ]);

        return $user->fresh();
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', User::class);

        $user->delete();

        return $this->sendResponse([], 'User deleted successfully.');
    }
}
