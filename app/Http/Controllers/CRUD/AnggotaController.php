<?php

namespace App\Http\Controllers\CRUD;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CrudResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\TOOLS\ImgToolsController;

class AnggotaController extends Controller
{
    public $imgController;

    public function __construct()
    {
        // memanggil controller image
        $this->imgController = new ImgToolsController();
    }
    // membuat validasi
    protected function spartaValidation($request, $id = "")
    {
        $required = "";
        if ($id == "") {
            $required = "required";
        }
        $rules = [
            'nama' => 'required',
            'tempat' => 'required',
            'tgl_lahir' => 'required',
        ];

        $messages = [
            'nama.required' => 'Nama harus diisi.',
            'tempat.required' => 'Tempat lahir harus diisi.',
            'tgl_lahir.required' => 'Tgl. Lahir harus diisi.',
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
        $data = Anggota::with(['prodi.fakultas'])
            ->where('nama', 'like', "%$search%")
            ->paginate($limit);
        return new CrudResource('success', 'Data Anggota', $data);
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
        // export foto
        if ($request->hasFile('foto')) {
            $foto = $this->imgController->addImage('foto_anggota', $data_req['foto']);
            $data_req['foto'] = "storage/$foto";
        }
        Anggota::create($data_req);

        $data = Anggota::with(['prodi.fakultas'])->latest()->first();

        return new CrudResource('success', 'Data Berhasil Disimpan', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Anggota::with(['prodi.fakultas'])->find($id);
        return new CrudResource('success', 'Data Anggota', $data);
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
        // remove _method from $data_req
        unset($data_req['_method']);
        // return $data_req;
        $validate = $this->spartaValidation($data_req, $id);
        if ($validate) {
            return $validate;
        }

        $data = Anggota::findOrFail($id);
        // find file foto
        $foto = $data->foto;
        // export foto
        if ($request->hasFile('foto')) {
            // remove file foto jika ada
            if ($foto) {
                File::delete($foto);
            }
            $foto = $this->imgController->addImage('foto_anggota', $data_req['foto']);
            $data_req['foto'] = "storage/$foto";
        } else {
            $data_req['foto'] = $foto;
        }

        $data->update($data_req);
        $data = Anggota::with(['prodi.fakultas'])->find($id);

        return new CrudResource('success', 'Data Berhasil Diubah', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Anggota::findOrFail($id);
        $foto = $data->foto;
        // remove foto foto
        if ($foto) {
            File::delete($foto);
        }
        // delete data
        $data->delete();

        return new CrudResource('success', 'Data Berhasil Dihapus', $data);
    }
}
