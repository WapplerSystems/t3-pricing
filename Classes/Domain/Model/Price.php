<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * A price: exactly one per plan, currency and period.
 *
 * Prices are entered per currency, not converted. Exchange rates go stale, and
 * list prices are rounded marketing figures anyway.
 */
class Price extends AbstractEntity
{
    protected string $currency = 'EUR';
    protected string $period = 'month';
    protected float $amount = 0.0;
    protected string $unitLabel = '';
    protected bool $onRequest = false;
    protected string $onRequestLabel = '';

    public function getCurrency(): string { return $this->currency; }
    public function getPeriod(): string { return $this->period; }
    public function getAmount(): float { return $this->amount; }
    public function getUnitLabel(): string { return $this->unitLabel; }
    public function isOnRequest(): bool { return $this->onRequest; }
    public function getOnRequestLabel(): string { return $this->onRequestLabel; }
}
