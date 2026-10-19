..  _configuration:

=============
Configuration
=============

..  _configuration-colours:

Brand colours and shapes
========================

All colours, radii and spacing are CSS custom properties on the class
:css:`.ws-pricing`. Override them in your site package to restyle every layout
at once — no selectors of the extension need to be copied.

..  code-block:: css
    :caption: EXT:my_sitepackage/Resources/Public/Css/pricing.css

    body .ws-pricing {
        --ws-pricing-accent: #0f5e6e;
        --ws-pricing-accent-soft: #e7f0f1;
        --ws-pricing-radius: 10px;
    }

The :css:`body` prefix makes sure your values win regardless of the order in
which the stylesheets are included.

..  list-table:: Custom properties
    :header-rows: 1
    :widths: 35 65

    *   -   Property
        -   Used for
    *   -   :css:`--ws-pricing-accent`
        -   Accent: highlighted plan, checks, primary button, badge
    *   -   :css:`--ws-pricing-accent-contrast`
        -   Text on the accent colour
    *   -   :css:`--ws-pricing-accent-soft`
        -   Light tint of the accent: highlighted column and value box
    *   -   :css:`--ws-pricing-text`
        -   Main text colour
    *   -   :css:`--ws-pricing-text-muted`
        -   Secondary text: descriptions, units
    *   -   :css:`--ws-pricing-text-subtle`
        -   Small print: price notes, footnotes
    *   -   :css:`--ws-pricing-text-faint`
        -   Labels of key figures in compact rows
    *   -   :css:`--ws-pricing-line`, :css:`--ws-pricing-line-soft`
        -   Borders and dividers
    *   -   :css:`--ws-pricing-surface`
        -   Card and table background
    *   -   :css:`--ws-pricing-surface-alt`
        -   Group rows of the comparison table
    *   -   :css:`--ws-pricing-box`
        -   Box of value pairs on cards
    *   -   :css:`--ws-pricing-switch-bg`
        -   Background of the switches
    *   -   :css:`--ws-pricing-button-border`
        -   Border of secondary buttons
    *   -   :css:`--ws-pricing-head-bg`
        -   Head of the comparison table, highlighted row
    *   -   :css:`--ws-pricing-zebra`
        -   Every second row of the comparison table
    *   -   :css:`--ws-pricing-dash`
        -   The dash for "not included"
    *   -   :css:`--ws-pricing-radius`, :css:`--ws-pricing-radius-small`
        -   Corner radius of cards and of buttons/boxes
    *   -   :css:`--ws-pricing-gap`
        -   Gap between cards

..  note::
    Check the contrast of small print after changing colours. Price notes are
    set at 12 px and need a contrast ratio of at least 4.5:1 against the card.

..  _configuration-templates:

Overriding templates
====================

The templates are Fluid files registered under :typoscript:`plugin.tx_pricing.view`.
Add your own paths with a higher key:

..  code-block:: typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/MySet/setup.typoscript

    plugin.tx_pricing.view {
        templateRootPaths.20 = EXT:my_sitepackage/Resources/Private/Pricing/Templates/
        partialRootPaths.20 = EXT:my_sitepackage/Resources/Private/Pricing/Partials/
    }

Each layout is one partial in :file:`Partials/Layout/`; prices, feature
lists and buttons are shared partials in :file:`Partials/Plan/`.

..  _configuration-assets:

Stylesheet and script
=====================

The site set includes

*   :file:`EXT:pricing/Resources/Public/Css/pricing.css` via
    :typoscript:`page.includeCSS.tx_pricing` and
*   :file:`EXT:pricing/Resources/Public/JavaScript/pricing.js` via
    :typoscript:`page.includeJSFooter.tx_pricing` (deferred).

To bundle the stylesheet into your own build, unset the include and import the
file there:

..  code-block:: typoscript

    page.includeCSS.tx_pricing >

The script has no dependencies. Without JavaScript, the combination chosen as
default (first currency, first period, tax mode of the table) stays visible.

..  _configuration-caching:

Caching
=======

The plugin is fully cacheable. The switches do not send requests; all
combinations are rendered into the markup and toggled with CSS classes.
