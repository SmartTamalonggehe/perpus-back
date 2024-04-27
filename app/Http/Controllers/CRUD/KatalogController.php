<?php

namespace App\Http\Controllers\CRUD;

use App\Models\Katalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CrudResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\TOOLS\ImgToolsController;

class KatalogController extends Controller
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
            'judul' => 'required',

        ];

        $messages = [
            'judul.required' => 'Judul harus diisi.',
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
        $jenis = $request->jenis;
        $data = Katalog::with('class_sub')->where('judul', 'like', "%$search%")
            ->where('jenis', $jenis)
            ->paginate($limit);
        return new CrudResource('success', 'Data Katalog', $data);
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
        // export cover
        if ($request->hasFile('cover')) {
            $cover = $this->imgController->addImage('cover_katalog', $data_req['cover']);
            $data_req['cover'] = "storage/$cover";
        }
        Katalog::create($data_req);

        $data = Katalog::with('class_sub')->latest()->first();

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
        $data = Katalog::with('class_sub')->find($id);
        return new CrudResource('success', 'Data Katalog', $data);
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

        $data = Katalog::findOrFail($id);
        // find file cover
        $cover = $data->cover;
        // export cover
        if ($request->hasFile('cover')) {
            // remove file cover jika ada
            if ($cover) {
                File::delete($cover);
            }
            $cover = $this->imgController->addImage('cover_katalog', $data_req['cover']);
            $data_req['cover'] = "storage/$cover";
        } else {
            $data_req['cover'] = $cover;
        }

        $data->update($data_req);
        $data = Katalog::find($id);

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
        $data = Katalog::findOrFail($id);
        $cover = $data->cover;
        // remove cover cover
        if ($cover) {
            File::delete($cover);
        }
        // delete data
        $data->delete();

        return new CrudResource('success', 'Data Berhasil Dihapus', $data);
    }
}
