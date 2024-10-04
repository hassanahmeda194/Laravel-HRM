<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::OrderByDesc('id')->get();
        $users = User::all();
        return view('document.index', compact('documents', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => "required",
            'file_path' => "required"
        ]);
        try {
            if ($request->hasFile('file_path')) {
                $name = uniqid() . '.' . $request->file_path->getClientOriginalName();
                $request->file_path->move(public_path('documents/'), $name);
                $path = 'documents/' . $name;
            }
            Document::create([
                'name' => $request->name,
                'file_path' => $path,
                'user_id' => $request->user_id
            ]);
            return back()->with('success', 'document Added Successfully');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'document Added Failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Document::find($id)->delete();
            return back()->with('success', "Document Deleted Successfully");
        } catch (\Throwable $th) {
            return back()->with('error', "Document Deleted Failed");
        }
    }
}
