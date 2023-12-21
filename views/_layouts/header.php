<?php
    //validacion para mostrar total de productos desde inicio
    $productos = 0;
    if(isset($_SESSION['carrito']) and count($_SESSION['carrito']) !=0 ){
        foreach($_SESSION['carrito'] as $item){
            $productos += $item['cantidad'];
        }
    }
    $productos;
?>
<body class="bg-[<?= bodyBgColor; ?>]">
    <header>
        <nav class="bg-[<?= navBgColor; ?>] border-gray-200">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-center sm:justify-between mx-auto p-4">
                <div>
                    <!--icon logo -->
                    <a href="<?= URL_FULL;?>" class="flex items-center">
                        <img src="<?= PUBLICDOCS;?>/img/icons/logo_head.png" class="logo-header mr-2 sm:mr-3" alt="Mickey Geek" />
                        <span class="mr-2 font-mark text-red-500 resaltar self-center hidden min-[470px]:block min-[400px]:text-4xl sm:text-5xl font-semibold whitespace-nowrap">
                            <?= LOGOTXT; ?>
                        </span>
                    </a>
                </div>
                <!--icon social media -->
                <div class="hidden content-start min-[530px]:block">
                    <ul class="mx-4">      
                        <li class="text-white"> 
                            <a href="<?= FACEBOOK;?>" target="_blank" class="inline-block p-2 mx-1 hover:shadow-lg duration-200 hover:-translate-y-0.5">
                                <svg class="w-4" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-facebook-f fa-w-10 fa-7x"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
                            </a>

                            <a href="<?= INSTAGRAM;?>" target="_blank" class="inline-block p-2 mx-1 hover:shadow-lg duration-200 hover:-translate-y-0.5">
                                <svg class="w-6" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-instagram fa-w-14 fa-9x"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <!--icons nav-->
                <div class="flex items-center justify-between md:order-2">
                    <!--icon search-->
                    <div class="icon-header-item trans-04 mx-1 sm:mx-4 js-show-modal-search">
                        <button type="button" class="flex mr-1 sm:mr-3 text-2xl sm:text-3xl rounded-full md:mr-0">
                            <i class="fa fa-search text-white hover:text-blue-700" aria-hidden="true"></i>
                        </button>
                    </div>

                    <!--icon favorite-->
                    <div class="icon-header-item trans-04 mx-1 sm:mx-4">
                        <a href="/favorites" class="flex mr-1 sm:mr-3 text-2xl sm:text-3xl rounded-full md:mr-0" alt="Favoritos" title="Favoritos">
                            <i class="fa fa-heart text-white hover:text-blue-700" aria-hidden="true"></i>
                        </a> 
                    </div>

                    <?php if($info['page_name'] != 'carrito' && $info['page_name'] != 'details' && $info['page_name'] != 'pagar'){ ?>
                    <!--icon shoppingCart-->
                    <div id="itemsP" class="icon-header-item trans-04 ml-1 mr-2 sm:mx-4 icon-header-noti js-show-cart" data-notify="<?= $productos;?>">
                        <button type="button" class="flex mr-1 sm:mr-3 text-2xl sm:text-3xl rounded-full md:mr-0">
                            <i class="fa fa-shopping-cart text-white hover:text-blue-700" aria-hidden="true"></i>
                        </button>
                    </div>
                    <?php } ?>

                    <!--icon user-->
                    <div class="icon-header-item trans-04 mx-1 sm:mx-3">
                        <button type="button" class="flex mr-1 sm:mr-3 text-2xl sm:text-3xl rounded-full md:mr-0" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                            <span class="sr-only">Open user menu</span>
                            <i class="fa fa-user-circle-o text-white hover:text-blue-700" aria-hidden="true"></i>
                            <!--icon flecha-->
                            <svg class="w-5 h-5 ml-1" fill="white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Dropdown menu -->
                    <div class="z-50 hidden my-4 text-base list-none bg-[<?= navBgColor; ?>] divide-y divide-blue-700 rounded-lg shadow" id="user-dropdown">
                        <ul class="py-2" aria-labelledby="user-menu-button">
                        <?php if(empty($_SESSION['login'])){ ?>
                            <li>
                                <a href="<?= URL_FULL;?>/login" class="block px-4 py-2 text-sm text-white hover:bg-blue-700">Iniciar Sesión</a>
                            </li>
                                
                            <li>
                                <a href="<?= URL_FULL;?>/register" class="block px-4 py-2 text-sm text-white hover:bg-blue-700">Crear Cuenta</a>
                            </li>
                        <?php }else {?>
                            <li>
                                <a href="<?= URL_FULL;?>/account" class="block px-4 py-2 text-sm text-white hover:bg-blue-700">Cuenta</a>
                            </li>
                                    
                            <li>
                                <a href="<?= URL_FULL;?>/logout" class="block px-4 py-2 text-sm text-white hover:bg-blue-700 d">Cerrar Sessión</a>
                            </li>
                        <?php }?>
                        </ul>

                        <?php 
                        if(!empty($_SESSION['userData']) ){ if(ROL_ACCESS == $_SESSION['userData']['user_rol']){?>
                            <div class="px-4 py-3">
                                <span class="block text-sm  text-gray-500 truncate">Hola patrón</span>
                                <a href="<?= URL_FULL;?>/panel" class="block text-sm text-white">Panel</a>
                            </div>
                        <?php } }?>


                        <?php 
                        if(!empty($_SESSION['userData']) ){ if(ROL_ACCESS == $_SESSION['userData']['user_rol']){?>
                            <div class="px-4 py-3">
                                <span class="block text-sm  text-gray-500 truncate">Hola patrón</span>
                                <a href="<?= URL_FULL;?>/panel" class="block text-sm text-white">Panel</a>
                            </div>
                        <?php } }?>

                    </div>
                    <!--hamburguer menu-->
                    <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>

                <!--option menu-->
                <div class="items-center justify-center hidden w-full md:flex md:w-auto md:order-1" id="mobile-menu-2">
                    <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-blue-700 rounded-lg bg-[<?= navBgColor; ?>] md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-[<?= navBgColor; ?>]">
                        <li class="min-[469px]:hidden md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-[<?= navBgColor; ?>]">
                            <img src="<?= PUBLICDOCS;?>/img/icons/logo_name.png" class="log-w mx-auto">                           
                        </li>

                        <li>
                            <a href="<?= URL_FULL;?>/tienda" class="font-bold uppercase block py-2 pl-3 pr-4 text-white rounded hover:bg-blue-700 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Tienda</a>
                        </li>
            
                        <li>
                            <a href="<?= URL_FULL;?>/carrito" class="font-bold uppercase block py-2 pl-3 pr-4 text-white rounded hover:bg-blue-700 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Carrito</a>
                        </li>
            
                        <li>
                            <a href="<?= URL_FULL;?>/about" class="font-bold uppercase block py-2 pl-3 pr-4 text-white rounded hover:bg-blue-700 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Quienes Somos</a>
                        </li>
            
                        <li>
                            <a href="<?= URL_FULL;?>/about/contact" class="font-bold uppercase block py-2 pl-3 pr-4 text-white rounded hover:bg-blue-700 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Contacto</a>
                        </li>
                    </ul>
                    <ul class="flex flex-wrap font-medium p-4 md:p-0 mt-4 border border-blue-700 rounded-lg bg-[<?= navBgColor; ?>] min-[530px]:hidden md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-[<?= navBgColor; ?>]">
                        <li>
                            <a href="<?= FACEBOOK;?>" target="_blank" class="inline-block p-2 mx-1 hover:shadow-lg hover:text-blue-700 duration-200 hover:-translate-y-0.5">
                                <svg class="w-4" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-facebook-f fa-w-10 fa-7x"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
                            </a>                            
                        </li>
                        <li>
                            <a href="<?= INSTAGRAM;?>" target="_blank" class="inline-block p-2 mx-1 hover:shadow-lg hover:text-blue-700 duration-200 hover:-translate-y-0.5">
                                <svg class="w-6" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-instagram fa-w-14 fa-9x"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
                            </a>
                        </li>
                        
                    </ul>
                </div>

            </div>
        </nav>
        <!--Form de busqueda-->
        <?= getLayout('search', $info); ?>
        <!--Form de busqueda-->
        <?= getLayout('cartAside', $info); ?>
  
    </header>