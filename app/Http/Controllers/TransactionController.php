<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $transactions = Transaction::with(['mechanic', 'vehicle', 'chasier', 'sparePart', 'customer'])->get();
        return view('transaction.index', compact('transactions'));
    }

    public function history()
    {
        $transactions = Transaction::with(['mechanic', 'vehicle', 'chasier', 'sparePart', 'customer'])->get();
        return view('history.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mechanics = User::where('role', 'mechanic')->get();
        $vehicles = Vehicle::all();
        $chasiers = User::where('role', 'chasier')->get();
        $spareParts = SparePart::all();
        $customers = Customer::all();
        return View::make('transaction.create', compact('mechanics', 'vehicles', 'chasiers', 'spareParts', 'customers'));
        return view('transaction.create', compact('mechanics', 'vehicles', 'chasiers', 'spareParts', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'mechanic_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'chasier_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:customers,id', // Perbaiki validasi ini
            'quantity' => 'required|integer',
            'date' => 'required|date',
            'description' => 'required|string',
            'spare_parts' => 'required|exists:spare_parts,id',
        ]);

        $sparePart = SparePart::find($validatedData['spare_parts']);
        $validatedData['grand_total'] = $validatedData['quantity'] * $sparePart->price;

        Transaction::create($validatedData);

        return redirect()->route('transaction.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Pastikan date adalah objek Carbon
        $transaction->date = Carbon::parse($transaction->date)->format('Y-m-d'); // Format tanggal ke 'Y-m-d'
        $mechanics = User::where('role', 'mechanic')->get();
        $vehicles = Vehicle::all();
        $chasiers = User::where('role', 'chasier')->get();
        $spareParts = SparePart::all();
        $customers = Customer::all();

        return view('transaction.edit', compact('transaction', 'mechanics', 'vehicles', 'chasiers', 'spareParts', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validatedData = $request->validate([
            'mechanic_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'chasier_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:customer,id',
            'quantity' => 'required|integer',
            'date' => 'required|date',
            'description' => 'required|string',
            'spare_parts' => 'required|exists:spare_parts,id',
        ]);

        $sparePart = SparePart::find($validatedData['spare_parts']);
        $validatedData['grand_total'] = $validatedData['quantity'] * $sparePart->price;

        $transaction->update($validatedData);

        return redirect()->route('transaction.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully'], 200);
    }
}
