<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\{JsonResponse, Request};

class UserController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $users = User::all('id', 'name', 'email')->toArray();
            return $this->sendResponse(['users' => $users], 'Users retrieved successfully.');
        } catch (QueryException $qe) {
            return $this->sendError('Database error.', (array)$qe->getMessage());
        } catch (Exception $e) {
            return $this->sendError('Unexpected error.', (array)$e->getMessage());
        }
    }
}
