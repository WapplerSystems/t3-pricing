<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Ein Merkmal, nach dem alle Tarife gefragt werden.
 */
class Attribute extends AbstractEntity
{
    protected string $title = '';

    /** check | number | text | percent */
    protected string $valueType = 'check';
    protected string $unit = '';
    protected string $footnote = '';

    public function getTitle(): string { return $this->title; }
    public function getValueType(): string { return $this->valueType; }
    public function getUnit(): string { return $this->unit; }
    public function getFootnote(): string { return $this->footnote; }
}
