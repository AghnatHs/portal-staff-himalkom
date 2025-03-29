<?php

namespace App\Http\Controllers;

use App\Models\WorkProgram;
use App\Models\Department;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


class WorkProgramsController extends Controller
{
    public function index(Department $department): View
    {
        if (Auth::user()->department_id !== $department->id) {
            abort(403, 'Anda tidak memiliki izin untuk melihat program dari departemen ini.');
        }

        return view('workprograms.index', ['department' => $department]);
    }

    public function detail(Department $department, WorkProgram $workProgram): View
    {
        if (Auth::user()->department_id !== $department->id) {
            abort(403, 'Anda tidak memiliki izin untuk melihat program dari departemen ini.');
        }

        return view('workprograms.detail', ['workProgram' => $workProgram]);
    }

    public function create(Department $department): View
    {
        if (Auth::user()->department_id !== $department->id) {
            abort(403, 'Anda tidak memiliki izin untuk menambah program untuk departemen ini.');
        }

        return view('workprograms.create', ['department' => $department]);
    }

    public function store(Request $request, Department $department)
    {
        if (Auth::user()->department_id !== $department->id) {
            abort(403, 'Anda tidak memiliki izin untuk menambah program untuk departemen ini.');
        }

        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'start_at' => 'required|date',
                'finished_at' => 'required|date|after_or_equal:start_at',
                'funds' => 'required|numeric|min:0',
                'sources_of_funds' => 'required|string|max:255',
                'participation_total' => 'required|integer|min:0',
                'participation_coverage' => 'required|string|max:255',
            ]);

            $validated['department_id'] = Auth::user()->department->id;

            WorkProgram::create($validated);
            DB::commit();
            return redirect()->route('dashboard.workProgram.index', ['department' => $department])
                ->with('success', 'Program kerja berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard.workProgram.index', ['department' => $department])
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit(Department $department, WorkProgram $workProgram)
    {
        if (Auth::user()->department_id !== $workProgram->department_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah program ini.');
        }

        return view('workprograms.edit', ['workProgram' => $workProgram]);
    }


    public function update(Request $request, Department $department, WorkProgram $workProgram)
    {
        if (Auth::user()->department_id !== $workProgram->department_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah program ini.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_at' => 'required|date',
            'finished_at' => 'required|date|after_or_equal:start_at',
            'funds' => 'required|numeric|min:0',
            'sources_of_funds' => 'required|string|max:255',
            'participation_total' => 'required|integer|min:0',
            'participation_coverage' => 'required|string|max:255',
        ]);

        $validated['department_id'] = $workProgram->department_id;
        $workProgram->update($validated);

        return redirect()->route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'department' => $department])
            ->with('success', 'Program berhasil diperbarui.');
    }


    public function destroy(Department $department, WorkProgram $workProgram)
    {
        if (Auth::user()->department_id !== $workProgram->department_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus program ini.');
        }

        try {
            $workProgram->delete();
            return redirect()->route('dashboard.workProgram.index', ['department' => $department])
                ->with('success', 'Program berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.workProgram.index', ['department' => $department])
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
