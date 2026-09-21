<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Eine Attributgruppe, etwa "Umfang" oder "Kartengebuehren".
 *
 * inCard und inMatrix entscheiden getrennt, wo die Gruppe auftaucht: manche
 * Gruppen gehoeren auf die Karte, andere nur in die Matrix.
 */
class Group extends AbstractEntity
{
    protected string $title = '';

    /** 'list' = Liste mit Haken, 'pairs' = Wertepaare nebeneinander */
    protected string $layout = 'list';
    protected bool $inCard = true;
    protected bool $inMatrix = true;

    /** @var ObjectStorage<Attribute> */
    protected ObjectStorage $attributes;

    public function __construct()
    {
        $this->attributes = new ObjectStorage();
    }

    public function initializeObject(): void
    {
        $this->attributes ??= new ObjectStorage();
    }

    public function getTitle(): string { return $this->title; }
    public function getLayout(): string { return $this->layout; }
    public function isInCard(): bool { return $this->inCard; }
    public function isInMatrix(): bool { return $this->inMatrix; }

    /** @return ObjectStorage<Attribute> */
    public function getAttributes(): ObjectStorage { return $this->attributes; }
}
