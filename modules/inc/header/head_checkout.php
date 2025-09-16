<div class="gutenberg__wrap">
<header class="header checkout" id="web__header">
        <div class="medium_box"> 
            <section class="header__left">
                <a href="/" class="logo">
                    <!--<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-white.svg" alt="The Zahra Trust" class="logo_white">-->
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-black.svg" alt="The Zahra Trust" class="logo_black">
                </a>     
            </section>

            <section class="header__center">
                <h1><?php the_title(); ?></h1>
            </section>
        </div>
	</header>

	<div class="searchOverlay">
		<a href="#" id="closeSearch" class="closeButton">
			<svg enable-background="new 0 0 30 30" height="30px" id="Layer_1" version="1.1" viewBox="0 0 30 30" width="30px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path clip-rule="evenodd" d="M15,30C6.716,30,0,23.284,0,14.999C0,6.715,6.716,0,15,0s15,6.715,15,14.999  C30,23.284,23.284,30,15,30z M15,2C7.82,2,2,7.82,2,14.999C2,22.179,7.82,28,15,28s13-5.821,13-13.001C28,7.82,22.18,2,15,2z   M10.341,20.989l-1.331-1.33l4.659-4.66L9.01,10.342l1.331-1.332L15,13.669l4.658-4.659l1.332,1.332l-4.659,4.657l4.659,4.66  l-1.332,1.33L15,16.331L10.341,20.989z" fill-rule="evenodd"/></svg>		
		</a>
		<h3>Search Website</h3>
		<form action="/" class="searchForm">
			<input placeholder="Start typing here..." name="s" type="text" class="text_field">
			<button class="submitButton" type="submit"><i class="fa fa-arrow-right"></i></button>
		</form>
	</div>
	
	<nav id="mobile_navigation" class="header__mobile_navigation">
		<?php wp_nav_menu(array('menu' => 'Main Menu', 'items_wrap' => '<ul>%3$s</ul>', 'container' => false)); ?>
	</nav>

    <?php if(get_field('donate_page')): ?>
    <section class="mobile__header_donations checkout">
		<ul>
			
			<li>
				<a href="/checkout/" class="donate_trigger_search">
					<svg id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M344.5,298c15-23.6,23.8-51.6,23.8-81.7c0-84.1-68.1-152.3-152.1-152.3C132.1,64,64,132.2,64,216.3  c0,84.1,68.1,152.3,152.1,152.3c30.5,0,58.9-9,82.7-24.4l6.9-4.8L414.3,448l33.7-34.3L339.5,305.1L344.5,298z M301.4,131.2  c22.7,22.7,35.2,52.9,35.2,85c0,32.1-12.5,62.3-35.2,85c-22.7,22.7-52.9,35.2-85,35.2c-32.1,0-62.3-12.5-85-35.2  c-22.7-22.7-35.2-52.9-35.2-85c0-32.1,12.5-62.3,35.2-85c22.7-22.7,52.9-35.2,85-35.2C248.5,96,278.7,108.5,301.4,131.2z"/></svg>
                    <strong>Checkout</strong>
                </a>
			</li>
			
			<?php if(isMobile()){ ?>
			<li>
				<a href="#" class="donate_trigger_cart cart_icon">
					<span id="cart_quantity">0</span>
					<svg enable-background="new 0 0 32 32" id="Layer_1" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M27.671,9.189c-0.143-0.207-0.377-0.33-0.627-0.33H10.601l-2.059-3.5H4.196V6.88h3.477L9.46,9.92l2.648,9.576   c0.092,0.33,0.392,0.558,0.732,0.558h10.498c0.314,0,0.598-0.194,0.709-0.488l3.705-9.675C27.843,9.657,27.812,9.395,27.671,9.189z    M22.816,18.533H13.42l-2.255-8.154h14.773L22.816,18.533z"/><path d="M12.944,21.209c-1.498,0-2.715,1.219-2.715,2.716s1.217,2.716,2.715,2.716s2.715-1.219,2.715-2.716   S14.442,21.209,12.944,21.209z M12.944,25.12c-0.658,0-1.195-0.536-1.195-1.195s0.537-1.195,1.195-1.195   c0.66,0,1.195,0.536,1.195,1.195S13.604,25.12,12.944,25.12z"/><path d="M22.413,21.209c-1.498,0-2.716,1.219-2.716,2.716s1.218,2.716,2.716,2.716s2.715-1.219,2.715-2.716   S23.911,21.209,22.413,21.209z M22.413,25.12c-0.659,0-1.195-0.536-1.195-1.195s0.536-1.195,1.195-1.195   c0.658,0,1.195,0.536,1.195,1.195S23.071,25.12,22.413,25.12z"/></g></svg>
                    <strong>Cart</strong>
                </a>
            </li>
            <script>
            jQuery(document).ready(function($){
                cart_quantity();
            });
            </script>
            
			<?php } ?>

		</ul>
    </section>
    <?php endif; ?>
    

    
<script>

// window.onscroll = function changeNav(){
// 	var scrollPosY = window.pageYOffset | document.body.scrollTop;
// 	const navBar = document.querySelector('.header');
	
// 	if(scrollPosY > 40) {
// 		navBar.className = ('header fixed__header');  
//     } else if(scrollPosY <= 40) {
//         navBar.className =  ('header');
// 	}
// }
</script>
</div>