<?php

namespace App\Http\Controllers;

use App\Models\User;



use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        // 🔒 Sirf admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized Access');
        }

        $query = User::where('role', 'sales');

        // 🔍 Search Logic
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // ✅ Pagination
        $salesUsers = $query->latest()->paginate(10);

        // 🔥 AJAX request check
        if ($request->ajax()) {
            return view('sales.partials.table', compact('salesUsers'))->render();
        }

        return view('sales.index', compact('salesUsers'));

        
    }

    public function toggle(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized Access');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Sales person status updated.');
    }
}
