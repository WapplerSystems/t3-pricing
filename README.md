# Preistabellen für TYPO3

Tarifkarten, Vergleichsmatrix und Kompaktzeilen aus einem einzigen Datenmodell.
Beliebige Merkmale in Gruppen, Preise je Währung, netto oder brutto, ein Favorit
und ein optionaler Auswählen-Link.

TYPO3 v14, PHP 8.2.

```
composer require wapplersystems/t3-pricing
```

Danach das Site Set `wapplersystems/pricing` in `config/sites/<site>/config.yaml`
unter `dependencies` aufnehmen — es bringt die Template-Pfade, das Stylesheet und
das Skript mit.

## Fünf Darstellungen, ein Datensatz

| Darstellung | wofür |
|---|---|
| **Tarifkarten** | Der Regelfall: zwei bis vier Tarife nebeneinander, je eine Merkmalsliste. |
| **Vergleichsmatrix** | Viele Tarife, viele Merkmale. Merkmale in Gruppen, Werte als Haken, Zahl oder Text. |
| **Karten mit Merkmalsgruppen** | Wenn ein Tarif mehr trägt als eine Liste — mehrere benannte Gruppen je Karte. |
| **Kompaktzeilen** | Ab etwa fünf Tarifen, wo Karten zu schmal würden. Eine Zeile je Tarif mit drei Kennzahlen. |
| **Karten mit Aufklappern** | Kaufentscheidung oben, Einzelheiten auf Verlangen. |

Die Matrix lässt sich jeder anderen Darstellung anhängen, wahlweise eingeklappt.

## Das Datenmodell

```
Preistabelle
├── Tarif ─── Preis      (je Währung und Zeitraum einer)
│         └── Wert       (je Merkmal einer)
└── Merkmalsgruppe
          └── Merkmal
```

Zwei Entscheidungen, die alles Weitere tragen:

**Die Merkmale gehören der Tabelle, nicht dem Tarif.** Nur so stellt jede Zeile
der Matrix allen Tarifen dieselbe Frage. Ein Tarif, für den kein Wert gepflegt
ist, zeigt einen Strich — es muss also nicht jede Zelle gefüllt werden.

**Preise werden je Währung gepflegt, nicht umgerechnet.** Wechselkurse veralten,
und Listenpreise sind gerundete Verhandlungsgrößen. Umgerechnet wird nur von
netto nach brutto, über den Steuersatz der Tabelle.

## Schalter

Währung, Abrechnungszeitraum und netto/brutto. Jeder einzeln abschaltbar, und
jeder erscheint nur, wenn es etwas zu wählen gibt — bei einer einzigen gepflegten
Währung bleibt der Währungsschalter weg.

Die Schalter laufen im Browser, ohne Nachladen: es stehen alle Kombinationen im
Markup, sichtbar ist die aktive. Die Seite bleibt damit vollständig cachebar, und
ohne JavaScript steht die im Backend gewählte Kombination da.

Hat ein Tarif die gewählte Kombination nicht — ein Einzelinserat kennt kein
Jahresabo —, wird der Reihe nach gelockert: genaue Kombination, dann gleiche
Währung, dann die erste Angabe. Es bleibt nie eine leere Stelle.

## Favorit und Auswählen-Link

Ein Tarif lässt sich hervorheben; er bekommt Rahmen und Schatten in der
Akzentfarbe, in der Matrix eine eingefärbte Spalte, und optional eine Plakette
mit frei wählbarem Text.

**Ist kein Link gepflegt, wird kein Knopf ausgegeben** — kein leerer, kein
Platzhalter. Die Beschriftung kommt aus der Preistabelle und lässt sich je Tarif
überschreiben.

## Farben anpassen

Alle Farben und Radien stehen als Variablen auf `.ws-preise`. Ein Sitepackage
überschreibt sie dort und färbt damit alle Darstellungen auf einmal:

```css
.ws-preise {
    --ws-preise-akzent: #f29100;
    --ws-preise-akzent-zart: #fdf6ec;
    --ws-preise-radius: 12px;
}
```

## Barrierefreiheit

Die Matrix ist eine echte Tabelle mit `scope`-Angaben, Haken und Striche tragen
einen Text für Screenreader, die Schalter sind `<button>` mit `aria-pressed`, und
auf schmalen Bildschirmen wird die Tabelle in einer eigenen Hülle geschoben, mit
feststehender Merkmalsspalte.

## Lizenz

GPL-2.0-or-later
