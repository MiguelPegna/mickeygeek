
    <!-- JS -->
    <script>
        const base_url= "<?= URL_FULL; ?>";
    </script>
    <!-- SCRIPTS -->
    
    <script src="<?= PUBLICDOCS; ?>/js/plugins/sweetalert2@11.js"></script>
    <script src="<?= PUBLICDOCS; ?>/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="<?= PUBLICDOCS; ?>/js/plugins/flowbite.min.js"></script>
    <script src="<?= PUBLICDOCS; ?>/js/menu.js"></script>
    <!-- cargar scripts correspondientes a cada vista-->
    <?php
        if($info['page_name'] == 'home'){
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.5.0/glide.min.js"></script>';

        }
        if(empty($info['page_scripts'])){
            $info['page_scripts']='';
        }
        echo $info['page_scripts'];
    ?>
    
    <!--Se carga scripts del carrito-->
    <?php if($info['page_name']!='carrito' && $info['page_name']!='listado'){ ?>
        <script src="<?= PUBLICDOCS; ?>/js/carrito/cartShop.js"></script>
        <script src="<?= PUBLICDOCS; ?>/js/carrito/addItem.js"></script>
    <?php }?>

        
    <footer class="bg-gray-200 mt-10">
        <div class="p-10 bg-gray-800 text-gray-200">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                    <div class="mb-5">
                        <p>
                            <strong>
                                <i class="fa fa-map-marker" aria-hidden="true"></i> Ubicación:
                            </strong><br/>
                            <?php echo DIRECCION;?>
                            <strong>
                                <i class="fa fa-phone" aria-hidden="true"></i> Teléfono:
                            </strong>
                            <?php echo TELEFONO;?> <br>
                            <strong>
                                <i class="fa fa-envelope" aria-hidden="true"></i> Email:
                            </strong>
                            <?php echo EMAIL;?><br>
                        </p>
                    </div>

                    <div class="mb-5">
                        <h4>
                            <strong>
                                Sobre nosotros
                            </strong>
                        </h4>
                        <ul>
                            <a class="pb-4 text-slate-400 hover:text-sky-400" href="<?= URL_FULL;?>/about"><li class="pb-4"><i class="fa fa-question-circle-o"></i> Preguntas Frecuentes </li> </a>
                            <a class="pb-4 text-slate-400 hover:text-sky-400" href="<?= URL_FULL;?>/about"><li  class="pb-4"><i class="fa fa-user-secret"></i> Aviso de privacidad</li></a>
                            <a class="pb-4 text-slate-400 hover:text-sky-400" href="<?= URL_FULL;?>/about"><li  class="pb-4"><i class="fa fa-exclamation-triangle"></i> Terminos y condiciones</li></a>
                            <a class="pb-4 text-slate-400 hover:text-sky-400" href="<?= URL_FULL;?>/about"><li  class="pb-4"><i class="fa fa-shopping-cart"></i> ¿Cómo Comprar? </li></a>
                            <a class="pb-4 text-slate-400 hover:text-sky-400" href="<?= URL_FULL;?>/about"><li  class="pb-4"><i class="fa fa-money"></i> Formas de Pago</li></a>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h4>
                            <strong>
                                Seguinos en
                            </strong>
                        </h4>
                        <ul>
                            <li class="pb-4 text-slate-400 hover:text-sky-400"><i class="fa fa-facebook" aria-hidden="true"></i> <a href="<?php echo FACEBOOK;?>" target="blank">Facebook</a></li>
                            <li class="pb-4 text-slate-400 hover:text-sky-400"><i class="fa fa-instagram" aria-hidden="true"></i> <a href="<?php echo INSTAGRAM;?>" target="blank">Instagram</a></li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <img src="<?= PUBLICDOCS; ?>/img/icons/logo_head.png" width="120" height="150" title="mickey geek">
                        <h4 class="text-2xl pb-4 font-mark">
                            <?= LOGOTXT; ?>&#174;
                        </h4>
                        <h4>
                            powered by: 
                        </h4>
                        <p> 
                            <?= DEV;?>
                        </p>
                        <p>
                            copyright &#169; <?= date('Y'); ?>
                        </p>
                                
                    </div>

                </div>
            </div>
        </div>
    </footer>    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>-->
            
    </body>
</html>