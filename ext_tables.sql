#
# Pricing table: the bracket around plans and features
#
CREATE TABLE tx_pricing_domain_model_table (
    title varchar(255) DEFAULT '' NOT NULL,
    description text,
    tax_mode varchar(20) DEFAULT 'net' NOT NULL,
    tax_rate decimal(5,2) DEFAULT '0.00' NOT NULL,
    tax_switchable smallint(5) unsigned DEFAULT '0' NOT NULL,
    currency_switchable smallint(5) unsigned DEFAULT '0' NOT NULL,
    period_switchable smallint(5) unsigned DEFAULT '0' NOT NULL,
    select_label varchar(120) DEFAULT '' NOT NULL,
    currency_position varchar(10) DEFAULT 'before' NOT NULL,
    plans int(11) unsigned DEFAULT '0' NOT NULL,
    groups int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Plan
#
CREATE TABLE tx_pricing_domain_model_plan (
    pricing_table int(11) unsigned DEFAULT '0' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    subtitle varchar(255) DEFAULT '' NOT NULL,
    description text,
    eyebrow varchar(120) DEFAULT '' NOT NULL,
    favourite smallint(5) unsigned DEFAULT '0' NOT NULL,
    badge varchar(60) DEFAULT '' NOT NULL,
    select_link varchar(1024) DEFAULT '' NOT NULL,
    select_label varchar(120) DEFAULT '' NOT NULL,
    price_note varchar(255) DEFAULT '' NOT NULL,
    prices int(11) unsigned DEFAULT '0' NOT NULL,
    attribute_values int(11) unsigned DEFAULT '0' NOT NULL,

    KEY pricing_table (pricing_table)
);

#
# Price: exactly one per plan, currency and period
#
CREATE TABLE tx_pricing_domain_model_price (
    plan int(11) unsigned DEFAULT '0' NOT NULL,
    currency varchar(3) DEFAULT 'EUR' NOT NULL,
    period varchar(20) DEFAULT 'month' NOT NULL,
    amount decimal(12,2) DEFAULT '0.00' NOT NULL,
    unit_label varchar(120) DEFAULT '' NOT NULL,
    on_request smallint(5) unsigned DEFAULT '0' NOT NULL,
    on_request_label varchar(120) DEFAULT '' NOT NULL,

    KEY plan (plan)
);

#
# Feature group
#
CREATE TABLE tx_pricing_domain_model_group (
    pricing_table int(11) unsigned DEFAULT '0' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    layout varchar(20) DEFAULT 'list' NOT NULL,
    in_card smallint(5) unsigned DEFAULT '1' NOT NULL,
    in_matrix smallint(5) unsigned DEFAULT '1' NOT NULL,
    attributes int(11) unsigned DEFAULT '0' NOT NULL,

    KEY pricing_table (pricing_table)
);

#
# Feature
#
CREATE TABLE tx_pricing_domain_model_attribute (
    attribute_group int(11) unsigned DEFAULT '0' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    value_type varchar(20) DEFAULT 'check' NOT NULL,
    unit varchar(40) DEFAULT '' NOT NULL,
    footnote varchar(255) DEFAULT '' NOT NULL,

    KEY attribute_group (attribute_group)
);

#
# Value: exactly one per plan and feature
#
CREATE TABLE tx_pricing_domain_model_value (
    plan int(11) unsigned DEFAULT '0' NOT NULL,
    attribute int(11) unsigned DEFAULT '0' NOT NULL,
    included smallint(5) unsigned DEFAULT '0' NOT NULL,
    value varchar(255) DEFAULT '' NOT NULL,

    KEY plan (plan),
    KEY attribute (attribute)
);
