..  _start:

==============
Pricing tables
==============

:Extension key:
    pricing

:Package name:
    wapplersystems/t3-pricing

:Version:
    |release|

:Language:
    en

:Author:
    Sven Wappler, WapplerSystems

:License:
    This document is published under the
    `Creative Commons BY 4.0 <https://creativecommons.org/licenses/by/4.0/>`__
    license.

:Rendered:
    |today|

----

Plan cards, a comparison table and compact rows — all from one record.
Editors maintain plans, prices and features once; the content element decides
how they are shown. Visitors switch currency, billing period and net/gross
prices right in the browser, without a page reload and without breaking the
page cache.

..  figure:: /Images/Cards.png
    :alt: Four plan cards with currency, billing and VAT switches, the
          third plan highlighted with a "Popular" badge

    Plan cards with switches, a highlighted plan and the comparison table
    attached below (collapsed).

----

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Introduction <introduction>`

        Five layouts, switches, highlighting, accessibility — what the
        extension does and how it looks.

    ..  card:: :ref:`Installation <installation>`

        Composer, site set, database — up and running in three steps.

    ..  card:: :ref:`For editors <editor>`

        Create a pricing table, add plans, prices and features, place the
        content element.

    ..  card:: :ref:`Configuration <configuration>`

        Brand colours via CSS custom properties, template overrides, tax and
        currency options.

    ..  card:: :ref:`Localization <localization>`

        Labels in 37 languages, number formats per site language.

..  toctree::
    :maxdepth: 2
    :titlesonly:
    :hidden:

    Introduction/Index
    Installation/Index
    Editor/Index
    Configuration/Index
    Localization/Index
