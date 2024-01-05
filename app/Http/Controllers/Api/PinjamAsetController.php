<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\PinjamAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PinjamAsetRequest;
use App\Http\Resources\PinjamAsetResource;

class PinjamAsetController extends Controller
{
    //OKE
    public function index(Request $request)
    {
        // \DB::enableQueryLog();
        $keyword = $request->input('keyword');
        $query = PinjamAset::orderBy('is_pengajuan', 'asc')
            ->orderBy('created_at', 'desc')
            ->with([
                'dataAset.jenisAset', 'user.profil'
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
                if ($filter == 'masuk') {
                    $query->where('is_pengajuan', 1)->whereNull('is_diterima');
                } elseif ($filter == 'disetujui') {
                    $query->where('is_pengajuan', 1)->where('is_diterima', 1);
                } elseif ($filter == 'ditolak') {
                    $query->where('is_pengajuan', 1)->where('is_diterima', 0);
                }
            }
        }

        //filter data berdasarkan bulan dan tahun
        $tglfilter = $request->input('tanggal');
        if ($tglfilter) {
            $tglfilter = Carbon::createFromFormat('Y-m-d', $request->input('tanggal'));
            $query->whereMonth('waktu_mulai', $tglfilter->format('m'))
                ->whereYear('waktu_mulai', $tglfilter->format('Y'));
        }

        // untuk pencarian
        if ($keyword) {
            $query->where('peminjam_nama', 'like', "%$keyword%");

            $query->orWhere(function ($subquery) use ($keyword) {
                $subquery->WhereHas('dataAset', function ($query) use ($keyword) {
                    $query->where('nama', 'LIKE', "%$keyword%");
                })
                    ->orWhereHas('dataAset.jenisAset', function ($query) use ($keyword) {
                        $query->where('nama', 'LIKE', "%$keyword%");
                    });
            });
        }

        $perPage = $request->input('per_page', env('DATA_PER_PAGE', 10));
        if ($perPage === 'all') {
            $data = $query->get();
        } else {
            $data = $query->paginate($perPage);
        }
        // dd(\DB::getQueryLog());
        return PinjamAsetResource::collection($data);
    }

    //OKE 
    public function findID($id)
    {
        $data = PinjamAset::with(['dataAset.jenisAset', 'user.profil'])
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

    public function uploadFile($request)
    {
        $uploadedFile = $request->file('file_upload');
        $originalFileName = $uploadedFile->getClientOriginalName();
        $ukuranFile = $uploadedFile->getSize();
        $tipeFile = $uploadedFile->getMimeType();
        $storagePath = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d');
        if (!File::isDirectory(public_path($storagePath))) {
            File::makeDirectory(public_path($storagePath), 0755, true);
        }
        $fileName = generateUniqueFileName($originalFileName);
        $uploadedFile->move(public_path($storagePath), $fileName);
        $path = $storagePath . '/' . $fileName;
        return $path;
    }

    //OKE PUT application/x-www-form-urlencoded
    public function store(PinjamAsetRequest $request)
    {
        $validatedData = $request->validated();
        try {

            if ($request->hasFile('file_upload')) {
                $validatedData['file_upload'] = $this->uploadFile($request);
            }

            $data = PinjamAset::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'created successfully',
                'data' => new PinjamAsetResource($data),
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
    public function update(PinjamAsetRequest $request, $id)
    {
        // dd($request->all());
        try {
            $validatedData = $request->validated();
            if ($validatedData['is_pengajuan'] == 0) {
                $validatedData['is_diterima'] = null;
            }
            $data = $this->findId($id);

            if ($request->hasFile('file_upload')) {
                if ($data->file_path)
                    File::delete(public_path($data->file_path));
                $validatedData['file_upload'] = $this->uploadFile($request);
            }


            $data->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'updated successfully',
                'data' => new PinjamAsetResource($data),
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
            File::delete(public_path($data->file_upload));

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

    public function validasi(Request $request)
    {
        try {
            // $validatedData = $request->validated();
            $id = $request->input('id');
            $data = $this->findId($id);
            $start = $data->waktu_mulai;
            $end = $data->waktu_selesai;
            $is_dipakai = $this->where('data_aset_id', $dataAsetId)
                ->where(function ($query) use ($start, $end) {
                    $query->where(function ($q) use ($start, $end) {
                        $q->where('waktu_mulai', '>=', $start)
                            ->where('waktu_mulai', '<', $end);
                    })->orWhere(function ($q) use ($start, $end) {
                        $q->where('waktu_selesai', '>', $start)
                            ->where('waktu_selesai', '<=', $end);
                    });
                })
                ->where('is_diterima', true)
                ->exists();

            if ($is_dipakai) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa dipinjam',
                    'errors' => 'Aset/barang tersebut sedang digunakan oleh orang/lembaga/unit lainnya',
                ], 422);
            }

            $data->update(
                [
                    'is_diterima' => $request->input('is_diterima'),
                    'verifikator' => auth()->user()->name,
                    'verifikasi_catatan' => $request->input('verifikasi_catatan')
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'updated successfully',
                'data' => new PinjamAsetResource($data),
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

    public function ajukan(Request $request)
    {
        try {
            // $validatedData = $request->validated();
            $id = $request->input('id');
            $data = $this->findId($id);
            $data->update(['is_pengajuan' => true, 'is_diterima' => null]);

            return response()->json([
                'success' => true,
                'message' => 'updated successfully',
                'data' => new PinjamAsetResource($data),
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
