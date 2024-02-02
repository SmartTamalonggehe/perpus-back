<?php

namespace App\Http\Controllers\CRUD;

use App\Models\Katalog;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CrudResource;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    protected function spartaValidation($request, $id = "")
    {
        $required = "";
        if ($id == "") {
            $required = "required";
        }
        $rules = [
            'anggota_id' => 'required',
        ];

        $messages = [
            'anggota_id.required' => 'Anggota harus diisi.',
        ];
        $validator = Validator::make($request, $rules, $messages);

        if ($validator->fails()) {
            $message = [
                'judul' => 'Gagal',
                'type' => 'error',
                'message' => $validator->errors()->first(),
            ];
            return response()->json($message, 400);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $limit = $request->limit;
        $data = Transaksi::with([
            'anggota',
            'katalog',
        ])
            ->whereHas('anggota', function ($query) use ($search) {
                $query->where('nama', 'like', "%$search%")
                    ->orWhere('NPM', 'like', "%$search%");
            })->orWhereHas('katalog', function ($query) use ($search) {
                $query->where('judul', 'like', "%$search%")
                    ->orWhere('penerbit', 'like', "%$search%")
                    ->orWhere('penulis', 'like', "%$search%");
            })
            ->orderBy('tgl_pinjam', 'desc')
            ->orderBy('tgl_kembali', 'desc')
            ->paginate($limit);
        return new CrudResource('success', 'Data Transaksi', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_req = $request->all();
        // return $data_req;
        $validate = $this->spartaValidation($data_req);
        if ($validate) {
            return $validate;
        }
        DB::beginTransaction();
        try {
            // proses input transaksi
            Transaksi::create($data_req);
            // proses ubah stok
            $katalog = Katalog::find($data_req['katalog_id']);
            if ($data_req['status'] == 'pengembalian') {
                $katalog->stok = $katalog->stok + 1;
            } else {
                $katalog->stok = $katalog->stok - 1;
            }
            $katalog->update();
            DB::commit();
            $data = Transaksi::with(['katalog', 'anggota'])->latest()->first();
            return new CrudResource('success', 'Data Berhasil Disimpan', $data);
        } catch (\Exception $e) {
            // jika terdapat kesalahan
            DB::rollback();
            $message = [
                'judul' => 'Gagal',
                'type' => 'error',
                'message' => $e->getMessage(),
            ];
            return response()->json($message, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Transaksi::with(['katalog', 'anggota'])->find($id);
        return new CrudResource('success', 'Data Transaksi', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data_req = $request->all();
        // return $data_req;
        $validate = $this->spartaValidation($data_req, $id);
        if ($validate) {
            return $validate;
        }

        DB::beginTransaction();
        try {
            Transaksi::find($id)->update($data_req);
            // proses ubah stok
            $katalog = Katalog::find($data_req['katalog_id']);
            if ($data_req['status'] == 'pengembalian') {
                $katalog->stok = $katalog->stok + 1;
            }
            $katalog->update();
            DB::commit();

            $data = Transaksi::with(['katalog', 'anggota'])->find($id);

            return new CrudResource('success', 'Data Berhasil Diubah', $data);
        } catch (\Throwable $th) {
            // jika terdapat kesalahan
            DB::rollback();
            $message = [
                'judul' => 'Gagal',
                'type' => 'error',
                'message' => $th->getMessage(),
            ];
            return response()->json($message, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Transaksi::findOrFail($id);
        DB::beginTransaction();
        try {
            $katalog = Katalog::find($data->katalog_id);
            if ($data->status == 'pengembalian') {
                $katalog->stok = $katalog->stok - 1;
                // update status to 'peminjaman' and tgl_kembali to null
                $data->status = 'peminjaman';
                $data->tgl_kembali = null;
                $data->update();
            } else {
                $katalog->stok = $katalog->stok + 1;
                $data->delete();
            }
            $katalog->update();
            DB::commit();
            return new CrudResource('success', 'Data Berhasil Dihapus', $data);
        } catch (\Throwable $th) {
            // jika terdapat kesalahan
            DB::rollback();
            $message = [
                'judul' => 'Gagal',
                'type' => 'error',
                'message' => $th->getMessage(),
            ];
            return response()->json($message, 400);
        }
    }
}
