<?php
/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( hello_elementor_display_header_footer() ) {
		if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
			get_template_part( 'template-parts/dynamic-footer' );
		} else {
			get_template_part( 'template-parts/footer' );
		}
	}
}
?>


<script>
    
    document.addEventListener("DOMContentLoaded", function () {
    
        function trackClick(buttonName) {
    
            var data = new URLSearchParams();
            data.append("action", "track_button_click");
            data.append("button_name", buttonName);
            data.append("page_url", window.location.href);
    
            navigator.sendBeacon(
                "/wp-admin/admin-ajax.php",
                data
            );
        }
    
        // Desktop Call Button
        var callBtn = document.getElementById("call-btn");
    
        if (callBtn) {
            callBtn.addEventListener("click", function () {
                trackClick("call_button");
            });
        }
    
        // Mobile Call Button
        var callBtnMobile = document.getElementById("call-btn-mobile");
    
        if (callBtnMobile) {
            callBtnMobile.addEventListener("click", function () {
                trackClick("call_button_mobile");
            });
        }
        
        
    
        // Book Online Buttons
var bookBtns = document.querySelectorAll(".book-online-btn");

bookBtns.forEach(function(btn){

    btn.addEventListener("click", function(){

        if (window.innerWidth <= 767) {
            trackClick("book_online_mobile");
        } else {
            trackClick("book_online");
        }

    });

});
    
    });
    </script>


<?php wp_footer(); ?>

</body>
</html>
<style>
.right-icons {
    position: fixed;
    right: 1%;
    bottom: 20%;
    z-index: 9999999999999999;
}
.callme {
    width: 45px;
    background: #3c3c9e;
    z-index: 99999999999999;
    padding: 10px;
    border-radius: 100%;
    height: 45px;
}
.whatsapp-logo1 {
    width: 55px;
    z-index: 999999999999;
}
.mobile-socialfix {
    bottom: 0;
    z-index: 1;
}
.whatapp-mob {
    background: #3393F0;
font-size:20px;
}
.call-mob {
    background: #3c3c9e;
}
.whatapp-mob img {
    width: 40px;
    vertical-align: middle;
}
.call-mob img {
    width: 35px;
    vertical-align: middle;
}
@media (max-width: 767px) {
    .bot-widget-bubble {
        bottom: 70px !important;
    }
}</style>
<section class="mobile-socialfix position-fixed w-100 d-block d-sm-none">
	      <div class="row m-0">
         <div class="col-6 whatapp-mob text-center">
	              <div class="p-2 pt-3 ">
	                     <a class="book-online-btn text-white fw-bold text-decoration-none"  href="https://healow.com/apps/provider/mohit-gupta-3407940">
                        Book Online
                    </a>
	              </div>
	          </div> 
	          <div class="col-6 text-center call-mob">
	              <div class="p-2">
	                    <a href="tel:7136738774" id="call-btn-mobile"  class="text-white fw-bold text-decoration-none">
                         <img src="https://stxprimarycare.com/wp-content/uploads/2026/01/callme.gif" alt="Call Icon"> Call Now
                    </a>
	              </div>
	          </div>
	      </div>
	  </section>
<div class="right-icons  d-none d-sm-block">
    <div id="callme" class="callme">
                    <a href="tel:7136738774" id="call-btn">
                        <img class="w-100" src="https://stxprimarycare.com/wp-content/uploads/2026/01/callme.gif" alt="call icon">
                    </a>
                </div>

<!-- <div class="whatsapp-logo1 mt-3">
                    <a id="whatsapp-message" href="https://wa.me/13466560385?text=Hi I am interested in Primary Care. Please contact me as soon as possible">
                        <img src="https://stxprimarycare.com/wp-content/uploads/2026/01/whatsapp1.gif" alt="Whatsapp icon">
                    </a>
                </div> -->
</div>


