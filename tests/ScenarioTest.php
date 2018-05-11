<?php

use \TC\Lendinvest\Loan\Loan;
use \TC\Lendinvest\Loan\Tranche\Tranche;
use \TC\Lendinvest\Investor\Investor;
use \TC\Lendinvest\Exception\OutOfTrancheMaxAmountException;
use \TC\Lendinvest\Exception\DuplicateTrancheForLoadException;
use \TC\Lendinvest\Interest\Calculator;

class ScenarioTest  extends \Test\BaseTestCase
{
    public function testScenario()
    {
        $Loan = new Loan('2015-10-01', '2015-11-15');
        $Loan->addTranche($TrancheA = new Tranche('A', 0.03, 1000));
        $Loan->addTranche($TrancheB = new Tranche('B', 0.06, 1000));

        $Investror1 = new Investor(1000);
        $Investror2 = new Investor(1000);
        $Investror3 = new Investor(1000);
        $Investror4 = new Investor(1000);

        $TrancheA->makeInvestment($Investror1, '2015-10-03', 1000); // ok
        $this->assertAmount(0, $Investror1->getAmount());

        // cant use $this->expectException(OutOfTrancheMaxAmountException::class);
        try {
            $TrancheA->makeInvestment($Investror2, '2015-10-04', 1); // exception
            $this->assertTrue(false, 'Waiting exception OutOfTrancheMaxAmountException');
        } catch (\TC\Lendinvest\Exception\Exception $Ex) {
            $this->assertInstanceOf(OutOfTrancheMaxAmountException::class, $Ex);
        }

        $TrancheB->makeInvestment($Investror3, '2015-10-10', 500); // ok
        $this->assertAmount(500, $Investror3->getAmount());

        //cant use $this->expectException(OutOfTrancheMaxAmountException::class);
        try {
            $TrancheB->makeInvestment($Investror4, '2015-10-25', 1100); // exception
            $this->assertTrue(false, 'Waiting exception OutOfTrancheMaxAmountException');
        } catch (\TC\Lendinvest\Exception\Exception $Ex) {
            $this->assertInstanceOf(OutOfTrancheMaxAmountException::class, $Ex);
        }

        $InterestCalculation = new Calculator();
        $InterestCalculation->incrementInvestorEarnByPeriod($Loan, '2015-10-01', '2015-10-31');

        $this->assertAmount(28.06, $Investror1->getAmount());
        $this->assertAmount(521.29, $Investror3->getAmount());
    }

    public function testScenarioException1()
    {
        $Loan = new Loan('2015-10-01', '2015-11-15');
        $Loan->addTranche($TrancheA = new Tranche('A', 0.03, 1000));

        $this->expectException(DuplicateTrancheForLoadException::class);
        $Loan->addTranche($TrancheB = new Tranche('A', 0.06, 1000));
    }

    public function testScenario2()
    {
        $Loan = new Loan('2015-01-01', '2015-12-31');
        $Loan->addTranche($TrancheA = new Tranche('A', 0.01, 1000));
        $Loan->addTranche($TrancheB = new Tranche('B', 0.05, 1000));
        $Loan->addTranche($TrancheC = new Tranche('C', 0.10, 1000));

        $Investror1 = new Investor(3000);

        $TrancheA->makeInvestment($Investror1, '2015-01-01', 1000);
        $this->assertAmount(2000, $Investror1->getAmount());

        $TrancheB->makeInvestment($Investror1, '2015-02-01', 100);
        $this->assertAmount(1900, $Investror1->getAmount());

        $TrancheC->makeInvestment($Investror1, '2015-03-01', 500);
        $this->assertAmount(1400, $Investror1->getAmount());

        $InterestCalculation = new Calculator();
        $InterestCalculation->incrementInvestorEarnByPeriod($Loan, '2015-01-01', '2015-01-31');

        $this->assertAmount(1410, $Investror1->getAmount());

        $InterestCalculation = new Calculator();
        $InterestCalculation->incrementInvestorEarnByPeriod($Loan, '2015-02-01', '2015-02-28');

        $this->assertAmount(1425, $Investror1->getAmount());

        $InterestCalculation = new Calculator();
        $InterestCalculation->incrementInvestorEarnByPeriod($Loan, '2015-03-01', '2015-03-31');

        $this->assertAmount(1490, $Investror1->getAmount());

        $InterestCalculation = new Calculator();
        $InterestCalculation->incrementInvestorEarnByPeriod($Loan, '2015-12-01', '2015-12-31');

        $this->assertAmount(1555, $Investror1->getAmount());

        $InterestCalculation = new Calculator();
        $InterestCalculation->incrementInvestorEarnByPeriod($Loan, '2016-01-01', '2016-01-31');

        $this->assertAmount(1555, $Investror1->getAmount());
    }
}
