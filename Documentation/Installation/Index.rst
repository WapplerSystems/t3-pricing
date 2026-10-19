..  _installation:

============
Installation
============

..  _requirements:

Requirements
============

*   TYPO3 14
*   PHP 8.2 or newer
*   Recommended: the PHP extension :php:`intl`, for locale-aware number
    formats. Without it, amounts use the German format ("1.499,50").

..  _install-composer:

Install with Composer
=====================

..  code-block:: bash

    composer require wapplersystems/t3-pricing

Then update the database schema, for example with

..  code-block:: bash

    vendor/bin/typo3 extension:setup -e pricing

..  _install-site-set:

Add the site set
================

Add the site set :yaml:`wapplersystems/pricing` to the dependencies of your
site, either in the backend (:guilabel:`Site Management > Sites > Edit site >
Sets`) or directly in :file:`config/sites/<site>/config.yaml`:

..  code-block:: yaml
    :caption: config/sites/<site>/config.yaml

    dependencies:
      - wapplersystems/pricing

The set registers the template paths, the stylesheet and the script. No static
TypoScript include is needed.

..  _install-classic:

Classic mode (without Composer)
===============================

Install the extension from the TYPO3 Extension Repository with the Extension
Manager, then add the site set as described above.
