<?php

declare(strict_types=1);

namespace App\AbTest\Model;

final class Stats
{
    public function __construct(private int $aCount, private int $bCount)
    {
    }

    public function total(): int
    {
        return $this->aCount + $this->bCount;
    }

    public function aCount(): int
    {
        return $this->aCount;
    }

    public function bCount(): int
    {
        return $this->bCount;
    }
}
