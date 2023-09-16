<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payouts = Payout::orderBy('id', 'desc')->with(['user'])
            ->paginate(5);
        return Inertia::render('payouts/index', [
            'payouts' => $payouts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get();
        $invoices = Invoice::get();
        $data = [];
        $invoices = $invoices->filter(function($value) use(&$data){
            $data[] = [
                'value' => $value->id,
                'label' => $value->amount_cents,
            ];
        });
        return Inertia::render('payouts/createPayout', ['users' => $users, 'invoices' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'commission_percentage' => 'required',
            'currency' => 'required',
            'stripe_link' => 'required|url',
            'user_id' => 'required',
            'paid' => 'required',
        ]);

        $payout = Payout::create([
            'commission_percentage' => $request->commission_percentage,
            'currency' => $request->currency,
            'stripe_link' => $request->stripe_link,
            'user_id' => $request->user_id,
            'paid' => $request->paid,
        ]);
        if ($request->has('invoice_id')) {
            $invoice_ids = $request->invoice_id;
            foreach ($invoice_ids as $key => $invoice_id) {
                Invoice::whereId($invoice_id)->update([
                    'payout_id' => $payout->id
                ]);
            }
        }
        return Redirect::route('payouts.create');
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
        $payout = Payout::whereId($id)->first();
        $invoices = Invoice::get();
        $data = [];
        $invoices = $invoices->filter(function($value) use(&$data){
            $data[] = [
                'value' => $value->id,
                'label' => $value->amount_cents,
            ];
        });
        return Inertia::render('payouts/editPayout', ['users' => $users, 'payout' => $payout, 'invoices' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payout $payout)
    {
        $this->validate($request, [
            'commission_percentage' => 'required',
            'currency' => 'required',
            'stripe_link' => 'required|url',
            'user_id' => 'required',
            'paid' => 'required',
        ]);

        Payout::whereId($payout->id)->update([
            'commission_percentage' => $request->commission_percentage,
            'currency' => $request->currency,
            'stripe_link' => $request->stripe_link,
            'user_id' => $request->user_id,
            'paid' => $request->paid,
        ]);
        return Redirect::route('payouts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payout $payout): RedirectResponse
    {
        $payout->delete();
        return Redirect::route('payouts.index');
    }
}
