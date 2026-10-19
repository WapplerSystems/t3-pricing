<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\View;

use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use WapplerSystems\Pricing\Domain\Model\Plan;
use WapplerSystems\Pricing\Domain\Model\Table;

/**
 * Prepares a pricing table for rendering.
 *
 * The switches for currency, period and tax run in the browser without a
 * reload: every combination is rendered and all but the active one are hidden
 * by CSS. The page therefore stays fully cacheable, and without JavaScript the
 * default combination is shown.
 */
final class TablePresenter
{
    private const SYMBOLS = ['EUR' => '€', 'CHF' => 'CHF', 'USD' => '$', 'GBP' => '£'];
    private const LLL = 'LLL:EXT:pricing/Resources/Private/Language/locallang.xlf:';

    private ?LanguageService $languageService = null;
    private string $locale = 'en';

    public function __construct(
        private readonly LanguageServiceFactory $languageServiceFactory,
    ) {}

    /**
     * The site language determines labels and number format. Without one
     * (e.g. from a CLI call) the English base labels apply.
     */
    public function prepare(Table $table, ?SiteLanguage $siteLanguage = null): array
    {
        $this->languageService = $siteLanguage !== null
            ? $this->languageServiceFactory->createFromSiteLanguage($siteLanguage)
            : $this->languageServiceFactory->create('default');
        $this->locale = $siteLanguage !== null ? (string)$siteLanguage->getLocale() : 'en';

        $currencies = [];
        $periods = [];

        foreach ($table->getPlans() as $plan) {
            foreach ($plan->getPrices() as $price) {
                $currencies[$price->getCurrency()] = true;
                $periods[$price->getPeriod()] = true;
            }
        }
        $currencies = array_keys($currencies);
        $periods = array_keys($periods);

        $taxModes = $table->isTaxSwitchable() ? ['net', 'gross'] : [$table->getTaxMode()];

        $groups = [];
        foreach ($table->getGroups() as $group) {
            $attributes = [];
            foreach ($group->getAttributes() as $attribute) {
                $attributes[] = $attribute;
            }
            if ($attributes === []) {
                continue;
            }
            $groups[] = ['record' => $group, 'attributes' => $attributes];
        }

        $default = [
            'currency' => $currencies[0] ?? 'EUR',
            'period' => $periods[0] ?? 'month',
            'taxMode' => $taxModes[0],
        ];

        $plans = [];
        foreach ($table->getPlans() as $plan) {
            $plans[] = [
                'record' => $plan,
                'prices' => $this->prices($plan, $table, $taxModes, $default),
                'groups' => $this->groupsWithValues($plan, $groups),
                'selectLabel' => $plan->getSelectLabel() ?: ($table->getSelectLabel() ?: $this->label('select')),
            ];
        }

        return [
            'table' => $table,
            'plans' => $plans,
            'groups' => $groups,
            'currencies' => $currencies,
            'currency' => $default['currency'],
            'periods' => $periods,
            'periodLabels' => $this->periodLabels($table, $periods),
            'period' => $default['period'],
            'taxModes' => $taxModes,
            'taxMode' => $default['taxMode'],
            'showCurrencySwitch' => $table->isCurrencySwitchable() && count($currencies) > 1,
            'showPeriodSwitch' => $table->isPeriodSwitchable() && count($periods) > 1,
            'showTaxSwitch' => $table->isTaxSwitchable(),
        ];
    }

    /**
     * One entry per price and tax mode. The gross value is derived from the
     * entered net amount and the tax rate of the table.
     */
    private function prices(Plan $plan, Table $table, array $taxModes, array $default): array
    {
        $entries = [];

        foreach ($plan->getPrices() as $price) {
            foreach ($taxModes as $taxMode) {
                $amount = $price->getAmount();
                if ($taxMode === 'gross' && $table->getTaxMode() === 'net') {
                    $amount = $amount * (1 + $table->getTaxRate() / 100);
                }

                $entries[] = [
                    'currency' => $price->getCurrency(),
                    'symbol' => self::SYMBOLS[$price->getCurrency()] ?? $price->getCurrency(),
                    'symbolAfter' => $table->getCurrencyPosition() === 'after',
                    'period' => $price->getPeriod(),
                    'taxMode' => $taxMode,
                    'amount' => $this->formatAmount($amount, $taxMode === 'gross'),
                    'unit' => $this->unit($price->getPeriod(), $price->getUnitLabel()),
                    'onRequest' => $price->isOnRequest(),
                    'onRequestLabel' => $price->getOnRequestLabel() ?: $this->label('onRequest'),
                    'active' => false,
                ];
            }
        }

        return $this->markActivePrice($entries, $default);
    }

