    <div class="mt-16">
        <h2 class="font-mark text-3xl text-center text-amber-500 font-bold mt-5 mb-1">
            BEST SELLER
        </h2>
    </div>

    <!--card product container-->
    <div class="container justify-center items-center grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        
        <?php for($i=0; $i<count($data); $i++){ ?>
            <div class="bg-[#23262c] shadow-md rounded-lg max-w-sm hover:bg-[#4a4b4e]">
                <a href="productos/producto/<?= $data[$i]['id'].'/'.$data[$i]['url'];?> ">
                    <img class="rounded-t-lg p-8 sm:w-72 sm:h-96" src="<?= PUBLICDOCS.'/img/catalogo/'. $data[$i]['picture']; ?>" alt="<?= $data[$i]['product'];?>" title="<?= $data[$i]['product'];?>" loading="lazy"/>
                    <div class="px-5 pb-5">
                        <h3 class="text-white font-semibold text-xl sm:text-2xl tracking-tight js-name-detail">
                            <?= $data[$i]['product'];?>
                        </h3>
                </a>
                        <div class="flex items-center mt-2.5 mb-5">
                            <button id="favR_<?= $data[$i]['id'];?>" name="favR_<?= $data[$i]['id'];?>" class="js-addwish-b2">
                                <div class="favR_<?= $data[$i]['id'];?>">
                                    <?php if(empty($_SESSION['idUser'])){ //si no existe mostramos el icono de fav vacio?>
                                        <svg xmlns="http:www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                    <?php } else{
                                         //si existe consultamos si el usuario ya ha agregado el producto a favs
                                        isFav($_SESSION['idUser'], $data[$i]['id']);
                                    }?>
                                </div>
                            </button>
                        </div>

                        <div class="w-full items-center block sm:flex sm:items-center sm:justify-between">
                            <span class="pb-3 flex justify-center items-center w-full sm:w-auto text-3xl font-bold text-white font-price">
                                $<?php echo formatMoney($data[$i]['price']);?>
                            </span>
                            <a href="productos/producto/<?php echo $data[$i]['id'].'/'.$data[$i]['url'];?>" id="<?= openssl_encrypt($data[$i]['id'], METHODENCRIPT, KEY);?>" class="flex justify-center items-center w-full sm:w-auto text-blue-700 bg-gradient-to-r from-blue-700 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-700 dark:focus:ring-blue-500 font-semibold rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2" title="Ver producto">
                                <svg xmlns="http:www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart-plus" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="6" cy="19" r="2"></circle>
                                    <circle cx="17" cy="19" r="2"></circle>
                                    <path d="M17 17h-11v-14h-2"></path>
                                    <path d="M6 5l6.005 .429m7.138 6.573l-.143 .998h-13"></path>
                                    <path d="M15 6h6m-3 -3v6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
            </div>
        <?php }//end for?>
    </div>


    <div class="flex justify-center my-10">

        <a href="tienda" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-blue-700 to-blue-500 group-hover:from-blue-700 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
            <span class="text-white font-semibold uppercase hover:text-white relative px-5 py-2.5 transition-all ease-in duration-75 bg-blue-700 dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Ver Más...
            </span>
        </a>
    </div>
