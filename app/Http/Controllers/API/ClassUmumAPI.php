<?php

namespace App\Http\Controllers\API;

use App\Models\ClassUmum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CrudResource;

class ClassUmumAPI extends Controller
{
    function index(Request $request)
    {
        $search = $request->search;
        $limit = $request->limit;
        $data = ClassUmum::where('nm_umum', 'like', "%$search%")
            ->orderBy('nm_umum', 'asc')
            ->paginate($limit);
        return new CrudResource('success', 'Data ClassUmum', $data);
    }

    function all(Request $request)
    {
        $search = $request->search;
        $data = ClassUmum::where('nm_umum', 'like', "%$search%")
            ->orderBy('nm_umum', 'asc')
            ->get();
        return new CrudResource('success', 'Data ClassUmum', $data);
    }
}
