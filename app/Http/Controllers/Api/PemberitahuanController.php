<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Pemberitahuan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PemberitahuanRequest;
use App\Http\Resources\PemberitahuanResource;

class PemberitahuanController extends Controller
{
    //OKE
    public function index(Request $request)
    {
        // \DB::enableQueryLog();
        $keyword = $request->input('keyword');
        $query = Pemberitahuan::orderBy('created_at', 'desc')
            ->orderBy('is_dibaca', 'asc')
            ->with([
                'user.profil'
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
        return PemberitahuanResource::collection($data);
    }

    //OKE 
    public function findID($id)
    {
        $data = Pemberitahuan::with(['user.profil'])
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
    public function store(PemberitahuanRequest $request)
    {
        $validatedData = $request->validated();
        try {
            if ($validatedData['pesan'] == '')
                $validatedData['pesan'] = 'Anda mendapat pesan baru tentang ' . ucfirst($validatedData['judul']) . ', klik disini untuk lebih detail.';
            $data = Pemberitahuan::create($validatedData);

            broadcast(new \App\Events\NotificationEvent($validatedData['user_id'], null, 'notif', null));

            return response()->json([
                'success' => true,
                'message' => 'created successfully',
                'data' => new PemberitahuanResource($data),
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
    public function update(PemberitahuanRequest $request, $id)
    {

        try {
            $validatedData = $request->validated();
            $data = $this->findId($id);

            if ($validatedData['is_dibaca']) {
                broadcast(new \App\Events\NotificationEvent($data->user_id, null, 'notif', null));
            }
            $data->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'updated successfully',
                'data' => new PemberitahuanResource($data),
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
