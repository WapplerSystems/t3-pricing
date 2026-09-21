<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\View;

use WapplerSystems\Pricing\Domain\Model\Plan;
use WapplerSystems\Pricing\Domain\Model\Table;

/**
 * Bereitet eine Preistabelle fuer die Ausgabe auf.
 *
 * Die Schalter fuer Waehrung, Zeitraum und Steuer laufen im Browser, ohne
 * Nachladen: es werden alle Kombinationen ausgegeben und bis auf die aktive
 * per CSS verborgen. Dadurch bleibt die Seite in vollem Umfang cachebar, und
 * ohne JavaScript steht die Vorgabekombination da.
 */
final class TablePresenter
{
    private const ZEICHEN = ['EUR' => '€', 'CHF' => 'CHF', 'USD' => '$', 'GBP' => '£'];

    public function bereite(Table $tabelle): array
    {
        $waehrungen = [];
        $zeitraeume = [];

        foreach ($tabelle->getPlans() as $tarif) {
            foreach ($tarif->getPrices() as $preis) {
                $waehrungen[$preis->getCurrency()] = true;
                $zeitraeume[$preis->getPeriod()] = true;
            }
        }
        $waehrungen = array_keys($waehrungen);
        $zeitraeume = array_keys($zeitraeume);
        $zeitraumtexte = $this->zeitraumtexte($tabelle, $zeitraeume);

        $steuerarten = $tabelle->isTaxSwitchable() ? ['net', 'gross'] : [$tabelle->getTaxMode()];

        $gruppen = [];
        foreach ($tabelle->getGroups() as $gruppe) {
            $attribute = [];
            foreach ($gruppe->getAttributes() as $attribut) {
                $attribute[] = $attribut;
            }
            if ($attribute === []) {
                continue;
            }
            $gruppen[] = ['gruppe' => $gruppe, 'attribute' => $attribute];
        }

        $vorgabe = [
            'waehrung' => $waehrungen[0] ?? 'EUR',
            'zeitraum' => $zeitraeume[0] ?? 'month',
            'steuer' => $steuerarten[0],
        ];

        $tarife = [];
        foreach ($tabelle->getPlans() as $tarif) {
            $tarife[] = [
                'plan' => $tarif,
                'preise' => $this->preise($tarif, $tabelle, $steuerarten, $vorgabe),
                'gruppen' => $this->gruppenMitWerten($tarif, $gruppen),
                'auswahltext' => $tarif->getSelectLabel() ?: ($tabelle->getSelectLabel() ?: 'Auswählen'),
            ];
        }

        return [
            'tabelle' => $tabelle,
            'tarife' => $tarife,
            'gruppen' => $gruppen,
            'waehrungen' => $waehrungen,
            'waehrung' => $waehrungen[0] ?? 'EUR',
            'zeitraeume' => $zeitraeume,
            'zeitraumtexte' => $zeitraumtexte,
            'zeitraum' => $zeitraeume[0] ?? 'month',
            'steuerarten' => $steuerarten,
            'steuer' => $steuerarten[0],
            'zeigeWaehrungsschalter' => $tabelle->isCurrencySwitchable() && count($waehrungen) > 1,
            'zeigeZeitraumschalter' => $tabelle->isPeriodSwitchable() && count($zeitraeume) > 1,
            'zeigeSteuerschalter' => $tabelle->isTaxSwitchable(),
        ];
    }

    /**
     * Je Preis eine Angabe pro Steuerart. Der Bruttowert entsteht aus dem
     * gepflegten Nettobetrag und dem Steuersatz der Tabelle.
     */
    private function preise(Plan $tarif, Table $tabelle, array $steuerarten, array $vorgabe): array
    {
        $angaben = [];

        foreach ($tarif->getPrices() as $preis) {
            foreach ($steuerarten as $steuer) {
                $betrag = $preis->getAmount();
                if ($steuer === 'gross' && $tabelle->getTaxMode() === 'net') {
                    $betrag = $betrag * (1 + $tabelle->getTaxRate() / 100);
                }

                $angaben[] = [
                    'waehrung' => $preis->getCurrency(),
                    'zeichen' => self::ZEICHEN[$preis->getCurrency()] ?? $preis->getCurrency(),
                    'zeitraum' => $preis->getPeriod(),
                    'steuer' => $steuer,
                    'betrag' => $this->formatiere($betrag, $steuer === 'gross'),
                    'einheit' => $this->einheit($preis->getPeriod(), $preis->getUnitLabel()),
                    'aufAnfrage' => $preis->isOnRequest(),
                    'anfragetext' => $preis->getOnRequestLabel() ?: 'Preis auf Anfrage',
                    'aktiv' => false,
                ];
            }
        }

        return $this->aktivenPreisMarkieren($angaben, $vorgabe);
    }

