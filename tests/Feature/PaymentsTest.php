<?php

namespace Tests\Feature;

use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_creation_returns_a_successful_response(): void
    {
        $response = $this->post('/api/payments',[
            'amount' => '10.00',
            'currency' => 'USD',
        ]);

        $response->assertStatus(201);
    }
    public function test_the_creation_returns_a_unsuccessful_response(): void
    {
        $response = $this->post('/api/payments',[
            'amount' => '10.00',
            'currency' => 'USR',
        ]);
        $response->assertStatus(302);
    }
    public function test_the_process_returns_a_successful_response(): void
    {
        $uuid = $this->post('/api/payments',[
            'amount' => '10.00',
            'currency' => 'USD',
        ])->json();
        $response = $this->post('/api/payments/'.$uuid . '/process',[
            'success' => true,
        ]);
        $response->assertStatus(200);
    }
    public function test_the_process_returns_a_unsuccessful_response(): void
    {
        $uuid = $this->post('/api/payments',[
            'amount' => '10.00',
            'currency' => 'USD',
        ])->json();
        $this->post('/api/payments/'.$uuid . '/process',[
            'success' => true,
        ]);
        $response = $this->post('/api/payments/'.$uuid . '/process',[
            'success' => true,
        ]);
        $response->assertStatus(422);
    }
    public function test_the_process_returns_a_unsuccessful_response_on_wrong_uuid(): void
    {
        $response = $this->post('/api/payments/'. 'some_wrong_uuid' . '/process',[
            'success' => true,
        ]);
        $response->assertStatus(400);
    }
    public function test_the_show_returns_a_successful_response(): void
    {
        $uuid = $this->post('/api/payments',[
            'amount' => '10.00',
            'currency' => 'USD',
        ])->json();
        $response = $this->get('/api/payments/'.$uuid);
        $response->assertStatus(200);
    }
}
