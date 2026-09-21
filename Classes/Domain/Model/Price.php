<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Ein Preis: je Tarif, Waehrung und Zeitraum genau einer.
 *
 * Preise werden je Waehrung gepflegt und nicht umgerechnet. Kurse veralten,
 * und Listenpreise sind ohnehin gerundete Verhandlungsgroessen.
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
