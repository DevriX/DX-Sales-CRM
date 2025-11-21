<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * CRM Document Management Setting Page
 * 
 * 
 * @package CRM System - Document Management
 * @since 1.0.0
 */

$dx_crm_options = get_option( 'dx_crm_options' );

//check if DM folder is created already
$wp_root_path = get_home_path();
$dm_dir_exists = file_exists( $wp_root_path . DX_CRM_DM_UPLOADS_DIRECTORY );

?>
<!-- beginning of the dm settings meta box -->	
<div class="post-box-container">

	<div class="metabox-holder">	

		<div class="meta-box-sortables ui-sortable">

			<div id="dm-settings" class="postbox">	

				<div title="Click to toggle" class="handlediv"><br></div>
				<h3 class="hndle"><span><?php esc_html_e( 'Document Management Settings', 'dxcrmdm' ); ?></span></h3>
							
				<div class="inside">
					<table class="form-table">						
						<tbody>
							<tr>
								<th scope="row">
									<label><strong><?php esc_html_e( 'Uploads Folder:', 'dxcrmdm' );?></strong></label>
								</th>
								<td>
									
									<div id="crm_dm_dir_exists"
									<?php if(!$dm_dir_exists) { ?>
										style="display: none;"
									<?php } ?>
									><p>
										Document Management folder is at: <i>
										<?php
											print esc_html( $wp_root_path . DX_CRM_DM_UPLOADS_DIRECTORY );
										?>
									</i></p></div>
									
									<div  id="crm_dm_dir_none"
									<?php if($dm_dir_exists) { ?>
										style="display: none;"
									<?php } ?>
									>
										<p><?php esc_html_e( 'There is no Document Management folder yet.', 'dxcrmdm' ); ?></p>
										<br />
										<button type="button" class="button-primary crm-dm-create-dir-button"> 
											<?php esc_html_e( 'Create DM folder', 'dxcrmdm' ); ?>
										</button>
									</div>
									
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label><strong><?php esc_html_e( 'Allowed file types:', 'dxcrmdm' );?></strong></label>
								</th>
								<td>
									<input type="text" id="dx_crm_dm_allowed_file_types" name="dx_crm_options[dm_allowed_file_types]" value="<?php echo esc_attr( $dx_crm_options['dm_allowed_file_types'] ); ?>" class="large-text"/><br />
									<span class="description"><?php esc_html_e( 'Enter allowed file types, separated by comma.', 'dxcrmdm' );?></span>
								</td>
							</tr>							
							<tr>
								<td colspan="2">
									<div style="text-align: right;"><input type="submit" class="button-primary" name="dx_crm_settings_save" value="<?php esc_attr_e( 'Save Changes', 'dxcrmdm' ); ?>" /></div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div><!-- #dm-settings -->

		</div><!-- .meta-box-sortables ui-sortable -->

	</div><!-- .metabox-holder -->

</div><!-- #sfc-dm-settings -->	
<!-- end of the dm settings meta box -->