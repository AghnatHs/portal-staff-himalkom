<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Department;
use App\Models\WorkProgram;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WorkProgramsController extends Controller
{
    private function generateFilename(UploadedFile $file, string $extension = '.pdf')
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // only filename not extension
        $filename = preg_replace('/[^a-zA-Z0-9_\-\s()]/', '', $filename);
        $generatedFilename = time() . '-' . Str::random(rand(4, 16)) . '_' . Str::slug($filename) . $extension;
        return $generatedFilename;
    }

    public function index(Department $department): View
    {
        if (Auth::user()->department_id !== $department->id) {
            abort(403, 'Unauthorized Access of Department.');
        }

        return view('dashboard.workprograms.index', ['department' => $department]);
    }

    public function detail(Department $department, WorkProgram $workProgram): View
    {
        if (Auth::user()->department_id !== $department->id) {
            abort(403, 'Unauthorized Access of Department WorkProgram.');
        }

        return view('dashboard.workprograms.detail', ['workProgram' => $workProgram]);
    }

    public function create(Department $department): View
    {
        if (Auth::user()->department_id !== $department->id) {
            abort(403, 'Unauthorized Access of Department WorkProgram Action.');
        }

        return view('dashboard.workprograms.create', ['department' => $department]);
    }

    public function store(Request $request, Department $department)
    {
        if (Auth::user()->department_id !== $department->id) {
            abort(403, 'Unauthorized Access of Department WorkProgram Action.');
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
            'lpj_url' => 'sometimes|nullable|mimes:pdf|max:5120',
            'spg_url' => 'sometimes|nullable|mimes:pdf|max:5120'
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('lpj_url')) {
                $lpjPath = $request->file('lpj_url')->storeAs('private', $this->generateFilename($request->file('lpj_url')), 'private');
                $validated['lpj_url'] = $lpjPath;
            }

            if ($request->hasFile('spg_url')) {
                $spgPath = $request->file('spg_url')->storeAs('private', $this->generateFilename($request->file('spg_url')), 'private');
                $validated['spg_url'] = $spgPath;
            }

            $validated['sources_of_funds'] = json_encode($validated['sources_of_funds']);
            $validated['department_id'] = Auth::user()->department->id;

            WorkProgram::create($validated);
            DB::commit();

            return redirect()->route('dashboard.workProgram.index', ['department' => $department])
                ->with('success', ['message' => 'Program kerja berhasil ditambahkan!', 'id' => Str::ulid()->toBase32()]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard.workProgram.create', ['department' => $department])
                ->withInput()
                ->with('error', ['message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(), 'id' => Str::ulid()->toBase32()]);
        }
    }

    public function edit(Department $department, WorkProgram $workProgram)
    {
        if (Auth::user()->department_id !== $workProgram->department_id) {
            abort(403, 'Unauthorized Access of Department WorkProgram Action.');
        }

        return view('dashboard.workprograms.edit', ['workProgram' => $workProgram]);
    }


    public function update(Request $request, Department $department, WorkProgram $workProgram)
    {
        if (Auth::user()->department_id !== $workProgram->department_id) {
            abort(403, 'Unauthorized Access of Department WorkProgram Action.');
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
            'lpj_url' => 'sometimes|nullable|mimes:pdf|max:5120',
            'spg_url' => 'sometimes|nullable|mimes:pdf|max:5120'
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

                $validated['lpj_url'] = $newFile->storeAs('private', $this->generateFilename($request->file('lpj_url')), 'private');
            } else {
                $validated['lpj_url'] = $workProgram->lpj_url;
            }

            if ($request->hasFile('spg_url')) {
                $newFile = $request->file('spg_url');
                $oldFile = $workProgram->spg_url;

                if ($oldFile && Storage::disk('private')->exists($oldFile)) {
                    if (md5_file($newFile->path()) !== md5_file(Storage::disk('private')->path($oldFile))) {
                        Storage::disk('private')->delete($oldFile);
                    }
                }

                $validated['spg_url'] = $newFile->storeAs('private', $this->generateFilename($request->file('lpj_url')), 'private');
            } else {
                $validated['spg_url'] = $workProgram->spg_url;
            }


            $validated['sources_of_funds'] = json_encode($validated['sources_of_funds']);
            $workProgram->update($validated);

            DB::commit();
            return redirect()->route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'department' => $department])
                ->with('success', ['message' => 'Program kerja berhasil diperbarui!', 'id' => Str::ulid()->toBase32()]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard.workProgram.edit', ['workProgram' => $workProgram, 'department' => $department])
                ->with('error', ['message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(), 'id' => Str::ulid()->toBase32()]);
        }
    }


    public function destroy(Department $department, WorkProgram $workProgram)
    {
        if (Auth::user()->department_id !== $workProgram->department_id) {
            abort(403, 'Unauthorized Access of Department WorkProgram Action.');
        }

        try {
            $workProgram->delete();
            return redirect()->route('dashboard.workProgram.index', ['department' => $department])
                ->with('success', ['message' => 'Program kerja berhasil dihapus!', 'id' => Str::ulid()->toBase32()]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard.workProgram.index', ['department' => $department])
                ->with('error', ['message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage(), 'id' => Str::ulid()->toBase32()]);
        }
    }
}
