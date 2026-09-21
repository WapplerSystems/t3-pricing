<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Ein Tarif.
 *
 * Ohne gepflegten Link gibt es keinen Knopf - das ist Absicht und wird in
 * den Templates ueber hasSelectLink() abgefragt, nicht ueber einen leeren
 * String im Fluid.
 */
class Plan extends AbstractEntity
{
    protected string $title = '';
    protected string $subtitle = '';
    protected string $eyebrow = '';
    protected string $description = '';
    protected bool $favourite = false;
    protected string $badge = '';
    protected string $selectLink = '';
    protected string $selectLabel = '';
    protected string $priceNote = '';

    /** @var ObjectStorage<Price> */
    protected ObjectStorage $prices;

    /** @var ObjectStorage<Value> */
    protected ObjectStorage $attributeValues;

    public function __construct()
    {
        $this->prices = new ObjectStorage();
        $this->attributeValues = new ObjectStorage();
    }

    public function initializeObject(): void
    {
        $this->prices ??= new ObjectStorage();
        $this->attributeValues ??= new ObjectStorage();
    }

    public function getTitle(): string { return $this->title; }
    public function getSubtitle(): string { return $this->subtitle; }
    public function getEyebrow(): string { return $this->eyebrow; }
    public function getDescription(): string { return $this->description; }
    public function isFavourite(): bool { return $this->favourite; }
    public function getBadge(): string { return $this->badge; }
    public function getSelectLink(): string { return $this->selectLink; }
    public function getSelectLabel(): string { return $this->selectLabel; }
    public function getPriceNote(): string { return $this->priceNote; }

    public function hasSelectLink(): bool { return trim($this->selectLink) !== ''; }

    /** @return ObjectStorage<Price> */
    public function getPrices(): ObjectStorage { return $this->prices; }

    /** @return ObjectStorage<Value> */
    public function getAttributeValues(): ObjectStorage { return $this->attributeValues; }
}
