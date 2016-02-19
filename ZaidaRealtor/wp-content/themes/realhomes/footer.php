<?php get_template_part("template-parts/carousel_partners"); ?>

<!-- Start Footer -->
<footer id="footer-wrapper">

       <div id="footer" class="container">

                <div class="row">

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-first-column' ) ) : ?>
                            <?php endif; ?>
                        </div>

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-second-column' ) ) : ?>
                            <?php endif; ?>
                        </div>

                        <div class="clearfix visible-tablet"></div>

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-third-column' ) ) : ?>
                            <?php endif; ?>
                        </div>

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-fourth-column' ) ) : ?>
                            <?php endif; ?>
                        </div>
                </div>

       </div>

        <!-- Footer Bottom -->
        <div id="footer-bottom" class="container">

                <div class="row">
                        <div style="text-align: center">
                            <span style="font-size:20px; color: #19324c">ONE Sotheby’s International Realty<br>
							1451 Ocean Drive Suite 104<br>
							Miami Beach, Fl 33139
							</span>
                        </div>
                </div>

        </div>
        <!-- End Footer Bottom -->

</footer><!-- End Footer -->

<?php
if( !is_user_logged_in() ){
    get_template_part('template-parts/modal-login');
}
?>

<?php wp_footer(); ?>

</body>
</html>