<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * A pricing table: the bracket around plans and features.
 *
 * Features belong to the table, not to a single plan - only then can a
 * comparison table ask every plan the same question in each row.
 */
class Table extends AbstractEntity
{
    protected string $title = '';
    protected string $description = '';

    /** 'net' = amounts are net prices, 'gross' = tax already included */
    protected string $taxMode = 'net';
    protected float $taxRate = 0.0;
    protected bool $taxSwitchable = false;
    protected bool $currencySwitchable = true;
    protected bool $periodSwitchable = true;
    protected string $selectLabel = '';

    /** 'before' = "€ 99", 'after' = "99 €" */
    protected string $currencyPosition = 'before';

    /** @var ObjectStorage<Plan> */
    protected ObjectStorage $plans;

    /** @var ObjectStorage<Group> */
    protected ObjectStorage $groups;

    public function __construct()
    {
        $this->plans = new ObjectStorage();
        $this->groups = new ObjectStorage();
    }

    public function initializeObject(): void
    {
        $this->plans ??= new ObjectStorage();
        $this->groups ??= new ObjectStorage();
    }

    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getTaxMode(): string { return $this->taxMode; }
    public function getTaxRate(): float { return $this->taxRate; }
    public function isTaxSwitchable(): bool { return $this->taxSwitchable && $this->taxMode === 'net' && $this->taxRate > 0; }
    public function isCurrencySwitchable(): bool { return $this->currencySwitchable; }
    public function isPeriodSwitchable(): bool { return $this->periodSwitchable; }
    public function getSelectLabel(): string { return $this->selectLabel; }
    public function getCurrencyPosition(): string { return $this->currencyPosition === 'after' ? 'after' : 'before'; }

    /** @return ObjectStorage<Plan> */
    public function getPlans(): ObjectStorage { return $this->plans; }

    /** @return ObjectStorage<Group> */
    public function getGroups(): ObjectStorage { return $this->groups; }
}
