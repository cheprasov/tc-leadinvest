<?php

namespace Test;

class BaseTestCase  extends \PHPUnit\Framework\TestCase
{
    const EPSILON = 0.00001;

    /**
     * @see http://php.net/manual/en/language.types.float.php
     */
    protected function assertAmount($expect, $amount)
    {
        $this->assertTrue(
            abs($expect - $amount) < self::EPSILON,
            "Expected: ({$expect}),  actual: ({$amount})"
        );
    }
}
