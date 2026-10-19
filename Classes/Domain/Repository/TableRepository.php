<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

class TableRepository extends Repository
{
    /**
     * The plugin selects a pricing table by its uid. Where it is stored does
     * not matter then - otherwise every page showing a table would also need
     * its folder set as record storage page.
     */
    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }
}
