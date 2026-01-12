<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        if ($request->has('is_blocked')) {
            $query->where('is_blocked', $request->boolean('is_blocked'));
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::with(['cars', 'complaints'])->findOrFail($id);
        return response()->json($user);
    }

    public function block($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return response()->json(['message' => 'Cannot block admin users'], 403);
        }

        $user->update(['is_blocked' => true]);

        return response()->json(['message' => 'User blocked successfully']);
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_blocked' => false]);

        return response()->json(['message' => 'User unblocked successfully']);
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,moderator,admin',
        ]);

        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'Cannot change your own role'], 403);
        }

        $user->update(['role' => $request->role]);

        return response()->json([
            'message' => 'User role updated successfully',
            'user' => $user,
        ]);
    }
}
