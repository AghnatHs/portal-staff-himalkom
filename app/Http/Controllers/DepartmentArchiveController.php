<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentArchiveController extends Controller
{
    public function index()
    {
        $departments = Department::onlyTrashed()
            ->select('id', 'name', 'description', 'slug')
            ->withCount(['workPrograms'])
            ->orderBy('name', 'ASC')
            ->get()
            ->append('managing_director');
        dd($departments);
    }
}
