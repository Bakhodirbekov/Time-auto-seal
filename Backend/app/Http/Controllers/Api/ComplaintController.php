<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display user's complaints
     */
    public function index(Request $request)
    {
        $complaints = Complaint::with(['car'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($complaints);
    }

    /**
     * Store a new complaint
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $complaint = Complaint::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Complaint submitted successfully',
            'complaint' => $complaint,
        ], 201);
    }

    /**
     * Display the specified complaint
     */
    public function show($id)
    {
        $complaint = Complaint::with(['car', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json($complaint);
    }
}
