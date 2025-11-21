<?php

/**
 *
 * General Form
 *
 * Generate Report by general field
 *
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ){ exit; }

?>
<form action="" method="post" id="crm-customer-form" class="form-dx-crm-report">
	
	<?php 
		/* Determine what type of report we are going to generate */
	?>
	<input type="hidden" name="dx_crm_report" value="customer">
	<input type="hidden" name="dx_crm_report_type" value="general">
	
	<table border="0" class="aligncenter" width="100%" id="dx-crm-report-table">		
		<tr>
		
			<td><?php esc_html_e( 'Contact Date' , 'dxcrm' ); ?>:</td>
			<td><input type="text" id="contact_date" name="contact_date" class="add-datepicker"></td>
			
			<td><?php esc_html_e( 'Contact Type' , 'dxcrm' ); ?>:</td>
			<td><?php 
			// We already escaped it on crm_contact_type_dropdown
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $dx_crm_model->crm_contact_type_dropdown('contact_type', false); ?></td>
			
		</tr>
		<tr>
		
			<td><?php esc_html_e( 'Company' , 'dxcrm' );?>:</td>
			<td><?php 
			// We already escaped it on crm_company_dropdown
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $dx_crm_model->crm_company_dropdown(); ?></td>
			
			<td><?php esc_html_e( '1st Project Type' , 'dxcrm' );?>:</td>
			<td><?php 
			// We already escaped it on crm_project_type_dropdown
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $dx_crm_model->crm_project_type_dropdown('project_type', false); ?></td>
			
		</tr>
		<tr>
		
			<td><?php esc_html_e( 'Project' , 'dxcrm' );?>:</td>
			<td><?php 
			// We already escaped it on crm_project_dropdown
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $dx_crm_model->crm_project_dropdown(); ?></td>
		</tr>
	</table>

	<?php wp_nonce_field( 'report-customer-nonce', 'customer-nonce-report' );	?>

	<input type="submit" class="button button-primary" name="submit" value="<?php esc_html_e( 'Generate Report' , 'dxcrm' ); ?>" />
	
</form>