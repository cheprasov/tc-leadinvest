<?php

use TC\Lendinvest\Investor\Investor;
use \TC\Lendinvest\Exception\OutOfOverdraftException;

class InvestorTest  extends \Test\BaseTestCase
{
    public function providerIncrementAmount()
    {
        return [
            'set_' . __LINE__ => [
                'amount' => 1000,
                'incr' => 1000,
                'expect' => 2000,
            ],
            'set_' . __LINE__ => [
                'amount' => 1000,
                'incr' => -1000,
                'expect' => 0,
            ],
            'set_' . __LINE__ => [
                'amount' => 1000,
                'incr' => -1001,
                'expect' => OutOfOverdraftException::class,
            ],
            'set_' . __LINE__ => [
                'amount' => 900,
                'incr' => 28.28,
                'expect' => 928.28,
            ],
            'set_' . __LINE__ => [
                'amount' => 900,
                'incr' => -28.28,
                'expect' => 871.72,
            ],
        ];
    }

    /**
     * @see \TC\Lendinvest\Investor\Investor::incrementAmount
     * @dataProvider providerIncrementAmount
     */
    public function testIncrementAmount($amount, $incr , $expect)
    {
        $Investor = new Investor($amount);
        if (is_string($expect)) {
            $this->expectException($expect);
            $result = $Investor->incrementAmount($incr);
            return;
        }
        $result = $Investor->incrementAmount($incr);
        $this->assertAmount($expect, $result);
    }

    /**
     * @see \TC\Lendinvest\Investor\Investor::getMinAmount
     */
    public function testGetMinAmount()
    {
        $Investor = new Investor(1000);
        $ReflectionClass = new ReflectionClass(get_class($Investor));
        $Method = $ReflectionClass->getMethod('getMinAmount');
        $Method->setAccessible(true);
        $result = $Method->invoke($Investor);
        $this->assertAmount(0, $result);
    }
}
