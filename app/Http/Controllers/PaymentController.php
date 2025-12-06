<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\ProcessPaymentRequest;
use App\Services\PaymentService;
use http\Env\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $newPayment = Payment::create($validated);
        return response()->json($newPayment->uuid, 201);
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment): PaymentResource
    {
        return new PaymentResource($payment);
    }

    /**
     * Process the specified payment.
     */
    public function process(ProcessPaymentRequest $request, PaymentService $paymentService, string $uuid): PaymentResource|JsonResponse
    {
        $params = $request->validated();
        $result = $paymentService->processPayment($uuid, $params['success']);
        if(is_array($result)){
            return response()->json($result['error'], $result['code']);
        }else{
            return new PaymentResource($result);
        }
    }
}
