<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Http\Requests\StoreLeadRequest;
use App\Services\LeadStageService;

class LeadController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Leads List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Lead::with('assignedUser');

        // 🔒 Non-admin → only their leads
        if (!auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }

        // Stage filter
        if ($request->filled('stage')) {
            $query->where('stage', $request->stage);
        }

        // Admin can filter by assigned user
        if ($request->filled('assigned_to') && auth()->user()->isAdmin()) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $leads = $query->latest()->paginate(10);
        $salesUsers = User::where('role','sales')->get();

        return view('leads.index', compact('leads','salesUsers'));
    }


    /*
    |--------------------------------------------------------------------------
    | Show Create Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $salesUsers = User::where('role','sales')->get();

        return view('leads.create', compact('salesUsers'));
    }


    /*
    |--------------------------------------------------------------------------
    | Store Lead
    |--------------------------------------------------------------------------
    */

    public function store(StoreLeadRequest $request)
    {
        $data = $request->validated();

        $data['created_by'] = auth()->id();
        $data['stage'] = 'New Lead';

        // Admin → can assign manually
        if (auth()->user()->isAdmin()) {
            $data['assigned_to'] = $request->assigned_to;
        } else {
            // Sales → auto assign to self
            $data['assigned_to'] = auth()->id();
        }

        Lead::create($data);

        return redirect()->route('leads.index')
                         ->with('success','Lead Created Successfully');
    }


    /*
    |--------------------------------------------------------------------------
    | Show Single Lead
    |--------------------------------------------------------------------------
    */

   public function websiteStore(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
    ]);

    // Default Admin ID (IMPORTANT)
    $defaultAdminId = User::where('role','admin')->value('id');

    Lead::create([
        'name' => $request->name,
        'company_name' => $request->company_name ?? 'N/A',
        'email' => $request->email,
        'phone' => $request->phone ?? 'N/A',
        'source' => 'Website',
        'stage' => 'New Lead',
        'created_by' => $defaultAdminId,
        'assigned_to' => null,
    ]);

    return back()->with('success','Thank you! Our team will contact you shortly.');
}


   public function show(Lead $lead)
{
    // Security: Sales sirf apni leads dekh sakte
    if (!auth()->user()->isAdmin() && $lead->assigned_to != auth()->id()) {
        abort(403);
    }

    // Yaha Lead ka stage history fetch karo
    // Simple approach: just current stage for now
    // Agar Stage history table hai, to uska relation load karo
    // $lead->stageHistory

    return view('leads.show', compact('lead'));
}



    /*
    |--------------------------------------------------------------------------
 --------------------------------------------------------------
    | Update Lead
    |--------------------------------------------------------------------------
    */

    public function update(StoreLeadRequest $request, Lead $lead)
    {
        $this->authorizeLead($lead);

        $data = $request->validated();

        if (auth()->user()->isAdmin()) {
            $data['assigned_to'] = $request->assigned_to;
        }

        $lead->update($data);

        return redirect()->route('leads.index')
                         ->with('success','Lead Updated Successfully');
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Lead
    |--------------------------------------------------------------------------
    */

    public function destroy(Lead $lead)
    {
        $this->authorizeLead($lead);

        $lead->delete();

        return redirect()->route('leads.index')
                         ->with('success','Lead Deleted Successfully');
    }


    /*
    |--------------------------------------------------------------------------
    | Move Stage
    |--------------------------------------------------------------------------
    */

   public function moveStage(Request $request, Lead $lead)
{
    // User permission check
    $this->authorizeLead($lead);

    // Validate request
    $request->validate([
        'stage' => 'required|string',
        'lost_reason' => 'required_if:stage,Lost|string|nullable',
        'assigned_to' => 'nullable|exists:users,id'
    ]);

    // Stage transition allowed yes or Not 
    if (!LeadStageService::canMove($lead, $request->stage)) {
        \Log::warning("Invalid stage transition", [
            'lead_id' => $lead->id,
            'current_stage' => $lead->stage,
            'requested_stage' => $request->stage
        ]);

        return redirect()->route('leads.index')->with('warning','Quotation Create and status Updated');

    }

    // Admin stage assign 
    if (auth()->user()->isAdmin() && $request->filled('assigned_to')) {
        $lead->assigned_to = $request->assigned_to;
    }

    // Stage and lost_reason safe  update
    $lead->stage = $request->stage;
    $lead->lost_reason = $request->stage === 'Lost' ? $request->lost_reason : null;

    $lead->save();

    // return response()->json(['message' => 'Stage Updated Successfully', 'lead' => $lead]);
   
    return redirect()->route('leads.index')->with('success','Lead Move Successfully');
 
}




    /*
    |--------------------------------------------------------------------------
    | Authorization Helper
    |--------------------------------------------------------------------------
    */

    private function authorizeLead($lead)
    {
        if (!auth()->user()->isAdmin() &&
            $lead->assigned_to != auth()->id()) {
            abort(403);
        }
    }
    
}
