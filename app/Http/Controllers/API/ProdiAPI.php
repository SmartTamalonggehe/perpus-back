<?php

namespace App\Http\Controllers\API;

use App\Models\Prodi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CrudResource;

class ProdiAPI extends Controller
{
    function index()
    {
        $data = Prodi::orderBy('id', 'asc')->get();
        return new CrudResource('success', 'Data Prodi', $data);
    }
}
