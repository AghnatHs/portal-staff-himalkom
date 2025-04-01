<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class ModViewController extends Controller
{
    public function index()
    {
        $departments = Department::select('id', 'name', 'description', 'slug')
            ->withCount(['workPrograms'])
            ->orderBy('name', 'ASC')
            ->get()
            ->append('managing_director');
        return view('dashboard.modview.index-department', [
            'departments' => $departments
        ]);
    }

    public function showDepartment(Department $department)
    {
        $department->load(['workPrograms']);
        return view('dashboard.modview.show-department', [
            'department' => $department
        ]);
    }
}
