<?php

namespace App\Http\Controllers;

use App\Models\WorkProgram;
use App\Models\WorkProgramComment;
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

            return redirect()->back()->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'There are problems when adding a comment: ' . $e->getMessage());
        }
    }

    public function destroy(WorkProgram $workProgram, WorkProgramComment $comment)
    {
        if (Auth::user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized Access of Comment WorkProgram Action.');
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
