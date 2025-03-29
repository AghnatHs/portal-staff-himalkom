<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Department;

use App\Models\WorkProgram;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_at' => 'required|date',
            'finished_at' => 'required|date|after_or_equal:start_at',
            'funds' => 'required|numeric|min:0',
            'sources_of_funds' => 'required|array',
            'sources_of_funds.*' => 'string|max:255',
            'participation_total' => 'required|integer|min:0',
            'participation_coverage' => 'required|string|max:255',
            'lpj_url' => 'sometimes|nullable|mimes:pdf|max:5120'
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('lpj_url')) {
                $generatedFilename = time() . '-' . Str::random(8) . '_' . str_replace(' ', '-', $request->file('lpj_url')->getClientOriginalName());
                $lpjPath = $request->file('lpj_url')->storeAs('private', $generatedFilename, 'private');
                $validated['lpj_url'] = $lpjPath;
            }
            $validated['sources_of_funds'] = json_encode($validated['sources_of_funds']);
            $validated['department_id'] = Auth::user()->department->id;

            WorkProgram::create($validated);
            DB::commit();

            return redirect()->route('dashboard.workProgram.index', ['department' => $department])
                ->with('success', 'Program kerja berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard.workProgram.create', ['department' => $department])
                ->withInput()
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
            'sources_of_funds' => 'required|array',
            'sources_of_funds.*' => 'string|max:255',
            'participation_total' => 'required|integer|min:0',
            'participation_coverage' => 'required|string|max:255',
            'lpj_url' => 'sometimes|nullable|mimes:pdf|max:5120'
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('lpj_url')) {
                $newFile = $request->file('lpj_url');
                $oldFile = $workProgram->lpj_url;

                if ($oldFile && Storage::disk('private')->exists($oldFile)) {
                    if (md5_file($newFile->path()) !== md5_file(Storage::disk('private')->path($oldFile))) {
                        Storage::disk('private')->delete($oldFile);
                    }
                }

                $generatedFilename = time() . '-' . Str::random(8) . '_' . str_replace(' ', '-', $newFile->getClientOriginalName());
                $validated['lpj_url'] = $newFile->storeAs('private', $generatedFilename, 'private');
            } else {
                $validated['lpj_url'] = $workProgram->lpj_url;
            }


            $validated['sources_of_funds'] = json_encode($validated['sources_of_funds']);
            $workProgram->update($validated);

            DB::commit();
            return redirect()->route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'department' => $department])
                ->with('success', 'Program berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard.workProgram.edit', ['workProgram' => $workProgram, 'department' => $department])
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
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
            DB::rollBack();
            return redirect()->route('dashboard.workProgram.index', ['department' => $department])
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
