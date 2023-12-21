<!--cabeceras del html para las vistas-->
<!DOCTYPE html>
<html lang="es/mx">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $info['meta_description'];?>">
    <meta name="keywords" content="palabras, clave, de, la, pagina">
    <meta name="author" content="tu nombre">
    <?php //verificacion para compartir en redes sociales
        $webname = EMPMETA;
        $description = DESCRIPCION;
        $nomProduct = EMPRESA; 
        $url = URL_FULL;
        $urlImg = PUBLICDOCS.'/img/icons/logo_head.png';
        if(!empty($data['estacion'])){
            $description = $data['estacion']['data']['estacion'];
            $nomProduct = $data['page_title'];
            $url= URL_FULL.'/productos/producto/'.$data['estacion']['data']['product_id'].'/'.$data['estacion']['data']['url'];
            $urlImg = PUBLICDOCS.'/img/catalogo/'.$data['estacion']['data']['photo_pic'];
        }
        echo '<meta property="og:locale" content="es_MX"/>
            <meta property="og:type" content"website"/>
            <meta property="og:site_name" content="'.$webname.'"/>   
            <meta property="og:description" content="'.$description.'"/> 
            <meta property="og:title" content="'.$nomProduct.'"/>
            <meta property="og:url" content="'.$url.'"/>
            <meta property="og:image" content="'.$urlImg.'"/>
        ';

    ?>
    <!-- Bootstrap styles-->
    <link rel="stylesheet" type="text/css" href="<?= PUBLICDOCS; ?>/css/fontAwesome/css/font-awesome.min.css">
    <?php if($info['page_name'] == 'home') {
        echo '
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.min.css">';
    }; ?>
    
    <link href="<?= PUBLICDOCS; ?>/css/util.css" rel="stylesheet">
    <link href="<?= PUBLICDOCS; ?>/css/cart.css" rel="stylesheet">
    <link href="<?= PUBLICDOCS; ?>/css/main.css" rel="stylesheet">
    <link href="<?= PUBLICDOCS; ?>/css/tailwindOut.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="<?= PUBLICDOCS; ?>/img/icons/favicon.png">
    <!--<script src="https://cdn.tailwindcss.com/3.2.4"></script>-->

    <title><?php echo $info['page_title']; ?></title>
</head>