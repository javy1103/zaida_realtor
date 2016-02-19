<?php
session_start();
get_header();

    get_template_part('banners/taxonomy_page_banner');


    /* Check View Type */
    if(isset($_GET['view'])){
        $view_type = $_GET['view'];
    }else{
        /* Theme Options Listing Layout */
        $view_type = get_option('theme_listing_layout');
    }
    ?>

    <div class="container contents listing-grid-layout">
        <div class="row">
            <div class="span9 main-wrap">

                <!-- Main Content -->
                <div class="main">

                    <section class="listing-layout <?php if( $view_type == 'grid' ){ echo 'property-grid'; } ?>">

                        <?php
                        // listing view type
                        get_template_part( 'template-parts/listing-view-type' );
                        ?>

                        <div class="list-container clearfix">
                            <?php

                            global $wp_query;
                            $args = $wp_query->query_vars;
                            $_SESSION['city'] = $args['property-city'];
                            query_posts( $args );

                            if ( have_posts() ) :
                               echo facetwp_display( 'template', 'city' );
                            else:
                                ?>
                                <div class="alert-wrapper">
                                    <h4><?php _e('No Results Found', 'framework') ?></h4>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>

                        <?php   echo facetwp_display( 'pager' );  ?>

                    </section>

                </div><!-- End Main Content -->

            </div> <!-- End span9 -->

            <?php get_sidebar('property-listing-city-only'); ?>

        </div><!-- End contents row -->
    </div>

<?php get_footer(); ?>