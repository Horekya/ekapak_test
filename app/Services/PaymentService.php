<?php

namespace App\Services;

use App\Models\Payment;

class PaymentService
{
    public function processPayment(string $uuid, bool $success): array|Payment
    {
        $payment = Payment::find($uuid);
        if(!$payment)
            return ['error' => 'Payment not found', 'code' => 400];
        if($payment->status !== Payment::STATUS_PENDING)
            return ['error' => 'Payment already pending', 'code' => 422];

        $payment->update(['status' => $success ? Payment::STATUS_SUCCESS : Payment::STATUS_FAILED]);
        return $payment->fresh();
    }
}
