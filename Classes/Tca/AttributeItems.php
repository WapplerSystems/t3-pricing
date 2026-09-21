<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Tca;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Fuellt die Merkmalsauswahl eines Wertes.
 *
 * Ein Wert haengt am Tarif, der Tarif an der Preistabelle, die Merkmale an
 * deren Gruppen. Diese Kette kann TCA nicht selbst laufen, deshalb wird sie
 * hier von Hand gezogen: nur Merkmale derselben Preistabelle stehen zur
 * Auswahl, und zwar nach Gruppe gruppiert.
 */
final class AttributeItems
{
    public function build(array &$config): void
    {
        $config['items'] = [['label' => '', 'value' => 0]];

        $tabelle = $this->findeTabelle($config['row'] ?? []);
        if ($tabelle === null) {
            return;
        }

        $pool = GeneralUtility::makeInstance(ConnectionPool::class);
        $q = $pool->getQueryBuilderForTable('tx_pricing_domain_model_attribute');
        $q->getRestrictions()->removeAll();

        $zeilen = $q
            ->select('a.uid', 'a.title', 'g.title AS gruppe')
            ->from('tx_pricing_domain_model_attribute', 'a')
            ->join('a', 'tx_pricing_domain_model_group', 'g', 'g.uid = a.attribute_group')
            ->where(
                $q->expr()->eq('g.pricing_table', $q->createNamedParameter($tabelle, \Doctrine\DBAL\ParameterType::INTEGER)),
                $q->expr()->eq('a.deleted', 0),
                $q->expr()->eq('g.deleted', 0)
            )
            ->orderBy('g.sorting')
            ->addOrderBy('a.sorting')
            ->executeQuery()
            ->fetchAllAssociative();

        $letzteGruppe = null;
        foreach ($zeilen as $zeile) {
            if ($zeile['gruppe'] !== $letzteGruppe) {
                $config['items'][] = ['label' => $zeile['gruppe'], 'value' => '--div--'];
                $letzteGruppe = $zeile['gruppe'];
            }
            $config['items'][] = ['label' => $zeile['title'], 'value' => (int)$zeile['uid']];
        }
    }

    /**
     * Die Preistabelle zum Wert finden - ueber den Tarif, der ihn haelt.
     * Bei einem neuen, noch nicht gespeicherten Wert steht die uid des
     * Tarifs im Feld plan bereits drin, weil Inline sie vorbelegt.
     */
    private function findeTabelle(array $row): ?int
    {
        $plan = $row['plan'] ?? null;
        if (is_array($plan)) {
            $plan = $plan[0] ?? null;
        }
        $plan = (int)$plan;
        if ($plan <= 0) {
            return null;
        }

        $q = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_pricing_domain_model_plan');
        $q->getRestrictions()->removeAll();

        $tabelle = $q
            ->select('pricing_table')
            ->from('tx_pricing_domain_model_plan')
            ->where($q->expr()->eq('uid', $q->createNamedParameter($plan, \Doctrine\DBAL\ParameterType::INTEGER)))
            ->executeQuery()
            ->fetchOne();

        return $tabelle ? (int)$tabelle : null;
    }
}
