<?php

namespace App\Http\Controllers;

use App\Models\WorkProgram;
use App\Models\WorkProgramComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class WorkProgramCommentController extends Controller
{
    public function store(Request $request, WorkProgram $workProgram)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            WorkProgramComment::create([
                'content' => $request->content,
                'work_program_id' => $workProgram->id,
                'user_id' => Auth::id(),
            ]);
            DB::commit();



            return redirect()->back()->with('success', ['message' => 'Komentar Berhasil Ditambahkan!', 'id' => Str::ulid()->toBase32()]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', ['message' => 'Terjadi kesalahan saat menambahkan komentar: ' . $e->getMessage(), 'id' => Str::ulid()->toBase32()]);
        }
    }

    public function destroy(WorkProgram $workProgram, WorkProgramComment $comment)
    {
        if (Auth::user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized Access of Comment WorkProgram Action.');
        }

        $comment->delete();
        return redirect()->back()->with('success', ['message' => 'Komentar Berhasil Dihapus!', 'id' => Str::ulid()->toBase32()]);
    }
}
