<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SerahTerimaAset;
use App\Http\Controllers\Controller;
use App\Http\Requests\SerahTerimaAsetRequest;
use App\Http\Resources\SerahTerimaAsetResource;

class SerahTerimaAsetController extends Controller
{
    //OKE
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = SerahTerimaAset::orderBy('tgl_kembali', 'desc')
            ->orderBy('id', 'asc')
            ->with([
                'penggunaAset.dataAset', 'penggunaAset.user'
            ]);

        //untuk filter lebih dari 1 kolom
        $filter = $request->input('filter');
        // dd($filter);
        if ($filter) {
            $filterArray = json_decode($filter, true);
            if (is_array($filterArray)) {
                foreach ($filterArray as $i => $dp) {
                    $query->where($i, $dp);
                }
            } else {
                $query->where('id', $filter);
            }
        }

        if ($keyword) {
            $query->whereHas('user', function ($userQuery) use ($keyword) {
                $userQuery->where('nama', 'LIKE', "%$keyword%");
            })->orWhereHas('dataAset', function ($dataAsetQuery) use ($keyword) {
                $dataAsetQuery->where('nama', 'LIKE', "%$keyword%");
            });
        }

        $perPage = $request->input('per_page', env('DATA_PER_PAGE', 10));
        if ($perPage === 'all') {
            $data = $query->get();
        } else {
            $data = $query->paginate($perPage);
        }
        return SerahTerimaAsetResource::collection($data);
    }

    //OKE 
    public function findID($id)
    {
        $data = SerahTerimaAset::findOrFail($id);
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
    public function store(SerahTerimaAsetRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $data = SerahTerimaAset::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'created successfully',
                'data' => new SerahTerimaAsetResource($data),
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
    public function update(SerahTerimaAsetRequest $request, $id)
    {

        try {
            $validatedData = $request->validated();
            $data = $this->findId($id);
            $data->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'updated successfully',
                'data' => new SerahTerimaAsetResource($data),
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
