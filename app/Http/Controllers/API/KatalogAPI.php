<?php

namespace App\Http\Controllers\API;

use App\Models\Katalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CrudResource;

class KatalogAPI extends Controller
{
    function index(Request $request)
    {
        $search = $request->search;
        $limit = $request->limit;
        $jenis = $request->jenis;
        $orderBy = $request->orderBy;
        $sort = $request->sort == 'asc' ? 'asc' : 'desc';
        $data = Katalog::where(function ($query) use ($search) {
            $query->where('judul', 'like', "%$search%")
                ->orWhere('tahun', 'like', "%$search%")
                ->orWhere('penerbit', 'like', "%$search%")
                ->orWhere('penulis', 'like', "%$search%");
        })->when($orderBy, function ($query) use ($orderBy, $sort) {
            $query->orderBy($orderBy, $sort);
        })
            ->when($jenis, function ($query) use ($jenis) {
                $query->where('jenis', $jenis);
            })
            ->paginate($limit);
        return new CrudResource('success', 'Data Katalog', $data);
    }

    function ready(Request $request)
    {
        $search = $request->search;
        $jenis = $request->jenis;
        $data = Katalog::where(function ($query) use ($search) {
            $query->where('judul', 'like', "%$search%")
                ->orWhere('tahun', 'like', "%$search%")
                ->orWhere('penerbit', 'like', "%$search%")
                ->orWhere('penulis', 'like', "%$search%");
        })
            ->where('jenis', $jenis)
            ->where('stok', '>', 0)
            ->orderBy('judul', 'asc')
            ->get();
        return new CrudResource('success', 'Data Katalog', $data);
    }
    function all(Request $request)
    {
        $search = $request->search;
        $data = Katalog::where(function ($query) use ($search) {
            $query->where('judul', 'like', "%$search%")
                ->orWhere('tahun', 'like', "%$search%")
                ->orWhere('penerbit', 'like', "%$search%")
                ->orWhere('penulis', 'like', "%$search%");
        })
            ->orderBy('judul', 'asc')
            ->get();
        return new CrudResource('success', 'Data Katalog', $data);
    }

    function detail($id)
    {
        $data = Katalog::find($id);
        return new CrudResource('success', 'Data Katalog', $data);
    }
}
