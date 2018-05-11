<?php

use TC\Lendinvest\Exception\IncorrectDateException;
use TC\Lendinvest\Exception\OutOfTrancheMaxAmountException;
use TC\Lendinvest\Exception\DuplicateTrancheForLoadException;
use TC\Lendinvest\Loan\Loan;
use \TC\Lendinvest\Loan\Tranche\Tranche;
use \TC\Lendinvest\Investor\Investor;

class TrancheTest extends \Test\BaseTestCase
{
    public function testScenarioExceptionDuplicate1()
    {
        $Loan = new Loan('2015-10-01', '2015-11-15');
        $Tranche = new Tranche('A', 0.9, 1000);

        $Loan->addTranche($Tranche);
        $this->expectException(DuplicateTrancheForLoadException::class);
        $Loan->addTranche($Tranche);
    }

    public function testScenarioExceptionDuplicate2()
    {
        $Loan = new Loan('2015-10-01', '2015-11-15');
        $TrancheA = new Tranche('A', 0.9, 1000);
        $TrancheB = new Tranche('A', 0.9, 1000);

        $Loan->addTranche($TrancheA);
        $this->expectException(DuplicateTrancheForLoadException::class);
        $Loan->addTranche($TrancheB);
    }

    public function testScenarioExceptionIncorrectAmount()
    {
        $Loan = new Loan('2015-10-01', '2015-11-15');
        $Loan->addTranche($Tranche = new Tranche('A', 0.9, 1000));
        $this->expectException(OutOfTrancheMaxAmountException::class);
        $Tranche->makeInvestment(new Investor(2000), '2015-11-01', 2000);
    }

    public function testScenarioExceptionIncorrectDateException1()
    {
        $Loan = new Loan('2015-10-01', '2015-11-15');
        $Loan->addTranche($Tranche = new Tranche('A', 0.9, 1000));
        $this->expectException(IncorrectDateException::class);
        $Tranche->makeInvestment(new Investor(2000), '2015-11-011', 1000);
    }

    public function testScenarioExceptionIncorrectDateException2()
    {
        $Loan = new Loan('2015-10-01', '2015-11-15');
        $Loan->addTranche($Tranche = new Tranche('A', 0.9, 1000));
        $this->expectException(IncorrectDateException::class);
        $Tranche->makeInvestment(new Investor(2000), '2015-01-31', 1000);
    }

    public function testMadeInvestment()
    {
        $Loan = new Loan('2015-10-01', '2015-11-15');
        $Loan->addTranche($TrancheA = new Tranche('A', 0.9, 1000));
        $Loan->addTranche($TrancheB = new Tranche('B', 0.9, 1000));

        $Investor = new Investor(2000);
        $TrancheA->makeInvestment($Investor, '2015-10-10', 500);
        $this->assertAmount(1500, $Investor->getAmount());

        $TrancheB->makeInvestment($Investor, '2015-10-10', 1000);
        $this->assertAmount(500, $Investor->getAmount());
    }
}
