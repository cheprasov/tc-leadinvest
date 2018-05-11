<?php

use \TC\Lendinvest\Exception\IncorrectAmountException;
use \TC\Lendinvest\Exception\OutOfOverdraftException;
use \TC\Lendinvest\Investor\Investor;
use \TC\Lendinvest\Loan\Investment\Investment;

class InvestmentTest  extends \Test\BaseTestCase
{
    public function providerInvestment()
    {
        return [
            'set_' . __LINE__ => [
                'amount' => 1000,
                'investment' => 1000,
                'expect' => 0,
            ],
            'set_' . __LINE__ => [
                'amount' => 1000,
                'investment' => 100,
                'expect' => 900,
            ],
            'set_' . __LINE__ => [
                'amount' => 1000,
                'investment' => -10,
                'expect' => IncorrectAmountException::class,
            ],
            'set_' . __LINE__ => [
                'amount' => 900,
                'investment' => 1000,
                'expect' => OutOfOverdraftException::class,
            ],
        ];
    }

    /**
     * @see \TC\Lendinvest\Loan\Investment
     * @dataProvider providerInvestment
     */
    public function testInvestment($amount, $investment , $expect)
    {
        $Investor = new Investor($amount);
        if (is_string($expect)) {
            $this->expectException($expect);
            $Investment = new Investment($Investor, '2015-10-10', $investment);
            return;
        }
        $Investment = new Investment($Investor, '2015-10-10', $investment);
        $this->assertAmount($expect, $Investor->getAmount());
        $this->assertAmount($investment, $Investment->getAmount());
    }
}
