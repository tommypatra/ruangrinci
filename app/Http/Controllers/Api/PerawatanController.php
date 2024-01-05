<?php

namespace App\Http\Controllers\Api;

use App\Models\Perawatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PerawatanRequest;
use App\Http\Resources\PerawatanResource;
use Laravel\Sanctum\PersonalAccessToken;

class PerawatanController extends Controller
{
    //OKE
    public function index(Request $request)
    {
        // \DB::enableQueryLog();
        $keyword = $request->input('keyword');
        $query = Perawatan::orderBy('tgl_masuk', 'asc')
            ->orderBy('tgl_selesai', 'asc')
            // ->whereNull('is_disetujui')
            ->with([
                'uploadPerawatan.upload', 'rincianPerawatan.dataAset.jenisAset', 'user.profil'
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
                // if ($filter == 'masuk') {
                //     $query->where('is_pengajuan', 1)->whereNull('is_disetujui');
                // } elseif ($filter == 'disetujui') {
                //     $query->where('is_pengajuan', 1)->where('is_disetujui', 1);
                // } elseif ($filter == 'ditolak') {
                //     $query->where('is_pengajuan', 1)->where('is_disetujui', 0);
                // }
            }
        }


        //untuk pencarian
        // $keyword = $request->input('keyword');
        // if ($keyword) {
        //     $query->where('nama', 'LIKE', "%$keyword%");
        // }

        $perPage = $request->input('per_page', env('DATA_PER_PAGE', 10));
        if ($perPage === 'all') {
            $data = $query->get();
        } else {
            $data = $query->paginate($perPage);
        }
        // dd(\DB::getQueryLog());
        return PerawatanResource::collection($data);
    }

    //OKE 
    public function findID($id)
    {
        $data = Perawatan::with(['uploadPerawatan.upload', 'rincianPerawatan.dataAset'])
            ->findOrFail($id);
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
    public function store(PerawatanRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $data = Perawatan::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'created successfully',
                'data' => new PerawatanResource($data),
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
    public function update(PerawatanRequest $request, $id)
    {

        try {
            $validatedData = $request->validated();
            $data = $this->findId($id);
            $data->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'updated successfully',
                'data' => new PerawatanResource($data),
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

    public function ajukan(Request $request)
    {
        try {
            // $validatedData = $request->validated();
            $id = $request->input('id');
            $data = $this->findId($id);
            $jumlah = count($data->uploadLaporan);
            // dd($jumlah);
            if ($jumlah < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada lampiran',
                    'errors' => 'Silahkan lampirkan file pendukung terlebih dahulu',
                ], 422);
            }

            $data->update(['is_pengajuan' => true]);

            return response()->json([
                'success' => true,
                'message' => 'updated successfully',
                'data' => new PerawatanResource($data),
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
}