    /**
     * Which entry is visible at first sight.
     *
     * Not every plan has every combination - a single job ad has no yearly
     * subscription. Instead of leaving an empty spot, the match is relaxed step
     * by step: exact combination, then same currency, then the first entry at
     * all. The script does the same when switching.
     */
    private function markActivePrice(array $entries, array $default): array
    {
        $attempts = [
            static fn(array $e): bool => $e['currency'] === $default['currency']
                && $e['period'] === $default['period']
                && $e['taxMode'] === $default['taxMode'],
            static fn(array $e): bool => $e['currency'] === $default['currency']
                && $e['taxMode'] === $default['taxMode'],
            static fn(array $e): bool => $e['taxMode'] === $default['taxMode'],
            static fn(array $e): bool => true,
        ];

        foreach ($attempts as $matches) {
            foreach ($entries as $i => $entry) {
                if ($matches($entry)) {
                    $entries[$i]['active'] = true;
                    return $entries;
                }
            }
        }

        return $entries;
    }

    /**
     * Labels of the period switch. For 'custom' only the own unit says what it
     * is about - 'other' helps nobody.
     */
    private function periodLabels(Table $table, array $periods): array
    {
        $labels = [];
        foreach ($periods as $period) {
            $labels[$period] = match ($period) {
                'month', 'year', 'once' => $this->label('period.' . $period),
                default => '',
            };
        }

        if (isset($labels['custom']) && $labels['custom'] === '') {
            foreach ($table->getPlans() as $plan) {
                foreach ($plan->getPrices() as $price) {
                    if ($price->getPeriod() === 'custom' && $price->getUnitLabel() !== '') {
                        $labels['custom'] = $price->getUnitLabel();
                        break 2;
                    }
                }
            }
        }

        return $labels;
    }

    /**
     * Thousands and decimal separators follow the locale of the site language:
     * "1.499,50" in German, "1,499.50" in English, "1 499,50" in French.
     * Without the intl extension the German format is kept, which the
     * extension has rendered from the start.
     */
    private function formatAmount(float $amount, bool $withDecimals): string
    {
        $decimals = $withDecimals && fmod($amount, 1.0) !== 0.0 ? 2 : 0;

        if (class_exists(\NumberFormatter::class)) {
            $formatter = new \NumberFormatter($this->locale, \NumberFormatter::DECIMAL);
            $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $decimals);
            $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $decimals);
            $formatted = $formatter->format($amount);
            if ($formatted !== false) {
                return $formatted;
            }
        }

        return number_format($amount, $decimals, ',', '.');
    }

    private function unit(string $period, string $ownUnit): string
    {
        return match ($period) {
            'month', 'year', 'once' => $this->label('unit.' . $period),
            default => $ownUnit,
        };
    }

    private function label(string $key): string
    {
        return $this->languageService?->sL(self::LLL . $key) ?: $key;
    }

    /**
     * The values of a plan, ordered by groups as the table defines them. A
     * missing value is null - the template then shows a dash, so not every
     * cell has to be filled.
     */
    private function groupsWithValues(Plan $plan, array $groups): array
    {
        $byAttribute = [];
        foreach ($plan->getAttributeValues() as $value) {
            $attribute = $value->getAttribute();
            if ($attribute !== null) {
                $byAttribute[$attribute->getUid()] = $value;
            }
        }

        $result = [];
        foreach ($groups as $group) {
            $rows = [];
            foreach ($group['attributes'] as $attribute) {
                $value = $byAttribute[$attribute->getUid()] ?? null;
                $rows[] = [
                    'attribute' => $attribute,
                    'value' => $value,
                    'included' => $value !== null && $value->isIncluded(),
                    'text' => $value !== null ? $value->getValue() : '',
                ];
            }
            $result[] = [
                'record' => $group['record'],
                'rows' => $rows,
            ];
        }

        return $result;
    }
}
