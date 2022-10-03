<?php

namespace App\CommissionCalculator\Plugins;

use App\CommissionCalculator\DataTransferObject\TransactionDto;

interface CommissionModifier
{
    public function modify(TransactionDto $dto): TransactionDto;
}
