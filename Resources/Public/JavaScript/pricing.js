/**
 * Preistabellen: die Schalter fuer Waehrung, Zeitraum und Steuer.
 *
 * Es sind alle Kombinationen im Markup, sichtbar ist die mit der Klasse
 * is-aktiv. Umschalten heisst also nur: Klasse umhaengen. Ohne dieses Skript
 * steht die vom Backend vorgegebene Kombination da, die Seite funktioniert
 * vollstaendig.
 */
(function () {
    'use strict';

    function anwenden(wurzel) {
        var w = wurzel.dataset.waehrung;
        var z = wurzel.dataset.zeitraum;
        var s = wurzel.dataset.steuer;

        wurzel.querySelectorAll('.ws-preise__preisblock').forEach(function (block) {
            var angaben = Array.prototype.slice.call(block.querySelectorAll('.ws-preise__preis'));

            // Nicht jeder Tarif hat jede Kombination. Der Reihe nach lockern,
            // damit nie eine leere Stelle stehen bleibt - dieselbe Abstufung
            // wie im Presenter.
            var treffer =
                angaben.filter(function (p) { return p.dataset.w === w && p.dataset.z === z && p.dataset.s === s; })[0] ||
                angaben.filter(function (p) { return p.dataset.w === w && p.dataset.s === s; })[0] ||
                angaben.filter(function (p) { return p.dataset.s === s; })[0] ||
                angaben[0];

            angaben.forEach(function (p) {
                p.classList.toggle('is-aktiv', p === treffer);
            });
        });
    }

    function verdrahten(wurzel) {
        wurzel.querySelectorAll('.ws-preise__segment').forEach(function (knopf) {
            knopf.addEventListener('click', function () {
                var art = knopf.dataset.schalter;
                var wert = knopf.dataset.wert;
                if (!art || !wert) {
                    return;
                }

                wurzel.dataset[art] = wert;

                wurzel.querySelectorAll('.ws-preise__segment[data-schalter="' + art + '"]').forEach(function (andere) {
                    var aktiv = andere === knopf;
                    andere.classList.toggle('is-aktiv', aktiv);
                    andere.setAttribute('aria-pressed', aktiv ? 'true' : 'false');
                });

                anwenden(wurzel);
            });
        });
    }

    function starten() {
        document.querySelectorAll('.ws-preise').forEach(function (wurzel) {
            if (wurzel.dataset.verdrahtet === '1') {
                return;
            }
            wurzel.dataset.verdrahtet = '1';
            verdrahten(wurzel);
            anwenden(wurzel);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', starten);
    } else {
        starten();
    }
})();
