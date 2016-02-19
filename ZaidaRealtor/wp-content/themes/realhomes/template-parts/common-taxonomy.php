<?php
get_header();
session_start();


    /* Determine the type header to be used for taxonomy */
    $theme_listing_module = get_option('theme_listing_module');

    switch($theme_listing_module){
        case 'properties-map':
            get_template_part('banners/map_based_banner');
            break;
        default:
            get_template_part('banners/taxonomy_page_banner');
            break;
    }

    /* Check View Type */
    if(isset($_GET['view'])){
        $view_type = $_GET['view'];
    }else{
        /* Theme Options Listing Layout */
        $view_type = get_option('theme_listing_layout');
    }
    $_SESSION['view_type'] = $view_type;
    ?>

    <div class="container contents listing-grid-layout">
        <div class="row">
            <div class="span9 main-wrap">

                <!-- Main Content -->
                <div class="main">

                    <section class="listing-layout <?php if( $view_type == 'grid' ){ echo 'property-grid'; } ?>">

                        <div class="view-type clearfix">
                            <?php
                            $page_url = custom_taxonomy_page_url();
                            $separator = (parse_url($page_url, PHP_URL_QUERY) == NULL) ? '?' : '&';
                            ?>
                            <a class="list <?php if( $view_type != 'grid' ){ echo 'active'; } ?>" href="<?php echo $page_url.$separator.'view=list'; ?>"></a>
                            <a class="grid <?php if( $view_type == 'grid' ){ echo 'active'; } ?>" href="<?php echo $page_url.$separator.'view=grid'; ?>"></a>
                        </div>

                        <div class="list-container clearfix">
                            <?php


                            global $wp_query;

                            $args = $wp_query->query_vars;
                            $_SESSION['type'] = $args['property-type'];

                            // Use facetwp if property-type is building
                            if ($args['property-type'] == 'building') {
                                $_SESSION['type'] = $args['property-type'];
                                query_posts( $args );

                                if ( have_posts() ) :
                                   echo facetwp_display( 'template', 'condos' );

                                    
                                else:
                                    ?>
                                    <div class="alert-wrapper">
                                        <h4><?php _e('No Results Found', 'framework') ?></h4>
                                    </div>
                                    <?php
                                endif;
                            ?>
                            </div>

                            <?php   echo facetwp_display( 'pager' ); } ?>

                        <?php   if ($args['property-type'] == 'pre-construction') {
                                
                                query_posts( $args );

                                if ( have_posts() ) :
                                   echo facetwp_display( 'template', 'pre_con' );

                                    
                                else:
                                    ?>
                                    <div class="alert-wrapper">
                                        <h4><?php _e('No Results Found', 'framework') ?></h4>
                                    </div>
                                    <?php
                                endif;
                            ?>
                            </div>

                            <?php   echo facetwp_display( 'pager' ); } ?>
                            

                    </section>

                </div><!-- End Main Content -->

            </div> <!-- End span9 -->

            <?php get_sidebar('property-listing'); ?>

        </div><!-- End contents row -->
    </div>

<?php get_footer();?>