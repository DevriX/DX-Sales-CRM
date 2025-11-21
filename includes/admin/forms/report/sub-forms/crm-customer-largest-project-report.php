<?php

/**
 *
 * By Largest Project Form
 *
 * Generate Report by largest project
 * Largest number of projects by client (partners who brought multiple projects)
 *
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ){ exit; }

?>
<p><?php esc_html_e( 'Customer report with most project.' , 'dxcrm' ); ?></p>
<form action="" method="post" id="crm-customer-form" class="form-dx-crm-report">
	
	<?php 
		/* Determine what type of report we are going to generate */
	?>
	<input type="hidden" name="dx_crm_report" value="customer">
	<input type="hidden" name="dx_crm_report_type" value="largest-project">
	
	<table border="0" class="aligncenter" width="100%" id="dx-crm-report-table">		
		<tr>
		
			<td><?php esc_html_e( 'Total Project' , 'dxcrm' ); ?>:</td>
			<td>
				<select name="total_project" class="chosen-select">
					<option value="DESC"><?php esc_html_e( 'DESC' , 'dxcrm' ); ?></option>
					<option value="ASC"><?php esc_html_e( 'ASC' , 'dxcrm' ); ?></option>
				</select>
			</td>
			
		</tr>
	</table>

	<?php wp_nonce_field( 'report-customer-nonce', 'customer-nonce-report' );	?>

	<input type="submit" class="button button-primary" name="submit" value="<?php esc_html_e( 'Generate Report' , 'dxcrm' ); ?>" />
	
</form>