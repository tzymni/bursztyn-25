<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\{JsonResponse, Request};

class UserController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $users = User::withTrashed()->get()->toArray();
            return $this->sendResponse(['users' => $users], 'Users retrieved successfully.');
        } catch (QueryException $qe) {
            return $this->sendError('Database error.', (array)$qe->getMessage());
        } catch (Exception $e) {
            return $this->sendError('Unexpected error.', (array)$e->getMessage());
        }
    }

    /**
     * Show user by user_id.
     *
     * @param $userId
     * @return JsonResponse
     */
    public function show($userId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);
            $userData = $user->only(['id', 'name', 'email', 'updated_at']);
            $userData['status'] = $user->getStatusAttribute($user->status);
            return $this->sendResponse($userData, 'User retrieved successfully.');
        } catch (ModelNotFoundException $e) {
            return $this->sendError(sprintf('User not found with id %d.', $userId));
        }
    }

    private function validateUser(Request $request, $userId = null)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => $userId ? 'sometimes|required|min:6' : 'required|min:6',
            'c_password' => 'same:password',
        ]);
    }

    /**
     * Create user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = $this->validateUser($request);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', (array)$validator->errors());
        }

        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);

            return $this->sendResponse([
                'name' => $user->name,
                'email' => $user->email,
            ], 'User registered successfully.');
        } catch (\Exception $e) {
            \Log::error('User Store Error: ' . $e->getMessage());
            return $this->sendError('Internal Server Error.', ['error' => 'Something went wrong.']);
        }
    }

    /**
     * Update user.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, $userId): JsonResponse
    {
        $validator = $this->validateUser($request, $userId);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', (array)$validator->errors());
        }

        try {

            $user = User::findOrFail($userId);
            $user->fill($request->only(['name', 'email']));
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            return $this->sendResponse([
                'name' => $user->name,
                'email' => $user->email,
            ], 'User updated successfully.');
        } catch (\Exception $e) {
            \Log::error('User Update Error: ' . $e->getMessage());
            return $this->sendError('Internal Server Error.', ['error' => 'Something went wrong.']);
        }
    }


    /**
     * (Soft) Delete user record.
     *
     * @param $userId
     * @return JsonResponse
     */
    public function destroy($userId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();
            return $this->sendResponse($userId, 'User removed successfully.');
        } catch (ModelNotFoundException $e) {
            return $this->sendError(sprintf('User not found with id %d.', $userId));
        }

    }
}
