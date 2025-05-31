<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Http\Resources\TransactionCollection;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Dedoc\Scramble\Attributes\ExcludeAllRoutesFromDocs;

#[ExcludeAllRoutesFromDocs]

class TransactionController extends Controller
{
    /**
     * Show All Transactions
     * 
     * Muestra todas las transacciones de un usuario especifico.
     */

    public function index(Request $request)
    {
        $transactions = Transaction::all();

        return new TransactionCollection($transactions);
    }

    /**
     * Create Transaction
     * 
     * Crea una transaccion
     */

    public function store(TransactionStoreRequest $request)
    {
        $transaction = Transaction::create($request->validated());

        return new TransactionResource($transaction);
    }

    /**
     * Show Transaction
     * 
     * Muestra una transaccion especifica
     */

    public function show(Request $request, Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    /**
     * Update Transaction
     * 
     * Actualiza una transaccion especifica
     */

    public function update(TransactionUpdateRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());

        return new TransactionResource($transaction);
    }


    public function destroy(Request $request, Transaction $transaction)
    {
        $transaction->delete();

        return response()->noContent();
    }
}
