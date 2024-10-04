<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Designation;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Designation::all();
        $userId = auth()->user()->id;
        $roleId = auth()->user()->designation_id;
        $ticketsQuery = Ticket::with(['responses', 'attachments'])->withCount('responses');
        if ($roleId == 1) {
            $ticketsQuery->where('assigned_to', $userId);
        } elseif (in_array($roleId, [2, 3])) {
            $ticketsQuery->where('assigned_to', $roleId);
        } else {
            $ticketsQuery->where('user_id', $userId);
        }
        $tickets = $ticketsQuery->get();
        return view('tickets.index', compact('tickets', 'users'));
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
            'subject' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'assigned_to' => 'required',
            'image' => 'sometimes'
        ]);

        try {
            $ticket = Ticket::create([
                'user_id' => auth()->user()->id,
                'subject' => $request->subject,
                'description' => $request->description,
                'priority' => $request->priority,
                'assigned_to' => $request->assigned_to,
            ]);
            if ($request->hasFile('image')) {
                $name = uniqid() . '.' . $request->image->getClientOriginalName();
                $request->image->move(public_path('ticket/'), $name);
                $path = 'ticket/' . $name;
                $ticket->attachments()->create([
                    'file_path' => $path
                ]);
            }
            $assign_user = User::where('designation_id', $request->assigned_to)->get();
            CustomHelper::SendNotification($assign_user, 1, "New ticket created!");
            return back()->with("success", "ticket added successfully!");
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with("error", "ticket added failed!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $users = User::whereIn('designation_id', [1, 2, 3])->get();
            $ticket =   Ticket::find($request->id);
            return view('tickets.edit-ticket', compact('ticket', 'users'))->render();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'assigned_to' => 'required',
            'image' => 'sometimes'
        ]);

        try {
            $ticket = Ticket::find($id)->update([
                'subject' => $request->subject,
                'description' => $request->description,
                'priority' => $request->priority,
                'assigned_to' => $request->assigned_to,
            ]);
            if ($request->hasFile('image')) {
                $name = uniqid() . '.' . $request->image->getClientOriginalName();
                $request->image->move(public_path('ticket/'), $name);
                $path = 'ticket/' . $name;
                $ticket->attachments()->create([
                    'file_path' => $path
                ]);
            }
            return back()->with("success", "ticket updated successfully!");
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with("error", "ticket updated failed!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        try {
            Ticket::find($request->ticket_id)->update([
                'status' => $request->status
            ]);
            return back()->with('success', 'status updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'status updated failed');
        }
    }
}
