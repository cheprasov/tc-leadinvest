<?php

include(__DIR__ . '/autoloader.php');



$Loan = LoanFacroty::create($DateBeg, $DateEnd);
$Loan->addTranche('A', new Tranche(3, max));
$Loan->addTranche('B', new Tranche(6, max));

$TranchA = $Loan->getTranchByName('A');

$Investror1 = InvestrorFacroty::create();
$Investror2 = InvestrorFacroty::create();
$Investror3 = InvestrorFacroty::create();
$Investror4 = InvestrorFacroty::create();

$TranchB = $Loan->getTranchByName('A');
$res = $TranchA->invest($Investror1, 1000);
$res = $TranchA->invest($Investror2, 1); // false

$TranchB = $Loan->getTranchByName('B');
$res = $TranchB->invest($Investror3, 500);
$res = $TranchB->invest($Investror4, 1000);

// On 01/11/2015 the system runs the interest calculation for the period 01/10/2015 -> 31/10/2015:
$InterestCalculator->calculateByPeriod([$Loan]);
