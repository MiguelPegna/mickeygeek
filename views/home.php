<?php
    //consumo de endpoints
    $collections = api(URL_FULL.'/api/collections');
    $slider = api(URL_FULL.'/api/slider');
    $catalog = api(URL_FULL.'/api/catalog');
    $collage = api(URL_FULL.'/api/collage');
?>
<!--Slider -->
<?= getLayout('slider', $slider); ?>

<!--Slider Collections-->
<?= getLayout('collections', $collections); ?>

<main class="bg-[<?= bodyBgColor; ?>] md:container md:max-w-screen-xl md:mx-auto md:px-5 ">
    <!--Catalog-->
    <?= getLayout('catalog', $catalog); ?>    
</main>

<span class="underline"> la pagina home</span>


<?= btn('home', 'btn1', 'btn1', 'Haz click'); ?> 
