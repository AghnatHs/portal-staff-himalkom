<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(string $slug) : View
    {
        $department = Department::where('slug', $slug)->first();
        $userDepartment = Auth::user()->department;

        if (!$department) {
            abort(404, 'Department not found');
        }

        if ($department->id != $userDepartment->id) {
            abort(403, 'Unauthorized access to this department');
        }
        return view('dashboard');
    }

    public function showSupervisor() : View
    {
        return view('dashboard_spv');
    }
}
