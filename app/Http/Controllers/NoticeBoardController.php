<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\NoticeBoard;
use App\Models\User;
use Illuminate\Http\Request;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = NoticeBoard::all();
        return view('notice-board.index', compact('notices'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "status" => "required",
            "date" => "required",
            "description" => "required",
        ]);

        try {
            NoticeBoard::create([
                "title" => $request->title,
                "status" => $request->status,
                "date" => $request->date,
                "description" => $request->description,
            ]);
            $users = User::all();
            CustomHelper::SendNotification($users, 1, "New notice posted on the notice board");
            return back()->with('success', 'NoticeBoard Added Successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'NoticeBoard Added Failed!');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $notice = NoticeBoard::find($request->id);
            return view('partials.modals.notice-board-edit', compact('notice'))->render();
        } catch (\Throwable $th) {
            return response()->json('error', 'record not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "title" => "required",
            "status" => "required",
            "date" => "required",
            "description" => "required",
        ]);

        try {
            NoticeBoard::create([
                "title" => $request->title,
                "status" => $request->status,
                "date" => $request->date,
                "description" => $request->description,
            ]);
            return back()->with('success', 'NoticeBoard Updated Successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'NoticeBoard Updated Failed!');
        }
    }

    public function destroy($id)
    {
        try {
            NoticeBoard::find($id)->delete();
            return back()->with('success', 'NoticeBoard Deleted Successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'NoticeBoard Deleted Failed!');
        }
    }

    public function getData(Request $request)
    {
        try {
            return response()->json(NoticeBoard::find($request->id));
        } catch (\Throwable $th) {
            return response()->json('error', 'record not found');
        }
    }
}
