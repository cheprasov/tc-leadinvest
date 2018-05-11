<?php

use TC\Lendinvest\Exception\IncorrectDateException;
use TC\Lendinvest\Loan\Loan;

class LoanTest extends \Test\BaseTestCase
{
    public function testScenarioException1()
    {
        $this->expectException(IncorrectDateException::class);
        $Loan = new Loan('2015-10-00', '2015-11-15');
    }

    public function testScenarioException2()
    {
        $this->expectException(IncorrectDateException::class);
        $Loan = new Loan('2015-10-32', '2015-11-15');
    }

    public function testScenarioException3()
    {
        $this->expectException(IncorrectDateException::class);
        $Loan = new Loan('2015-10-01', '2015-09-01');
    }
}
