..  _editor:

===========
For editors
===========

A pricing table is a record that holds everything: plans, their prices, the
features and their values. The content element "Pricing table" only decides
which table is shown and in which layout. The same table can therefore appear
on several pages in different layouts.

..  _editor-structure:

How the data is organised
=========================

..  code-block:: text

    Pricing table
    ├── Plan ─── Price    (one per currency and period)
    │        └── Value    (one per feature)
    └── Feature group
             └── Feature

..  _editor-create-table:

Create a pricing table
======================

#.  Open the :guilabel:`List` module on a folder or page of your choice.
#.  Create a new record of type :guilabel:`Pricing table`.
#.  Tab :guilabel:`General`: a title (only shown in the backend) and an
    optional introductory note, shown above the prices in every layout —
    for example "All prices per month, plus VAT."
#.  Tab :guilabel:`Prices`: decide how amounts are read and which switches
    visitors get (see :ref:`editor-prices`).

..  _editor-plans:

Plans
=====

Tab :guilabel:`Plans`. Each plan has

Name, subtitle, eyebrow
    The subtitle is one line below the name ("For small teams"), the eyebrow a
    small line above it ("Most chosen").

Description
    A short text shown on cards.

Highlight and badge
    Highlight one plan to give it the accent border, shadow and a tinted
    column in the comparison table. The badge text ("Popular") is optional.

Select button
    Link target and, if needed, an own label. Without a link no button is
    rendered.

Note below the price
    For example "billed annually" or "14 days free".

Prices
    One price per currency and billing period: per month, per year, one-time
    or a custom unit such as "per user". Tick :guilabel:`Price on request` to
    show a text instead of an amount.

Feature values
    The value of this plan for each feature, see below.

..  _editor-features:

Feature groups and features
===========================

Tab :guilabel:`Features`. Features are grouped, for example "Usage",
"Features", "Support".

Group layout
    :guilabel:`Checklist` for yes/no features, :guilabel:`Value pairs` for
    details such as quotas or fees.

Show on cards / show in comparison table
    Some groups belong in the comparison table only and would overload a
    card.

Feature value type
    :guilabel:`Check or dash`, :guilabel:`Number`, :guilabel:`Text` or
    :guilabel:`Percent`. An optional unit ("GB", "users") follows the value,
    an optional footnote appears in small print in the comparison table.

Values are entered on the plan. A feature without a value counts as not
included and shows a dash.

..  _editor-prices:

Tax, currencies and switches
============================

Tab :guilabel:`Prices` of the pricing table:

Entered amounts are
    Net or gross prices. With net prices and a tax rate, gross prices are
    calculated; there is no conversion the other way round.

Visitors may switch between net and gross
    Shows the "excl. VAT / incl. VAT" switch.

Currency switchable, billing period switchable
    The switch only appears if the plans actually have more than one currency
    or period.

Currency symbol
    Before ("€ 99") or after ("99 €") the amount.

Button label
    Default label of all select buttons, e.g. "Choose plan".

..  _editor-plugin:

Place the content element
=========================

#.  Add a new content element :guilabel:`Pricing table` (wizard tab
    :guilabel:`Plugins`).
#.  Tab :guilabel:`Plugin`: select the pricing table record.
#.  Choose the layout:

    ======================================  ======================================
    Layout                                  Use it for
    ======================================  ======================================
    Plan cards                              Two to five plans, one feature list
    Comparison table                        Many plans, many features
    Cards with feature groups               Plans with several named lists
    Compact rows                            From about five plans on
    Cards with expandable details           Decision first, details on demand
    ======================================  ======================================

#.  Optionally attach the comparison table below the chosen layout, open or
    collapsed.
