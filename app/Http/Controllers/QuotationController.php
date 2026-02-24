<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotationRequest;
use App\Mail\QuotationMail;
use App\Models\Lead;
use App\Models\Quotation;
use App\Services\LeadStageService;
use Symfony\Component\HttpFoundation\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class QuotationController extends Controller
{
    // public function create(){


    // }
    public function index()
    {
        $query = Quotation::with('lead');

        // Agar sales hai to sirf apni leads ke quotations dekhe
        if (auth()->user()->role === 'sales') {
            $query->whereHas('lead', function ($q) {
                $q->where('assigned_to', auth()->id());
            });
        }

        $quotations = $query->latest()->paginate(10);

        return view('quotations.index', compact('quotations'));
    }


    public function create()
    {
        //   // $leads = Lead::all();   // ya paginate()
        // dd($leads);
        if (auth()->user()->role == 'admin') {
            $leads = Lead::all();
        } else {
            $leads = Lead::where('assigned_to', auth()->id())->get();
        }

        $leads = auth()->user()->assignedLeads;


        return view('quotations.create', compact('leads'));
    }

    public function store(Request $request)
{
    $lead = Lead::findOrFail($request->lead_id);

    // 🔹 Permission Check
    if (!auth()->check() || (!auth()->user()->isAdmin() && $lead->assigned_to != auth()->id())) {
        abort(403, "Unauthorized access");
    }

    // 🔹 Validation
    $data = $request->validate([
        'lead_id' => 'required|exists:leads,id',
        'product_name' => 'required|string',
        'quantity' => 'required|numeric',
        'rate' => 'required|numeric',
        'gst_percentage' => 'required|numeric|in:5,12,18,28',
        'valid_till' => 'required|date|after:today',
    ]);

    // 🔹 Calculation
    $subtotal = $data['quantity'] * $data['rate'];
    $gst = ($subtotal * $data['gst_percentage']) / 100;
    $total = $subtotal + $gst;

    $data['subtotal'] = $subtotal;
    $data['gst_amount'] = $gst;
    $data['total_amount'] = $total;

    // 🔹 Save quotation
    $quotation = Quotation::create($data);

    // 🔹 Update lead stage & expected value
    $lead->stage = 'Quotation Sent';
    $lead->expected_value = $total; // dashboard expected value ke liye
    $lead->save();

    // 🔹 Generate PDF
    $pdf = Pdf::loadView('quotations.invoice_pdf', compact('quotation'));

    // 🔹 Send Email using Gmail SMTP
    Mail::to($lead->email)->send(new QuotationMail($quotation, $pdf->output()));

    return back()->with('success', 'Quotation Created, PDF sent & Stage Updated');
}
    // public function show(Quotation $quotation)
    // {
    //     $this->authorize('view', $quotation);
    //     return view('quotations.show', compact('quotation'));
    // }



    public function updateStatus(Request $request, Quotation $quotation)
    {
        $request->validate([
            'status' => 'required|in:Draft,Accepted,Rejected'
        ]);

        $quotation->status = $request->status;
        $quotation->save();

        return back()->with('success', 'Status updated');
    }

    //     public function updateStatus(Request $request, Quotation $quotation)
    // {
    //     dd($request->status);
    // }

    //    public function updateStatus(Request $request, Quotation $quotation)
    // {

    //     $request->validate([
    //         'status' => 'required|in:Draft,Accepted,Rejected'
    //     ]);

    //     $quotation->status = $request->status;
    //     $quotation->save();

    //     return back()->with('success', ' successfully');
    // }



    public function show($id)
    {
        return "Quotation ID: " . $id;
    }

    public function downloadInvoice($id)
    {
        $quotation = Quotation::with('lead')->findOrFail($id);

        $pdf = Pdf::loadView('quotations.invoice_pdf', compact('quotation'));

        return $pdf->download('invoice-' . $quotation->id . '.pdf');
    }
}
