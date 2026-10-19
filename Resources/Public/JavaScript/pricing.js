/**
 * Pricing tables: the switches for currency, billing period and tax mode.
 *
 * Every combination is in the markup; the one with the class is-active is
 * visible. Switching therefore only moves that class. Without this script the
 * combination configured in the backend stays visible and the page works
 * completely.
 */
(function () {
    'use strict';

    function apply(root) {
        var currency = root.dataset.currency;
        var period = root.dataset.period;
        var tax = root.dataset.tax;

        root.querySelectorAll('.ws-pricing__price-block').forEach(function (block) {
            var prices = Array.prototype.slice.call(block.querySelectorAll('.ws-pricing__price'));

            // Not every plan has every combination. Relax step by step so that
            // no empty spot is ever left - the same order as in the presenter.
            var match =
                prices.filter(function (p) { return p.dataset.currency === currency && p.dataset.period === period && p.dataset.tax === tax; })[0] ||
                prices.filter(function (p) { return p.dataset.currency === currency && p.dataset.tax === tax; })[0] ||
                prices.filter(function (p) { return p.dataset.tax === tax; })[0] ||
                prices[0];

            prices.forEach(function (p) {
                p.classList.toggle('is-active', p === match);
            });
        });
    }

    function bind(root) {
        root.querySelectorAll('.ws-pricing__segment').forEach(function (button) {
            button.addEventListener('click', function () {
                var name = button.dataset.switch;
                var value = button.dataset.value;
                if (!name || !value) {
                    return;
                }

                root.dataset[name] = value;

                root.querySelectorAll('.ws-pricing__segment[data-switch="' + name + '"]').forEach(function (other) {
                    var active = other === button;
                    other.classList.toggle('is-active', active);
                    other.setAttribute('aria-pressed', active ? 'true' : 'false');
                });

                apply(root);
            });
        });
    }

    function init() {
        document.querySelectorAll('.ws-pricing').forEach(function (root) {
            if (root.dataset.bound === '1') {
                return;
            }
            root.dataset.bound = '1';
            bind(root);
            apply(root);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
