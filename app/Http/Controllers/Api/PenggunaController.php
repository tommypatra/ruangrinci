<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PenggunaRequest;
use App\Http\Resources\PenggunaResource;

class PenggunaController extends Controller
{
    //OKE
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = User::orderBy('name', 'asc')
            ->with([
                'grupUser.grup',
                'profil' => function ($query) use ($keyword) {
                    if ($keyword) {
                        $query->where('alamat', 'LIKE', "%$keyword%")
                            ->orWhere('hp', 'LIKE', "%$keyword%");
                    }
                },
            ]);

        //untuk filter lebih dari 1 kolom
        $filter = $request->input('filter');
        if ($filter) {
            $filterArray = json_decode($filter, true);
            if (is_array($filterArray)) {
                foreach ($filterArray as $i => $dp) {
                    $query->where($i, $dp);
                }
            } else {
                $query->where('user_id', $filter);
                // ->with(['disposisi'])->where('user_id', $filter);
            }
        }

        //untuk pencarian
        $keyword = $request->input('keyword');
        if ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%");
        }

        $perPage = $request->input('per_page', env('DATA_PER_PAGE', 10));
        if ($perPage === 'all') {
            $data = $query->get();
        } else {
            $data = $query->paginate($perPage);
        }
        return PenggunaResource::collection($data);
    }

    //OKE 
    public function findID($id)
    {
        $data = User::findOrFail($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'not found',
            ], 404);
        }
        return $data;
    }

    public function show($id)
    {
        $data = $this->findID($id);
        return response()->json([
            'success' => true,
            'message' => 'ditemukan',
            'data' => $data,
        ], 201);
    }

    //OKE PUT application/x-www-form-urlencoded
    public function store(PenggunaRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        try {
            $data = User::create($validatedData);

            // $data['tanggal']
            return response()->json([
                'success' => true,
                'message' => 'created successfully',
                'data' => new PenggunaResource($data),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    //OKE PUT application/x-www-form-urlencoded
    public function update(PenggunaRequest $request, $id)
    {

        try {
            $validatedData = $request->validated();
            $data = $this->findId($id);
            if ($validatedData['password']) {
                if (!Hash::check($validatedData['password_lama'], $data->password)) {
                    return response()->json(['message' => 'Password lama tidak sesuai.'], 422);
                }
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }

            $data->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'updated successfully',
                'data' => new PenggunaResource($data),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    //OKE METHOD DELETE/ GET
    public function destroy($id)
    {
        try {
            $data = $this->findId($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
