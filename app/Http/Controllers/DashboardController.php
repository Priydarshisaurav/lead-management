<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard view
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        // Base query: Admin -> all leads, Sales -> only assigned leads
        $baseQuery = Lead::with('assignedUser');
        if (!$isAdmin) {
            $baseQuery->where('assigned_to', $user->id);
        }

        // Stage filter
        if ($request->filled('stage')) {
            $baseQuery->where('stage', $request->stage);
        }

        // Assigned user filter (Admin only)
        if ($isAdmin && $request->filled('assigned_to')) {
            $baseQuery->where('assigned_to', $request->assigned_to);
        }

        // Clone queries for counts and sums
        $totalLeads = (clone $baseQuery)->count();

        $stageCounts = (clone $baseQuery)
            ->select('stage', DB::raw('count(*) as total'))
            ->groupBy('stage')
            ->get();

        $expectedValue = (clone $baseQuery)
    ->whereIn('stage', ['Quotation Sent', 'Negotiation'])
    ->sum('expected_value');


        $wonValue = (clone $baseQuery)
            ->where('stage', 'Won')
            ->sum('expected_value');

        // Paginated leads
        $leads = (clone $baseQuery)
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Keep filters in pagination links

        // Users for admin filter dropdown
        $users = $isAdmin ? User::where('role', 'sales')->get() : collect();

        return view('dashboard', compact(
            'totalLeads',
            'stageCounts',
            'expectedValue',
            'wonValue',
            'leads',
            'users',
            'isAdmin'
        ));
    }
}


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Lead;
// use App\Models\Quotation;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;


// class DashboardController extends Controller
// {
    
// // public function dashboard()
// // {
//     // $won =Lead::where('stage', 'Won')->sum('expected_value');
//     // dd($won);

//     // if (auth()->user()->role === 'admin') {

//     //     // ✅ Admin → Sab leads
//     //     $expected = Lead::whereIn('stage', [
//     //                     'Quotation Sent',
//     //                     'Negotiation'
//     //                 ])->sum('expected_value');

                    

//     //     $won = Lead::where('stage', 'Won')
//     //                 ->sum('expected_value');

//     // } else {

//     //     // ✅ Sales → Sirf apni assigned leads
//     //     $expected = Lead::whereIn('stage', [
//     //                     'Quotation Sent',
//     //                     'Negotiation'
//     //                 ])
//     //                 ->where('assigned_to', auth()->id())
//     //                 ->sum('expected_value');

//     //     $won = Lead::where('stage', 'Won')
//     //                 ->where('assigned_to', auth()->id())
//     //                 ->sum('expected_value');
//     // }

//     return view('dashboard', compact('expected', 'won'));
// }
//     public function index(Request $request)
//     {
//         $user = Auth::user();
//         $isAdmin = $user->role === 'admin';

//         $baseQuery = Lead::with('assignedUser');

//         // 🔒 Non-admin → sirf apni leads
//         if (!$isAdmin) {
//             $baseQuery->where('assigned_to', $user->id);
//         }

//         // 🔎 Stage Filter
//         if ($request->filled('stage')) {
//             $baseQuery->where('stage', $request->stage);
//         }

//         // 🔎 Assigned User Filter (admin only)
//         if ($isAdmin && $request->filled('assigned_to')) {
//             $baseQuery->where('assigned_to', $request->assigned_to);
//         }

//         return view('dashboard', [

//             // Total Leads
//             'total' => (clone $baseQuery)->count(),

//             // Stage Counts
//             'stageCounts' => (clone $baseQuery)
//                 ->select('stage', DB::raw('count(*) as total'))
//                 ->groupBy('stage')
//                 ->get(),

//             // Expected Value
//             'expected' => (clone $baseQuery)->sum('expected_value'),

//             // Won Value
//             'won' => (clone $baseQuery)
//                 ->where('stage', 'Won')
//                 ->sum('expected_value'),

//             // Leads List (Pagination)
//             'leads' => (clone $baseQuery)
//                 ->latest()
//                 ->paginate(10),

//             // Users for Filter (Admin only)
//             'users' => $isAdmin ? User::where('role','sales')->get() : collect(),
//         ]);
//     }
// }
