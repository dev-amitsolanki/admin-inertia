<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::orderBy('id', 'desc')->with(['user'])
            ->paginate(5);
        return Inertia::render('invoices/index', [
            'invoices' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get();
        $payouts = Payout::get();
        return Inertia::render('invoices/createInvoice', ['users' => $users, 'payouts' => $payouts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'user_id' => 'required',
            'amount_cents' => 'required',
            'tax_type' => 'required',
            'tax_percentage' => 'required',
            'currency' => 'required',
            'stripe_link' => 'required|url',
            'paid' => 'required',
        ]);

        Invoice::create([
            'user_id' => $request->user_id,
            'amount_cents' => $request->amount_cents,
            'tax_type' => $request->tax_type,
            'tax_percentage' => $request->tax_percentage,
            'currency' => $request->currency,
            'stripe_link' => $request->stripe_link,
            'paid' => $request->paid,
        ]);
        return Redirect::route('invoices.create');
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
        $users = User::get();
        $invoice = Invoice::whereId($id)->first();
        $payouts = Payout::get();
        return Inertia::render('invoices/editInvoice', ['users' => $users, 'invoice' => $invoice,'payouts' => $payouts]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'amount_cents' => 'required',
            'tax_type' => 'required',
            'tax_percentage' => 'required',
            'currency' => 'required',
            'stripe_link' => 'required|url',
            'paid' => 'required',
        ]);

        Invoice::whereId($invoice->id)->update([
            'user_id' => $request->user_id,
            'amount_cents' => $request->amount_cents,
            'tax_type' => $request->tax_type,
            'tax_percentage' => $request->tax_percentage,
            'currency' => $request->currency,
            'stripe_link' => $request->stripe_link,
            'paid' => $request->paid,
        ]);
        return Redirect::route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();
        return Redirect::route('invoices.index');
    }
}
