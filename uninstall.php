<?php

// if uninstall is not initiated by WordPress, do nothing
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

// otherwise...

// delete options from options table
delete_option('guilro_petitions_options');
delete_option('guilro_petitions_version');

// set variables for accessing database
global $wpdb;
$guilro_petitions_db_petitions = $wpdb->prefix.'guilro_petitions_petitions';
$guilro_petitions_db_signatures = $wpdb->prefix.'guilro_petitions_signatures';
$db_options = $wpdb->prefix.'options';

// delete any remaining transients

// get ids for all existing petitions
$sql_petition_ids = "SELECT id FROM $guilro_petitions_db_petitions";
$petitions = $wpdb->get_results($sql_petition_ids);

// loop through petitions and delete associated transients
foreach ($petitions as $petition) {
    // construct transient names
    $transient_petition = 'guilro_petitions_petition_'.$petition->id;
    $transient_signatureslist = 'guilro_petitions_signatureslist_'.$petition->id;
    $transient_signatures_total = 'guilro_petitions_signatures_total_'.$petition->id;

    // delete transients
    delete_transient($transient_petition);
    delete_transient($transient_signatureslist);
    delete_transient($transient_signatures_total);
}

// delete widget data
$sql_widget = "DELETE FROM $db_options WHERE option_name = 'widget_guilro_petitions_petition_widget'";
$wpdb->query($sql_widget);

// delete custom database tables
$sql_petitions_table = "DROP TABLE $guilro_petitions_db_petitions";
$wpdb->query($sql_petitions_table);

$sql_signatures_table = "DROP TABLE $guilro_petitions_db_signatures";
$wpdb->query($sql_signatures_table);

// delete WPML strings
if (function_exists('icl_unregister_string')) {
    // delete petition strings in WPML
    foreach ($petitions as $petition) {
        $context = 'Petition '.$petition->id;

        icl_unregister_string($context, 'petition title');
        icl_unregister_string($context, 'email subject');
        icl_unregister_string($context, 'greeting');
        icl_unregister_string($context, 'petition message');
        icl_unregister_string($context, 'custom field label');
        icl_unregister_string($context, 'twitter message');
        icl_unregister_string($context, 'optin label');
    }

    // delete widget strings in WPML
    foreach ($petitions as $petition) {
        $context = 'Petition '.$petition->id;

        icl_unregister_string($context, 'widget title');
        icl_unregister_string($context, 'widget call to action');
    }

    // delete options strings in WPML
    icl_unregister_string('Petition', 'submit button text');
    icl_unregister_string('Petition', 'success message');
    icl_unregister_string('Petition', 'share message');
    icl_unregister_string('Petition', 'expiration message');
    icl_unregister_string('Petition', 'already signed message');
    icl_unregister_string('Petition', 'signaturelist title');
    icl_unregister_string('Petition', 'confirmation email subject');
    icl_unregister_string('Petition', 'confirmation email message');
}
