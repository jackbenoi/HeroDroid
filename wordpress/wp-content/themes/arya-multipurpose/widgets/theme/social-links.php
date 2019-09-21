<?php

class Arya_Multipurpose_Social_Widget extends WP_Widget {
 
    function __construct() { 

        parent::__construct(
            'arya-multipurpose-social-widget',  // Base ID
            esc_html__( 'AM: Social Widget', 'arya-multipurpose' ),   // Name
            array(
                'classname' => 'social-widget',
                'description' => esc_html__( 'Displays links of social sites.', 'arya-multipurpose' ), 
            )
        );
 
    }
 
    public function widget( $args, $instance ) {

        $title          = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $facebook       = ! empty( $instance['facebook'] ) ? $instance['facebook'] : '';
        $twitter        = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
        $google_plus    = ! empty( $instance['google_plus'] ) ? $instance['google_plus'] : '';
        $instagram      = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
        $linkedin       = ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';	
        
        echo $args['before_widget'];
        if( !empty( $title ) ) {
            echo $args['before_title'];
            echo esc_html( $title );
            echo $args['after_title'];
        }
        ?>
        <ul>
            <?php
            if( !empty( $facebook ) ) {
                ?>
                <li>
                    <a target="_blank" href="<?php echo esc_html( $facebook ); ?>">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
                <?php
            }
            if( !empty( $twitter ) ) {
                ?>
                <li>
                    <a target="_blank" href="<?php echo esc_html( $twitter ); ?>">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <?php
            }
            if( !empty( $google_plus ) ) {
                ?>
                <li>
                    <a target="_blank" href="<?php echo esc_html( $google_plus ); ?>">
                        <i class="fa fa-google-plus"></i>
                    </a>
                </li>
                <?php
            }
            if( !empty( $instagram ) ) {
                ?>
                <li>
                    <a target="_blank" href="<?php echo esc_html( $instagram ); ?>">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                </li>
                <?php
            }
            if( !empty( $linkedin ) ) {
                ?>
                <li>
                    <a target="_blank" href="<?php echo esc_html( $linkedin ); ?>">
                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php        
        echo $args['after_widget'];	 
    }
 
    public function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, 
            array(
                'title'         => '',
                'facebook'      => '',
                'twitter'       => '',
                'google_plus'   => '',
                'instagram'     => '',
                'linkedin'      => '',
            ) 
        );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <strong><?php esc_html_e( 'Title: ', 'arya-multipurpose' ); ?></strong>
            </label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>">
                <strong><?php esc_html_e( 'Facebook Link:', 'arya-multipurpose' ); ?></strong>
            </label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" value="<?php echo esc_attr( $instance['facebook'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>">
                <strong><?php esc_html_e( 'Twitter Link:', 'arya-multipurpose' ); ?></strong>
            </label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" value="<?php echo esc_attr( $instance['twitter'] ); ?>">
        </p> 

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'google_plus' ) ); ?>">
                <strong><?php esc_html_e( 'Google Plus Link:', 'arya-multipurpose' ); ?></strong>
            </label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'google_plus' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'google_plus' ) ); ?>" value="<?php echo esc_attr( $instance['google_plus'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>">
                <strong><?php esc_html_e( 'Instagram Link:', 'arya-multipurpose' ); ?></strong>
            </label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" value="<?php echo esc_attr( $instance['instagram'] ); ?>">
        </p> 

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>">
                <strong><?php esc_html_e( 'linkedin Link:', 'arya-multipurpose' ); ?></strong>
            </label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" value="<?php echo esc_attr( $instance['linkedin'] ); ?>">
        </p>        
		<?php
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = $old_instance;

        $instance[ 'title' ]        = sanitize_text_field( $new_instance[ 'title' ] );

        $instance[ 'facebook' ]     = esc_url_raw( $new_instance[ 'facebook' ] );

        $instance[ 'twitter' ]      = esc_url_raw( $new_instance[ 'twitter' ] );

        $instance[ 'google_plus' ]  = esc_url_raw( $new_instance[ 'google_plus' ] );

        $instance[ 'instagram' ]    = esc_url_raw( $new_instance[ 'instagram' ] );

        $instance[ 'linkedin' ]     = esc_url_raw( $new_instance[ 'linkedin' ] );

        return $instance;
    } 
}