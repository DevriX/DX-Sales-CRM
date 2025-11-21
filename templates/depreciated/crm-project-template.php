<?php
/** 
 * Template Name: DX CRM Project
 * 
 * Full width page template without sidebar
 *
 * @package CRM System
 * @since 1.0.0
*/
$prefix = DX_CRM_META_PREFIX;

/** 
 * Get initial project data
 * The rest will be pull using ajax
 *
 * @package CRM System
 * @since 1.0.0
*/
$project_types = get_terms( 'crm_pro_type' , array('hide_empty' => false) );

foreach ( $project_types as $project_type ) {
    $pro_type[$project_type->term_id] = $project_type->name;
}

/** 
 * Get initial customer dropdown data
 * The rest will be pull using ajax
 *
 * @package CRM System
 * @since 1.0.0
*/
$cust_users = get_posts( array( 'posts_per_page' => 5, 'post_type' => 'crm_customers' ) );

foreach ( $cust_users as $usr ) {
    $user_arr[$usr->ID] = $usr->post_title;
} 

/** 
 * Get theme header
 *
 * @package CRM System
 * @since 1.0.0
*/
get_header(); 

if ( is_user_logged_in() && current_user_can( 'administrator' ) ) { ?>
<div id="primary" class="site-content dx-crm-content">
	<div id="content" role="main">
		<h1><?php esc_html_e( 'Add Project' , 'dxcrm' );?></h1>
		<?php
			/** 
			 * Avoid fatal error in submitting without customer.
			 * Add friendly message on top of form with link for correction
			 * Disable form submit button
			 *
			 * @package CRM System
			 * @since 1.0.0
			*/
			$submit_button = "";
			
			if( empty ( $user_arr ) ){				
				// DISABLE SUBMIT BUTTON
				$submit_button = "disabled";
				do_action( 'dx_crm_notice', esc_html__( 'You can\'t create Project without Customer. Please notify administrator!', 'dxcrm' ) );
			}
			
			/** 
			 * Check if nonce request is submitted
			 *
			 * @package CRM System
			 * @since 1.0.0
			*/
			if( isset ( $_POST['add_project'] ) ){
				
				/** 
				 * Setup nonce
				 * Use itenary to avoid undefined index notice
				 *
				 * @package CRM System
				 * @since 1.0.0
				*/
				$nonce = isset ( $_POST['add_project'] ) && ! empty ( $_POST['add_project'] ) ? $_POST['add_project'] : '';
				
				/** 
				 * Proceed only if nonce is valid
				 *
				 * @package CRM System
				 * @since 1.0.0
				*/
				if ( ! wp_verify_nonce( $nonce, 'crm_add_project' ) ) {
					
					/** 
					 * If nonce is invalid, echo error message
					 * and stops everything from processing
					 *
					 * @package CRM System
					 * @since 1.0.0
					*/
					do_action( 'dx_crm_notice', esc_html__( 'Invalid request! Please try again', 'dxcrm' ) ); 
					
				} else {
					
					/** 
					 * Process it
					 *
					 * @package CRM System
					 * @since 1.0.0
					*/					
					$save_project = $dx_crm_public->dx_crm_save_project( $_POST );
					
					/** 
					 * Depending on what the output, chech if WP error first
					 *
					 * @package CRM System
					 * @since 1.0.0
					*/	
					if ( is_wp_error( $save_project ) ) {
					   do_action( 'dx_crm_notice', esc_html( $save_project->get_error_message() ) ); 
					} else {
						do_action( 'dx_crm_notice', esc_html( $save_project ) ); 
					}
				}
			}
		?>
		<form id="crm-customer-form" class="crm-template-form" action="" name="form1" method="POST">
			<?php wp_nonce_field( 'crm_add_project', 'add_project' ); ?>
			<fieldset>
				<legend><?php esc_html_e( 'Project Information' , 'dxcrm' );?> </legend>
				<div class="form-row">
					<div class="row-left"><label for="proj_name"><?php esc_html_e( 'Project Name' , 'dxcrm' );?></label></div>
					<div class="row-right"><input id="proj_name" type="text" name="<?php echo wp_kses_post( $prefix . 'proj_name' ); ?>" data-validation="required" data-validation-error-msg="<?php esc_html_e( 'Please provide Project Name' , 'dxcrm' ); ?>"/></div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="proj_desc"><?php esc_html_e( 'Project Description' , 'dxcrm' );?> </label></div>
					<div class="row-right"><textarea cols="15" rows="5" id="proj_desc" type="text" name="<?php echo wp_kses_post( $prefix . 'proj_desc' ); ?>" data-validation="required" data-validation-error-msg="<?php esc_html_e( 'Please provide Project Description' , 'dxcrm' ); ?>"></textarea></div>
				</div>					
				<br class="clear">
                <?php 
					/**
					 * Don't display this if Project Type is empty
					*/
					if( ! empty ( $pro_type ) ){
				?>
                        <div class="form-row">
                            <div class="row-left"><label for="proj_pro_type"><?php esc_html_e( 'Project Type' , 'dxcrm' );?> </label></div>
                            <div class="row-right">
                            <?php
                                foreach ( $pro_type as $ku => $vu ){
                                    echo '<input type="checkbox" name="' . wp_kses_post( $prefix ) . 'proj_pro_type[]" value="'.esc_attr( $ku ) .'" data-validation="checkbox_group" data-validation-qty="min1"/>'. esc_html( $vu );
                                }                                                            
                            ?>	
                            </div>
                        </div>
				<?php } ?>
				<br class="clear">
                <?php 
					/**
					 * Don't display this if Customer is empty
					*/
					if( ! empty( $user_arr ) ){
				?>
						<div class="form-row">
                            <div class="row-left"><label for="proj_assign_customer"><?php esc_html_e( 'Customers' , 'dxcrm' );?> </label></div>						
                            <div class="row-right">
                                <select id="proj_assign_customer" name="<?php echo wp_kses_post( $prefix ) ;?>proj_assign_customer"  data-validation="length required" data-validation-length="min2">   
								<?php
                                    foreach ( $user_arr as $kp => $vp ){
                                        echo '<option value="'.esc_attr( $kp ) .'">'. esc_html( $vp ) .'</option>';
                                    }
                                ?>
                                    </select>
                            </div>
                        </div>
				<?php } ?>
			</fieldset>
			<fieldset>
				<legend><?php esc_html_e( 'Project Details' , 'dxcrm' );?></legend>	
				<div class="form-row">
					<div class="row-left"><label for="proj_start_date"><?php esc_html_e( 'Start Date' , 'dxcrm' );?> </label></div>
					<div class="row-right"><input id="proj_start_date" class="add-datepicker" type="text" name="<?php echo wp_kses_post( $prefix . 'proj_start_date' ); ?>" data-validation="date" data-validation-format="dd-mm-yyyy" data-validation-error-msg="<?php esc_html_e( 'Please provide Start Date' , 'dxcrm' );?>"> </div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="proj_planned_end_date"><?php esc_html_e( 'Planned End Date' , 'dxcrm' );?> </label></div>
					<div class="row-right"><input id="proj_planned_end_date" class="add-datepicker" type="text" name="<?php echo wp_kses_post( $prefix . 'proj_planned_end_date' ); ?>" data-validation="date" data-validation-format="dd-mm-yyyy" data-validation-error-msg="<?php esc_html_e( 'Please provide Planned End Date' , 'dxcrm' );?>"> </div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="proj_milestone_end_date"><?php esc_html_e( 'Real End Date for first milestone' , 'dxcrm' );?> </label></div>
					<div class="row-right"><input id="proj_milestone_end_date" class="add-datepicker" type="text" name="<?php echo wp_kses_post( $prefix . 'proj_milestone_end_date' ); ?>" data-validation="date" data-validation-format="dd-mm-yyyy" data-validation-error-msg="<?php esc_html_e( 'Please provide Real End Date for first milestone' , 'dxcrm' );?>"></div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="proj_conversation_end_date"><?php esc_html_e( 'Real End Date for last conversation' , 'dxcrm' );?> </label></div>
					<div class="row-right"><input id="proj_conversation_end_date" class="add-datepicker" type="text" name="<?php echo wp_kses_post( $prefix . 'proj_conversation_end_date' ); ?>" data-validation="date" data-validation-format="dd-mm-yyyy" data-validation="number" data-validation-error-msg="<?php esc_html_e( 'Please provide Real End Date for last conversation' , 'dxcrm' );?>"></div>
				</div>
				<br class="clear">
				<div class="form-row">
					<div class="row-left"><label for="proj_agreed_cost"><?php esc_html_e( 'Agreed Cost' , 'dxcrm' );?> </label></div>
					<div class="row-right"><input id="proj_agreed_cost" type="text" name="<?php echo wp_kses_post( $prefix . 'proj_agreed_cost' ); ?>" data-validation="number" data-validation-allowing="float" data-validation-error-msg="<?php esc_html_e( 'Please provide cost in number or decimal format' , 'dxcrm' );?>"></div>
				</div>
				<br class="clear">					
			</fieldset>
			<div class="form-row">
				<div class="row-left"><input type="submit" name="<?php echo wp_kses_post( $prefix . add_proj ); ?>" value="Add Project" <?php echo esc_attr( $submit_button ); ?>/></div>
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