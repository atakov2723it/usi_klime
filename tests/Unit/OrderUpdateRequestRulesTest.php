<?php

namespace Tests\Unit;

use App\Http\Requests\OrderUpdateRequest;
use PHPUnit\Framework\TestCase;

class OrderUpdateRequestRulesTest extends TestCase
{
    public function test_order_update_request_has_status_rule_with_allowed_values(): void
    {
        $request = new OrderUpdateRequest; // ← OVO JE OK jer ima ()

        $rules = $request->rules();

        $this->assertArrayHasKey('status', $rules);

        $statusRules = is_array($rules['status'])
            ? $rules['status']
            : [$rules['status']];

        $this->assertTrue(
            collect($statusRules)->contains(
                fn ($rule) => is_string($rule)
                    && str_contains($rule, 'in:pending,paid,shipped,cancelled')
            ),
            'Expected status rules to contain allowed enum values.'
        );
    }
}
