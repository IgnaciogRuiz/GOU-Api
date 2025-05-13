<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Dedoc\Scramble\Attributes\ExcludeRouteFromDocs;

class PaymentController extends Controller
{
     /**
     * Show All Payments
     * 
     * Muestra todos los Payments de un usuario.
     */
    public function index(Request $request)
    {
        $payments = Payment::all();

        return new PaymentCollection($payments);
    }

    /**
     * Create Payment
     * 
     * Crea un Payment.
     */
    public function store(PaymentStoreRequest $request)
    {
        $payment = Payment::create($request->validated());

        return new PaymentResource($payment);
    }

    /**
     * Show Payment
     * 
     * Muestra un Payment especifico.
     */
    public function show(Request $request, Payment $payment)
    {
        return new PaymentResource($payment);
    }

    /**
     * Update Payment
     * 
     * Actualiza un Payment especifico.
     */
    public function update(PaymentUpdateRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return new PaymentResource($payment);
    }

    #[ExcludeRouteFromDocs]
    public function destroy(Request $request, Payment $payment)
    {
        $payment->delete();

        return response()->noContent();
    }
}
