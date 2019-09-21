<?php

if( ! class_exists( 'Arya_Multipurpose_Sidebar_Custom_Field' ) ) {

	class Arya_Multipurpose_Sidebar_Custom_Field {

		public function __construct() {

			$this->init();
		}

		public function init() {

			add_action( 'admin_init', array( $this, 'register_post_meta' ) );
			add_action( 'save_post', array( $this, 'save_sidebar_position_meta' ) );
		}

		public function register_post_meta() {   

		    add_meta_box( 'sidebar_position_metabox', esc_html__( 'Sidebar Position', 'arya-multipurpose' ), array( $this, 'sidebar_position_template' ), array( 'post', 'page' ), 'side', 'default' );
		}

		
		public function sidebar_position_template() {

			$sidebar = get_post_meta( get_the_ID(), 'arya_multipurpose_sidebar_position', true );

			if( empty( $sidebar ) ) {
				$sidebar = 'right';
			}

		    wp_nonce_field( 'arya_multipurpose_sidebar_position_meta_nonce', 'arya_multipurpose_sidebar_position_meta_nonce_id' );

		    $sidebar_positions = array(
		        'right' => esc_html__( 'Right', 'arya-multipurpose' ),
		        'left' => esc_html__( 'Left', 'arya-multipurpose' ),
		        'none' => esc_html__( 'None', 'arya-multipurpose' ),
		    );

		    ?>

		    <table width="100%" border="0" class="options" cellspacing="5" cellpadding="5">
		        <tr>
		            <?php
		                foreach( $sidebar_positions as $key => $option ) {
		                    ?>
		                    <td width="10%">
		                        <input type="radio" name="sidebar_position" id="sidebar_position" value="<?php echo esc_attr( $key ); ?>" <?php if( $sidebar == $key ) { esc_attr_e( 'checked', 'arya-multipurpose' ); } ?>><label><?php echo esc_html( $option ); ?></label>               
		                    </td>  
		                    <?php
		                }
		            ?>        
		        </tr> 
		    </table>   
		    <?php   
		}

		public function save_sidebar_position_meta() {

		    global $post;  

		    // Bail if we're doing an auto save
		    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		        return;
		    }
		    
		    // if our nonce isn't there, or we can't verify it, bail
		    if( !isset( $_POST['arya_multipurpose_sidebar_position_meta_nonce_id'] ) || !wp_verify_nonce( sanitize_key( $_POST['arya_multipurpose_sidebar_position_meta_nonce_id'] ), 'arya_multipurpose_sidebar_position_meta_nonce' ) ) {
		        return;
		    }
		    
		    // if our current user can't edit this post, bail
		    if ( ! current_user_can( 'edit_post', get_the_ID() ) ) {
		        return;
		    } 

		    if( isset( $_POST['sidebar_position'] ) ) {
				update_post_meta( get_the_ID(), 'arya_multipurpose_sidebar_position', sanitize_text_field( wp_unslash( $_POST['sidebar_position'] ) ) ); 
			}
		}
	}
}

$sidebar_custom_field = new Arya_Multipurpose_Sidebar_Custom_Field();