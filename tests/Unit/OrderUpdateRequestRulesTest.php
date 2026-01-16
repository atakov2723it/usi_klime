<?php

namespace Tests\Unit;

use App\Http\Requests\OrderUpdateRequest;
use PHPUnit\Framework\TestCase;

class OrderUpdateRequestRulesTest extends TestCase
{
    public function test_order_update_request_has_status_rule_with_allowed_values(): void
    {
        $request = new OrderUpdateRequest();

        $rules = $request->rules();

        $this->assertArrayHasKey('status', $rules);

        $statusRules = is_array($rules['status']) ? $rules['status'] : [$rules['status']];

        // Ovo radi ako ti je rule napisan kao string "in:..."
        $this->assertTrue(
            collect($statusRules)->contains(fn ($r) => is_string($r) && str_contains($r, 'in:pending,paid,shipped,cancelled')),
            'Expected status rules to contain "in:pending,paid,shipped,cancelled".'
        );
    }
}
