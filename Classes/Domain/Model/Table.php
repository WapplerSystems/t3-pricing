<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Eine Preistabelle: die Klammer um Tarife und Attribute.
 *
 * Die Attribute gehoeren der Tabelle, nicht dem einzelnen Tarif - nur so
 * laesst sich eine Vergleichsmatrix bilden, in der jede Zeile fuer alle
 * Tarife dieselbe Frage stellt.
 */
class Table extends AbstractEntity
{
    protected string $title = '';
    protected string $description = '';

    /** 'net' = Betraege sind Nettopreise, 'gross' = bereits inklusive Steuer */
    protected string $taxMode = 'net';
    protected float $taxRate = 0.0;
    protected bool $taxSwitchable = false;
    protected bool $currencySwitchable = true;
    protected bool $periodSwitchable = true;
    protected string $selectLabel = '';

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

    /** @return ObjectStorage<Plan> */
    public function getPlans(): ObjectStorage { return $this->plans; }

    /** @return ObjectStorage<Group> */
    public function getGroups(): ObjectStorage { return $this->groups; }
}
