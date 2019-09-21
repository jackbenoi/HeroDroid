<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Arya_Multipurpose
 */

?>
	<!-- Start footer section -->
    <footer class="footer-section section-gap-half">
        <div class="container">
            <?php
            if( is_active_sidebar( 'arya-multipurpose-footer-1' ) || is_active_sidebar( 'arya-multipurpose-footer-2' ) || is_active_sidebar( 'arya-multipurpose-footer-3' ) || is_active_sidebar( 'arya-multipurpose-footer-4' ) ) :
                ?>
                <div class="row">
                    <?php
                    if( is_active_sidebar( 'arya-multipurpose-footer-1' ) ) {
                        ?>
                        <div class="col-lg-3 col-sm-6 footer-cols">
                            <?php dynamic_sidebar( 'arya-multipurpose-footer-1' ); ?>
                        </div>
                        <?php
                    }

                    if( is_active_sidebar( 'arya-multipurpose-footer-2' ) ) {
                        ?>
                        <div class="col-lg-3 col-sm-6 footer-cols">
                            <?php dynamic_sidebar( 'arya-multipurpose-footer-2' ); ?>
                        </div>
                        <?php
                    }
                    if( is_active_sidebar( 'arya-multipurpose-footer-3' ) ) {
                        ?>
                        <div class="col-lg-3 col-sm-6 footer-cols">
                            <?php dynamic_sidebar( 'arya-multipurpose-footer-3' ); ?>
                        </div>
                        <?php
                    }
                    if( is_active_sidebar( 'arya-multipurpose-footer-4' ) ) {
                        ?>
                        <div class="col-lg-3 col-sm-6 footer-cols">
                            <?php dynamic_sidebar( 'arya-multipurpose-footer-4' ); ?>
                        </div>
                        <?php
                    }
                    ?>
                    
                </div>
                <?php
            endif;
            ?>
            <div class="row">
                <?php arya_multipurpose_copyright_text(); ?>
                <?php arya_multipurpose_credit_text(); ?>
            </div>
        </div>
    </footer>
    <!-- End footer section -->

    <div class="scroll-top">
        <i class="ti-angle-up"></i>
    </div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
