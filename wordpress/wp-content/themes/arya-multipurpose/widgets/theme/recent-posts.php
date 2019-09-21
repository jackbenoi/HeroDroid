<?php

class Arya_Multipurpose_Post_Widget extends WP_Widget {
 
    function __construct() { 

        parent::__construct(
            'arya-multipurpose-post-widget',  // Base ID
            esc_html__( 'AM: Posts Widget', 'arya-multipurpose' ),   // Name
            array(
                'classname' => 'recent-post-widget',
                'description' => esc_html__( 'Displays recent posts.', 'arya-multipurpose' ), 
            )
        );
 
    }
 
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$post_choice = !empty( $instance[ 'post_choice' ] ) ? $instance[ 'post_choice' ] : 'recent';

		$posts_no = !empty( $instance[ 'post_no' ] ) ? $instance[ 'post_no' ] : 5;

        $show_date_meta = $instance['show_date_meta'];

		echo $args[ 'before_widget' ];

		$post_args = array(
			'posts_per_page' => absint( $posts_no ),
			'post_type' => 'post'
		);

		$post_query = new WP_Query( $post_args );

		if( $post_query->have_posts() ) :
			echo $args[ 'before_title' ];
				echo esc_html( $title );
			echo $args[ 'after_title' ];
			?>
            <ul>
                <?php
                while( $post_query->have_posts() ) {

                    $post_query->the_post();
                    ?>
                    <li class="d-flex flex-row align-items-center">
                        <div class="thumbs">
                            <?php
                            the_post_thumbnail( 'arya-multipurpose-thumbnail-three', array( 
                                'class' => 'img-fluid',
                                'alt' => the_title_attribute( array(
                                    'echo' => false,
                                ) ),
                            ) );
                            ?>
                        </div>
                        <div class="details">
                            <a href="<?php the_permalink(); ?>">
                                <h5><?php the_title(); ?></h5>
                            </a>
                            <?php
                            if( $show_date_meta === true ) {
                                ?>
                                <p><?php echo esc_html( get_the_date() ); ?></p>
                                <?php
                            }
                            ?>
                        </div>
                    </li>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </ul>
			<?php
		endif;
			
		echo $args[ 'after_widget' ]; 
 
    }
 
    public function form( $instance ) {

        $defaults = array(
            'title'       => '',
            'post_no'	  => 5,
            'show_date_meta' => true,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
            <label for="<?php echo esc_attr( $this->get_field_name('title') ); ?>">
                <strong><?php esc_html_e('Title', 'arya-multipurpose'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />   
        </p>

		<p>
            <label for="<?php echo esc_attr( $this->get_field_name('post_no') ); ?>">
                <strong><?php esc_html_e('No of Posts', 'arya-multipurpose'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('post_no') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post_no') ); ?>" type="number" value="<?php echo esc_attr( $instance['post_no'] ); ?>" />   
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name('show_date_meta') ); ?>">
                <input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_date_meta') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_date_meta') ); ?>" <?php if( $instance['show_date_meta'] == true ) { esc_attr_e( 'checked', 'arya-multipurpose' ); } ?> >
                <?php esc_html_e('Show Posted Date', 'arya-multipurpose'); ?>
            </label>
        </p>  
		<?php
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = $old_instance;

        $instance['title']  	= sanitize_text_field( $new_instance['title'] );

        $instance['post_no']  	= absint( $new_instance['post_no'] );

        $instance['show_date_meta']  = wp_validate_boolean( $new_instance['show_date_meta'] );

        return $instance;
    } 
}