<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Der Wert eines Merkmals fuer einen Tarif.
 *
 * Fehlt der Datensatz, gilt das Merkmal als nicht enthalten - die Matrix
 * zeigt dort einen Strich. Es muss also nicht jede Zelle gepflegt werden.
 */
class Value extends AbstractEntity
{
    protected ?Attribute $attribute = null;
    protected bool $included = false;
    protected string $value = '';

    public function getAttribute(): ?Attribute { return $this->attribute; }
    public function isIncluded(): bool { return $this->included; }
    public function getValue(): string { return $this->value; }
}
