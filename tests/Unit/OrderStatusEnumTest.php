<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class OrderStatusEnumTest extends TestCase
{
    public function test_order_status_enum_values_are_expected(): void
    {

        $allowed = ['pending', 'paid', 'shipped', 'cancelled'];

        $this->assertSame($allowed, array_values(array_unique($allowed)));
        $this->assertTrue(collect($allowed)->every(fn ($s) => is_string($s) && $s !== ''));

        $this->assertFalse(in_array('done', $allowed, true));
        $this->assertFalse(in_array('new', $allowed, true));
    }
}
