<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function index()
    {
        $this->authorize('view', User::class);

        return User::all();
    }

    public function store(UserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $user = User::create($request->validated());

        return $this->sendResponse($user, 'User created successfully.');
    }

    public function show($id): JsonResponse
    {
        $this->authorize('view', User::class);

        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', User::class);

        $validated = $request->validated();

        if (!isset($request['password'])) {
            unset($request['password']);
        }

        $user->update($validated);

        return $this->sendResponse($user, 'User updated successfully.');
    }

    public function assignRole(User $user, UserRequest $request)
    {
        $validated = $request->validated();

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