    /**
     * Welche Angabe steht beim ersten Blick da.
     *
     * Nicht jeder Tarif hat jede Kombination - ein Einzelinserat kennt kein
     * Jahresabo. Statt eine leere Stelle zu lassen, wird der Reihe nach
     * gelockert: genaue Kombination, dann gleiche Waehrung, dann die erste
     * Angabe ueberhaupt. Dasselbe tut das Skript beim Umschalten.
     */
    private function aktivenPreisMarkieren(array $angaben, array $vorgabe): array
    {
        $versuche = [
            static fn(array $a): bool => $a['waehrung'] === $vorgabe['waehrung']
                && $a['zeitraum'] === $vorgabe['zeitraum']
                && $a['steuer'] === $vorgabe['steuer'],
            static fn(array $a): bool => $a['waehrung'] === $vorgabe['waehrung']
                && $a['steuer'] === $vorgabe['steuer'],
            static fn(array $a): bool => $a['steuer'] === $vorgabe['steuer'],
            static fn(array $a): bool => true,
        ];

        foreach ($versuche as $passt) {
            foreach ($angaben as $i => $angabe) {
                if ($passt($angabe)) {
                    $angaben[$i]['aktiv'] = true;
                    return $angaben;
                }
            }
        }

        return $angaben;
    }

    /**
     * Beschriftung der Zeitraumschalter. Bei 'custom' sagt erst die eigene
     * Einheit, worum es geht - 'sonstige' hilft niemandem weiter.
     */
    private function zeitraumtexte(Table $tabelle, array $zeitraeume): array
    {
        $texte = [];
        foreach ($zeitraeume as $zeitraum) {
            $texte[$zeitraum] = match ($zeitraum) {
                'month' => 'monatlich',
                'year' => 'jährlich',
                'once' => 'einmalig',
                default => '',
            };
        }

        if (isset($texte['custom']) && $texte['custom'] === '') {
            foreach ($tabelle->getPlans() as $tarif) {
                foreach ($tarif->getPrices() as $preis) {
                    if ($preis->getPeriod() === 'custom' && $preis->getUnitLabel() !== '') {
                        $texte['custom'] = $preis->getUnitLabel();
                        break 2;
                    }
                }
            }
        }

        return $texte;
    }

    private function formatiere(float $betrag, bool $nachkomma): string
    {
        $stellen = $nachkomma && fmod($betrag, 1.0) !== 0.0 ? 2 : 0;
        return number_format($betrag, $stellen, ',', '.');
    }

    private function einheit(string $zeitraum, string $eigene): string
    {
        return match ($zeitraum) {
            'month' => 'je Monat',
            'year' => 'je Jahr',
            'once' => 'einmalig',
            default => $eigene,
        };
    }

    /**
     * Die Werte eines Tarifs, nach Gruppen sortiert wie die Tabelle sie
     * vorgibt. Fehlt ein Wert, steht null - das Template zeigt dann einen
     * Strich, ohne dass jede Zelle gepflegt sein muss.
     */
    private function gruppenMitWerten(Plan $tarif, array $gruppen): array
    {
        $nachAttribut = [];
        foreach ($tarif->getAttributeValues() as $wert) {
            $attribut = $wert->getAttribute();
            if ($attribut !== null) {
                $nachAttribut[$attribut->getUid()] = $wert;
            }
        }

        $ergebnis = [];
        foreach ($gruppen as $eintrag) {
            $zeilen = [];
            foreach ($eintrag['attribute'] as $attribut) {
                $wert = $nachAttribut[$attribut->getUid()] ?? null;
                $zeilen[] = [
                    'attribut' => $attribut,
                    'wert' => $wert,
                    'enthalten' => $wert !== null && $wert->isIncluded(),
                    'text' => $wert !== null ? $wert->getValue() : '',
                ];
            }
            $ergebnis[] = [
                'gruppe' => $eintrag['gruppe'],
                'zeilen' => $zeilen,
            ];
        }

        return $ergebnis;
    }
}
