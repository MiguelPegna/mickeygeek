<!-- Modal Search -->
<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
	<div class="container-search-header">
		<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
			<img src="<?= PUBLICDOCS; ?>/img/icons/icon-close2.png" alt="CLOSE">
		</button>

		<form class="wrap-search-header flex-w p-l-15" method="GET" action="<?=URL_FULL;?>/search">
			<button class="flex-c-m trans-04">
				<i class="fa fa-search text-blue-700 hover:text-blue-500"></i>
			</button>
			<input type="hidden" name="p" value="1">
			<input class="plh3" type="text" name="s" placeholder="Buscar...">
		</form>
	</div>
</div>