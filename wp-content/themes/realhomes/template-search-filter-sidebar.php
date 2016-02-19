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
                <section class="listing-layout">

                    <div class="list-container clearfix">
                        <?php
                        get_template_part('template-parts/sort-controls');


                            if ( have_posts() ) :
                                $post_count = 0;
                                while ( have_posts() ) :
                                    the_post();

                                    /* Display Property for Search Page */
                                    get_template_part('template-parts/property-for-home');

                                    $post_count++;
                                    if(0 == ($post_count % 2)){
                                        echo '<div class="clearfix"></div>';
                                    }
                                endwhile;
                                wp_reset_query();
                        else:
                            ?><div class="alert-wrapper"><h4><?php _e('No Properties Found!', 'framework') ?></h4></div><?php
                        endif;
                        ?>
                    </div>

                    <?php theme_pagination( $wp_query->max_num_pages); ?>

                </section><!-- end of listing layout -->

            </div>

        </div><!-- end of main content wrapper -->

    </div><!-- end of .row -->

</div><!-- end of listing container -->


<?php get_footer(); ?>