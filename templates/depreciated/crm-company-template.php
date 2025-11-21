<?php
/** 
 * Template Name-: DX CRM Company
 * 
 * Full width page template without sidebar
 *
 * @package CRM System
 * @since 1.0.0
*/
$prefix = DX_CRM_META_PREFIX;

/** 
 * Get initial crm customers
 * The rest will be pull using ajax
 *
 * @package CRM System
 * @since 1.0.0
*/
$cust_users = get_posts( array( 'posts_per_page' => 5, 'post_type' => 'crm_customers' ) );

if( ! empty ( $cust_users ) ){
	foreach ( $cust_users as $usr ) {
		$user_arr[$usr->ID] = $usr->post_title;
	}
}

/** 
 * Intialize CRM model global variable
 *
 * @package CRM System
 * @since 1.0.0
*/
global $dx_crm_model, $dx_crm_public;

/** 
 * Get theme header
 *
 * @package CRM System
 * @since 1.0.0
*/
get_header(); 

if ( is_user_logged_in() && current_user_can( 'administrator' ) ) { 	
?>
<div id="primary" class="site-content dx-crm-content">
	<div id="content" role="main">	
		<h1><?php esc_html_e( 'Add Company' , 'dxcrm' );?></h1>
		<?php
			/** 
			 * Check if nonce request is submitted
			 *
			 * @package CRM System
			 * @since 1.0.0
			*/
			if( isset ( $_POST['add_company'] ) ){
				
				/** 
				 * Setup nonce
				 * Use itenary to avoid undefined index notice
				 *
				 * @package CRM System
				 * @since 1.0.0
				*/
				$nonce = isset ( $_POST['add_company'] ) && ! empty ( $_POST['add_company'] ) ? $_POST['add_company'] : '';
				
				/** 
				 * Proceed only if nonce is valid
				 *
				 * @package CRM System
				 * @since 1.0.0
				*/
				if ( ! wp_verify_nonce( $nonce, 'crm_add_company' ) ) {
					
					/** 
					 * If nonce is invalid, echo error message
					 * and stops everything from processing
					 *
					 * @package CRM System
					 * @since 1.0.0
					*/
					do_action( 'dx_crm_notice', __( 'Invalid request! Please try again', 'dxcrm' ) ); 
					
				} else {
					
					/** 
					 * Process it
					 *
					 * @package CRM System
					 * @since 1.0.0
					*/					
					$save_company = $dx_crm_public->dx_crm_save_company( $_POST );
					
					/** 
					 * Depending on what the output, chech if WP error first
					 *
					 * @package CRM System
					 * @since 1.0.0
					*/	
					if ( is_wp_error( $save_company ) ) {
					   do_action( 'dx_crm_notice', $save_company->get_error_message() ); 
					} else {
						do_action( 'dx_crm_notice', $save_company ); 
					}
				}
			}
		?>
		<form id="crm-company-form" class="crm-template-form" action="" name="form1" method="POST" enctype="multipart/form-data">
			<?php wp_nonce_field( 'crm_add_company', 'add_company' ); ?>
			<fieldset>
				<legend><?php esc_html_e( 'Company Information' , 'dxcrm' );?> </legend>
				<div class="form-row">
					<div class="row-left"><label for="company_name"><?php esc_html_e( 'Company Name' , 'dxcrm' );?> </label></div>
					<div class="row-right"><input id="company_name" type="text" name="<?php echo esc_attr( $prefix . 'company_name' ); ?>" data-validation="required" data-validation-error-msg="<?php esc_html_e( 'Please provide Company Name' , 'dxcrm' );?>"/></div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="company_desc"><?php esc_html_e( 'Company Description' , 'dxcrm' );?> </label></div>
					<div class="row-right"><textarea cols="15" rows="5" id="company_desc" type="text" name="<?php echo esc_attr( $prefix . 'company_desc' ); ?>" data-validation="required" data-validation-error-msg="<?php esc_html_e( 'Please provide Company Description' , 'dxcrm' );?>"></textarea></div>
				</div>					
				<br class="clear">
			</fieldset>
			<fieldset>
				<legend><?php esc_html_e( 'Company Details' , 'dxcrm' );?></legend>	
				<div class="form-row">
					<div class="row-left"><label for="company_responsible_person"><?php esc_html_e( 'Responsible Person' , 'dxcrm' );?> </label></div>
					<div class="row-right"><input id="company_responsible_person" type="text" name="<?php echo esc_attr( $prefix . 'company_responsible_person' ); ?>" data-validation="alphanumeric" data-validation-optional="true" data-validation-error-msg="<?php esc_html_e( 'Please provide Responsible Person in Alphanumeric format!' , 'dxcrm' );?>"/></div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="company_type"><?php esc_html_e( 'Company Type' , 'dxcrm' );?> </label></div>
					<div class="row-right">
						<?php
							/** 
							 * Get company type dropdown							
							 *
							 * @package CRM System
							 * @since 1.0.0
							*/
							$company_type = $dx_crm_model->crm_company_type_dropdown( DX_CRM_META_PREFIX . 'company_type', false );
							if( is_wp_error( $company_type ) ){
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								echo sprintf( '<p class="crm-error-field">%s</p>', $company_type->get_error_message() );
							}else{
								echo esc_html( $company_type );
							}
						?>
					</div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="company_industry"><?php esc_html_e( 'Company Industry' , 'dxcrm' );?> </label></div>
					<div class="row-right">
						<?php
							/** 
							 * Get company industry dropdown							
							 *
							 * @package CRM System
							 * @since 1.0.0
							*/
							$company_industry = $dx_crm_model->crm_company_industry_dropdown( DX_CRM_META_PREFIX . 'company_industry', false );
							if( is_wp_error( $company_industry ) ){
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								echo sprintf( '<p class="crm-error-field">%s</p>', $company_industry->get_error_message() );
							}else{
								echo esc_html( $company_industry );
							}
						?>
					</div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="company_employees"><?php esc_html_e( 'Company Employees' , 'dxcrm' );?> </label></div>
					<div class="row-right">
						<?php
							/** 
							 * Get company employee dropdown							
							 *
							 * @package CRM System
							 * @since 1.0.0
							*/
							$company_employees = $dx_crm_model->crm_company_employees_dropdown( DX_CRM_META_PREFIX . 'company_employees', false );
							if( is_wp_error( $company_employees ) ){
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								echo sprintf( '<p class="crm-error-field">%s</p>', $company_employees->get_error_message() );
							}else{
								echo esc_html( $company_employees );
							}
						?>
					</div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="annual_income"><?php esc_html_e( 'Annual Income' , 'dxcrm' );?> </label></div>
					<div class="row-right"><input id="annual_income" type="text" name="<?php echo esc_attr( $prefix . 'annual_income' ); ?>" data-validation="number" data-validation-allowing="float"  data-validation-error-msg="<?php esc_html_e( 'Please provide Annual Income!' , 'dxcrm' );?>" data-validation-help="Ex: 201,123.23"/></div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="company_currency"><?php esc_html_e( 'Company Currency' , 'dxcrm' );?> </label></div>
					<div class="row-right">
						<?php
							/** 
							 * Get currency dropdown							
							 *
							 * @package CRM System
							 * @since 1.0.0
							*/
							$currency = $dx_crm_model->crm_currency_dropdown( DX_CRM_META_PREFIX . 'company_currency', false );
							if( is_wp_error( $currency ) ){
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								echo sprintf( '<p class="crm-error-field">%s</p>', $currency->get_error_message() );
							}else{
								echo esc_html( $currency );
							}
						?>
					</div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="company_url"><?php esc_html_e( 'Company URL' , 'dxcrm' );?> </label></div>
					<div class="row-right"><input id="company_url" type="text" name="<?php echo esc_attr( $prefix . 'company_url' ); ?>" data-validation="url" data-validation-error-msg="<?php esc_html_e( 'Please provide correct URL format. Ex: httt://www.yoursite.com' , 'dxcrm' );?>" data-validation-optional="true"/></div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="company_assign_customer"><?php esc_html_e( 'Customers' , 'dxcrm' );?> </label></div>						
					<div class="row-right">
						<?php
							if( ! empty ( $user_arr ) ){
								echo '<select id="company_assign_customer" name="' . esc_attr( $prefix . 'company_assign_customer' ) . '">'; 																	
									foreach ( $user_arr as $kp => $vp ){
										echo '<option value="' . esc_attr( $kp ) . '">' . esc_html( $vp ) . '</option>';
									}								
								echo '</select>';
							} else {
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								echo sprintf( '<p class="crm-error-field">%s</p>', esc_html__( "Please add customer first!" , "dxcrm" ) );
							}
						?>
					</div>
				</div>
			</fieldset>
			<div class="form-row">
				<div class="row-left"><input id="submit-company" type="submit" name="<?php echo esc_attr( $prefix . 'add_company' ); ?>" value="Add Company" /></div>
			</div>
			<br class="clear">
		</form>
	</div><!-- #content -->
</div><!-- #primary -->
	<?php 
} else {
    echo sprintf( esc_html__( 'Please <a href="%s">log in</a> with admin user to add project', 'dxcrm' ), esc_url( wp_login_url() ) );
}

/** 
 * Get theme footer
 *
 * @package CRM System
 * @since 1.0.0
*/ 
get_footer(); 
?>