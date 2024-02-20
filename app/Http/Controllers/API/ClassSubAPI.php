<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CrudResource;
use App\Models\ClassSub;
use Illuminate\Http\Request;

class ClassSubAPI extends Controller
{
    function index(Request $request)
    {
        $search = $request->search;
        $limit = $request->limit;
        $data = ClassSub::with('class_umum')->where('nm_sub', 'like', "%$search%")
            ->orderBy('nm_sub', 'asc')
            ->paginate($limit);
        return new CrudResource('success', 'Data ClassSub', $data);
    }

    function all(Request $request)
    {
        $search = $request->search;
        $data = ClassSub::with('class_umum')->where('nm_sub', 'like', "%$search%")
            ->orderBy('nm_sub', 'asc')
            ->get();
        return new CrudResource('success', 'Data ClassSub', $data);
    }
}
