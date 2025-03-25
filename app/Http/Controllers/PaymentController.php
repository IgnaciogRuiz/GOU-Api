<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::all();

        return new PaymentCollection($payments);
    }

    public function store(PaymentStoreRequest $request)
    {
        $payment = Payment::create($request->validated());

        return new PaymentResource($payment);
    }

    public function show(Request $request, Payment $payment)
    {
        return new PaymentResource($payment);
    }

    public function update(PaymentUpdateRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return new PaymentResource($payment);
    }

    public function destroy(Request $request, Payment $payment)
    {
        $payment->delete();

        return response()->noContent();
    }
}
