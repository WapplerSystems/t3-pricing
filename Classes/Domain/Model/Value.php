<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * The value of a feature for a plan.
 *
 * Without a record the feature counts as not included - the comparison table
 * shows a dash. So not every cell has to be filled.
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
