<?php

require get_template_directory() . '/customizer/functions/options/layout-options.php';

require get_template_directory() . '/customizer/functions/options/header-options.php';

require get_template_directory() . '/customizer/functions/options/page-options.php';

require get_template_directory() . '/customizer/functions/options/sidebar-options.php';

require get_template_directory() . '/customizer/functions/options/footer-options.php';

require get_template_directory() . '/customizer/functions/options/background-options.php';

if( class_exists( 'Woocommerce' ) ) {

	require get_template_directory() . '/customizer/functions/options/woocommerce-options.php';
}