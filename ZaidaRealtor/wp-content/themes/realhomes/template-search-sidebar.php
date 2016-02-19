<?php
 session_start(); //Never forget this line when using $_SESSION
   

/*
*   Template Name: Property Search Template With Sidebar
*/
get_header();


/* Theme search module */
$theme_search_module = get_option('theme_search_module');

switch( $theme_search_module ){
    case 'properties-map':
        get_template_part('banners/map_based_banner');
        break;

    default:
        get_template_part('banners/default_page_banner');
        break;
}
?>

<!-- listing container - grid layout -->
<div class="container contents listing-grid-layout">

    <div class="row">

        <!-- sidebar wrapper -->
        <div class="span3 sidebar-wrap">

            <!-- start of sidebar -->
            <aside class="sidebar">
                <?php
                if ( ! dynamic_sidebar( 'property-search-sidebar' ) ) :
                endif;
                ?>
            </aside><!-- end of sidebar -->

        </div><!-- end of sidebar wrapper -->

        <!-- main content wrapper -->
        <div class="span9 main-wrap">

            <div class="main fix-margins">

                <!-- listing layout -->
                <section class="listing-layout listing-grid-layout">
				
                    <div class="list-container clearfix">
                        <?php
                        
                        get_template_part('template-parts/sort-controls');

                        /* List of Properties on Homepage */
                        $number_of_properties = intval(get_option('theme_properties_on_search'));
                        if(!$number_of_properties){
                            $number_of_properties = 6;
                        }

                        global $paged;
                        if ( is_front_page()  ) {
                            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
                        }

                        $search_args = array(
                            'post_type' => 'property',
                            'posts_per_page' => $number_of_properties,
                            'paged' => $paged
                        );

                        // Apply Search Filter
                        $search_args = apply_filters('real_homes_search_parameters',$search_args);
                        $search_args = sort_properties($search_args);
                        $_SESSION['args'] = $search_args;
                        $search_query = new WP_Query($search_args);
                        $n_posts = $search_query->found_posts;

                        if( $n_posts > 0) {
                            echo facetwp_display( 'template', 'default' );
                        }
                            
                        else {
                            ?><div class="alert-wrapper"><h4><?php _e('No Properties Found!', 'framework') ?></h4></div><?php
                        }
                        ?>
                    </div>
                    <?php echo facetwp_display( 'pager' ); ?>

                </section><!-- end of listing layout -->

            </div>

        </div><!-- end of main content wrapper -->

    </div><!-- end of .row -->

</div><!-- end of listing container -->


<?php get_footer(); ?>