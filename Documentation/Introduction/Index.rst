..  _introduction:

============
Introduction
============

..  _what-it-does:

What does it do?
================

Pricing pages repeat the same information in different shapes: a few plan cards
at the top, a detailed comparison further down, maybe a compact list on a
landing page. This extension keeps that information in **one record** and
renders it in five layouts. Change a price once, and every layout on every page
shows the new value.

..  _features:

Features
========

Five layouts, one data model
    Plan cards, a comparison table, cards with feature groups, compact rows and
    cards with expandable details. The comparison table can be attached below
    any other layout, open or collapsed.

Features belong to the table, not to the plan
    Every row of the comparison table asks all plans the same question. A plan
    without a value shows a dash — editors do not have to fill every cell.

Switches without page reload
    Currency, billing period and net/gross. All combinations are in the
    markup and the active one is visible, so the page stays fully cacheable.
    Each switch only appears when there is something to choose.

Prices per currency, not converted
    Exchange rates go stale and list prices are rounded marketing figures, so
    every currency is entered on its own. Only net is converted to gross, using
    the tax rate of the table.

Graceful fallbacks
    If a plan lacks the chosen combination — a one-off product has no yearly
    price — the extension relaxes step by step: exact combination, same
    currency, first price. There is never an empty spot.

Highlighted plan
    Border and shadow in the accent colour, a tinted column in the comparison
    table and an optional badge such as "Popular".

No dead buttons
    A plan without a link gets no button — no empty one, no placeholder. The
    label comes from the table and can be overridden per plan.

Currency symbol before or after the amount
    "€ 99" or "99 €", chosen per table. Thousands and decimal separators follow
    the locale of the site language.

Responsive by container, not by viewport
    Layouts adapt to the width of their content column. Four plans wrap as two
    by two, five as three plus two — never as "three plus one lonely card".

Accessible
    The comparison table is a real :html:`<table>` with scope attributes,
    checks and dashes carry screen-reader text, switches are buttons with
    :html:`aria-pressed`, and on narrow screens the table scrolls inside its own
    region with a sticky feature column.

Easy to brand
    All colours, radii and spacing are CSS custom properties on one class.

Translated
    Backend and frontend labels in 37 European languages.

..  _screenshots:

Screenshots
===========

..  figure:: /Images/Cards.png
    :alt: Plan cards

    **Plan cards** — the standard layout for two to five plans.

..  figure:: /Images/CardsSwitched.png
    :alt: Plan cards showing US dollar, yearly, gross prices

    The same cards after switching to **USD, yearly, incl. VAT** — no reload.

..  figure:: /Images/Matrix.png
    :alt: Comparison table with feature groups, checks and values

    **Comparison table** — many plans, many features, grouped, with checks,
    numbers, text and percent values.

..  figure:: /Images/Groups.png
    :alt: Plan cards with named feature groups

    **Cards with feature groups** — for plans that carry more than one list.

..  figure:: /Images/Rows.png
    :alt: One row per plan with three key figures

    **Compact rows** — one row per plan with key figures, useful from about
    five plans on.

..  figure:: /Images/Accordion.png
    :alt: Plan cards with an expanded details section

    **Cards with expandable details** — decision first, details on demand.

..  figure:: /Images/MatrixMobile.png
    :alt: Comparison table on a phone, scrolled sideways
    :width: 400px

    On a phone the comparison table scrolls sideways while the feature column
    and the group titles stay in place.
