<?php

/**
 *
 * Vertical sub-menu for Project
 *
 * List all pre-defined Project Report
 *
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ){ exit; }

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo apply_filters( 'dx_crm_report_sub_menu', array() );
?>
