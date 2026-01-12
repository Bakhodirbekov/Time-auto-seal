<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'car']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($complaints);
    }

    public function show($id)
    {
        $complaint = Complaint::with(['user', 'car'])->findOrFail($id);
        return response()->json($complaint);
    }

    public function resolve(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string',
        ]);

        $complaint = Complaint::findOrFail($id);
        
        $complaint->update([
            'status' => 'resolved',
            'admin_response' => $request->admin_response,
            'resolved_at' => now(),
        ]);

        // Notify user
        Notification::create([
            'user_id' => $complaint->user_id,
            'type' => 'complaint_resolved',
            'title' => 'Complaint Resolved',
            'message' => "Your complaint has been resolved. Response: {$request->admin_response}",
            'data' => ['complaint_id' => $complaint->id],
        ]);

        return response()->json([
            'message' => 'Complaint resolved successfully',
            'complaint' => $complaint,
        ]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string',
        ]);

        $complaint = Complaint::findOrFail($id);
        
        $complaint->update([
            'status' => 'rejected',
            'admin_response' => $request->admin_response,
        ]);

        // Notify user
        Notification::create([
            'user_id' => $complaint->user_id,
            'type' => 'complaint_rejected',
            'title' => 'Complaint Rejected',
            'message' => "Your complaint has been rejected. Response: {$request->admin_response}",
            'data' => ['complaint_id' => $complaint->id],
        ]);

        return response()->json([
            'message' => 'Complaint rejected',
            'complaint' => $complaint,
        ]);
    }
}
