<?php

use \TC\Lendinvest\Loan\Loan;
use \TC\Lendinvest\Loan\Tranche\Tranche;
use \TC\Lendinvest\Investor\Investor;
use \TC\Lendinvest\Exception\OutOfTrancheMaxAmountException;
use \TC\Lendinvest\Exception\OutOfOverdraftException;
use \TC\Lendinvest\Interest\Calculator;

class ScenarioTest  extends \PHPUnit\Framework\TestCase
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

    public function testScenario()
    {
        $Loan = new Loan('2015-10-01', '2015-11-15');
        $Loan->addTranche($TrancheA = new Tranche('A', 3, 1000));
        $Loan->addTranche($TrancheB = new Tranche('B', 6, 1000));

        $Investror1 = new Investor(1000);
        $Investror2 = new Investor(1000);
        $Investror3 = new Investor(1000);
        $Investror4 = new Investor(1000);

        $TrancheA->madeInvestment($Investror1, '2015-10-03', 1000); // ok
        $this->assertAmount(0, $Investror1->getAmount());

        // cant use $this->expectException(OutOfTrancheMaxAmountException::class);
        try {
            $TrancheA->madeInvestment($Investror2, '2015-10-04', 1); // exception
            $this->assertTrue(false, 'Waiting exception OutOfTrancheMaxAmountException');
        } catch (\TC\Lendinvest\Exception\Exception $Ex) {
            $this->assertInstanceOf(OutOfTrancheMaxAmountException::class, $Ex);
        }

        $TrancheB->madeInvestment($Investror3, '2015-10-10', 500); // ok
        $this->assertAmount(500, $Investror3->getAmount());

        //cant use $this->expectException(OutOfOverdraftException::class);
        try {
            $TrancheB->madeInvestment($Investror4, '2015-10-25', 1100); // exception
            $this->assertTrue(false, 'Waiting exception OutOfOverdraftException');
        } catch (\TC\Lendinvest\Exception\Exception $Ex) {
            $this->assertInstanceOf(OutOfOverdraftException::class, $Ex);
        }

        $InterestCalculation = new Calculator();
        $InterestCalculation->incrementInvestorEarn($Loan, '2015-10-01', '2015-10-31');

        $this->assertAmount(28.06, $Investror1->getAmount());
        $this->assertAmount(521.29, $Investror3->getAmount());
    }
}
