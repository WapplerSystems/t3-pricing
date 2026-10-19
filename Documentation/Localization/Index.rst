..  _localization:

============
Localization
============

..  _localization-labels:

Labels
======

Backend and frontend labels ship in English and 36 further European
languages:

Albanian, Basque, Bosnian, Bulgarian, Catalan, Croatian, Czech, Danish, Dutch,
Estonian, Finnish, French, Galician, German, Greek, Hungarian, Icelandic, Irish,
Italian, Latvian, Lithuanian, Luxembourgish, Macedonian, Maltese, Norwegian,
Polish, Portuguese, Romanian, Russian, Serbian, Slovak, Slovenian, Spanish,
Swedish, Turkish, Ukrainian.

Frontend texts such as "per month", "excl. VAT" or "Price on request" follow
the language of the page. Corrections are welcome as a pull request on
`GitHub <https://github.com/WapplerSystems/t3-pricing>`__.

To change a single label for your site, override it in your site package:

..  code-block:: php
    :caption: EXT:my_sitepackage/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['de']
        ['EXT:pricing/Resources/Private/Language/locallang.xlf'][]
        = 'EXT:my_sitepackage/Resources/Private/Language/Overrides/de.pricing.xlf';

..  _localization-records:

Translating pricing tables
==========================

All records of a pricing table are translatable. Translate the pricing table
in the :guilabel:`List` module; its plans, prices, feature groups, features and
values are translated along with it.

What stays tied to the default language:

*   Amount, currency, billing period and "price on request" of a price.
*   The feature and the "included" check of a value.

Changes to these fields in the default language are synchronised to all
translations. Texts are translated: names, descriptions, badges, button
labels, notes, own units and text values such as "unlimited".

..  _localization-numbers:

Number formats
==============

Thousands and decimal separators follow the locale of the site language:
"1,499.50" in English, "1.499,50" in German, "1 499,50" in French. This needs
the PHP extension :php:`intl`.

Where the currency symbol goes ("€ 99" or "99 €") is a setting of the pricing
table, tab :guilabel:`Prices`.
