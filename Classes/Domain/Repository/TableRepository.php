<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

class TableRepository extends Repository
{
    /**
     * Das Plugin waehlt eine Preistabelle ueber ihre uid. Wo sie liegt, ist
     * dann gleichgueltig - sonst muesste jede Seite, die eine Tabelle
     * einbindet, auch deren Ordner als Startseite gesetzt bekommen.
     */
    public function initializeObject(): void
    {
        $einstellungen = $this->createQuery()->getQuerySettings();
        $einstellungen->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($einstellungen);
    }
}
