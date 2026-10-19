<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Tca;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Fills the feature selector of a value.
 *
 * A value belongs to a plan, the plan to a pricing table, the features to its
 * groups. TCA cannot follow that chain by itself, so it is resolved here: only
 * features of the same pricing table are offered, grouped by feature group.
 */
final class AttributeItems
{
    public function build(array &$config): void
    {
        $config['items'] = [['label' => '', 'value' => 0]];

        $tableUid = $this->findTable($config['row'] ?? []);
        if ($tableUid === null) {
            return;
        }

        $pool = GeneralUtility::makeInstance(ConnectionPool::class);
        $q = $pool->getQueryBuilderForTable('tx_pricing_domain_model_attribute');
        $q->getRestrictions()->removeAll();

        $rows = $q
            ->select('a.uid', 'a.title', 'g.title AS group_title')
            ->from('tx_pricing_domain_model_attribute', 'a')
            ->join('a', 'tx_pricing_domain_model_group', 'g', 'g.uid = a.attribute_group')
            ->where(
                $q->expr()->eq('g.pricing_table', $q->createNamedParameter($tableUid, \Doctrine\DBAL\ParameterType::INTEGER)),
                $q->expr()->eq('a.deleted', 0),
                $q->expr()->eq('g.deleted', 0)
            )
            ->orderBy('g.sorting')
            ->addOrderBy('a.sorting')
            ->executeQuery()
            ->fetchAllAssociative();

        $lastGroup = null;
        foreach ($rows as $row) {
            if ($row['group_title'] !== $lastGroup) {
                $config['items'][] = ['label' => $row['group_title'], 'value' => '--div--'];
                $lastGroup = $row['group_title'];
            }
            $config['items'][] = ['label' => $row['title'], 'value' => (int)$row['uid']];
        }
    }

    /**
     * Find the pricing table of a value - via the plan holding it. For a new,
     * unsaved value the plan uid is already in the field plan, because inline
     * relations prefill it.
     */
    private function findTable(array $row): ?int
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

        $tableUid = $q
            ->select('pricing_table')
            ->from('tx_pricing_domain_model_plan')
            ->where($q->expr()->eq('uid', $q->createNamedParameter($plan, \Doctrine\DBAL\ParameterType::INTEGER)))
            ->executeQuery()
            ->fetchOne();

        return $tableUid ? (int)$tableUid : null;
    }
}
