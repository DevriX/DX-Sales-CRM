<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * add company title popup
 *
 * This is the code for the pop up for add company, which shows up when an user clicks
 * on the plus image button on the customer edit page.
 *
 * @package CRM System
 * @since 1.0.0
 **/
?>

<div class="dx-crm-comp-popup-content">

	<div class="dx-crm-comp-header">
		<div class="dx-crm-comp-header-title"><?php esc_html_e( 'Add New Company', 'dxcrm' ); ?></div>
		<div class="dx-crm-comp-popup-close">
			<a href="javascript:void(0);" class="dx-crm-comp-close-button">
				<img src="<?php echo esc_url( DX_CRM_IMG_URL ); ?>/tb-close.png" title="<?php esc_attr_e( 'Close', 'dxcrm' ); ?>">
			</a>
		</div>
	</div>
	
	<div class="dx-crm-comp-popup">
		<div class="dx-crm-comp-add-company-title">
			<div>
				<label for="dx_crm_company_title"><?php esc_html_e( 'Enter Company Title', 'dxcrm' ); ?></label>
				<input type="text" class="dx_crm_company_title_text" name="dx_crm_company_title" id="dx_crm_company_title" size="31">
			</div>
			<div class="dx-crm-comp-title-error"><?php esc_html_e( 'Please Enter title for Company', 'dxcrm' ); ?></div>
			
			<div class="dx-crm-comp-title-success"><?php esc_html_e( 'Company Added Successfully.', 'dxcrm' ); ?></div>
			<div>
				<input type="button" 
					   class="dx_crm_add_company_button button" 
					   id="dx_crm_add_company_button" 
					   value="<?php esc_attr_e( 'Add Company', 'dxcrm' ); ?>" />		
				<input type="button" 
					   class="dx_crm_add_more_company_button button" 
					   id="dx_crm_add_more_company_button" 
					   value="<?php esc_attr_e( 'Save and Add More', 'dxcrm' ); ?>" />				
			</div>			
		</div>		
	</div><!--.edd-points-popup-->
	
</div><!--.edd-points-popup-content-->
<div class="dx-crm-comp-popup-overlay"></div>