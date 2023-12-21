<?php
    //consumo de endpoints
    $collections = api(URL_FULL.'/api/collections');
    $slider = api(URL_FULL.'/api/slider');
    $collage = api(URL_FULL.'/api/collage');
?>
<!--Slider -->
<?= getLayout('slider', $slider); ?>

<!--Slider Collections-->
<?= getLayout('collections', $collections); ?>

<main class="bg-[<?= bodyBgColor; ?>] w-full md:container md:max-w-screen-xl mx-auto md:px-5 ">
    
    <span class="underline"> la pagina home</span>
    
</main>


<?= btn('home', 'btn1', 'btn1', 'Haz click'); ?> 
