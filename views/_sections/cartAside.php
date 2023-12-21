<!-- Cart -->
<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25 bg-[#23262c]">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2 text-white">
					Carrito
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer text-white hover:text-blue-700 trans-04 js-hide-cart">
					<i class="fa fa-close"></i>
				</div>
			</div>
			
			<div id="itemsCart" class="header-cart-content flex-w js-pscroll text-white">
				<!--contenido del Carrito-->
                <?php getModal('shoppingcart', $data); ?>
			</div>
		</div>
	</div>