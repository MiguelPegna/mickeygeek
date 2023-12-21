<?php
    /**
    * @var string $classes Clases para crear el estilo del boton
    * @var string $name nombre pata el boton
    * @var string $id id para el boton
    * @var string $val Texto que contendra el boton
    * @return $craft elemento HTML 
    */
    function btn($classes, $name, $id, $val){
        $craft ='<button class="'. $classes. '" id="' .$id. '" name="' .$name. '" >' .$val. '</button>';
        return $craft;
    }

    /**
    * @var string $classes Clases para crear el estilo del boton
    * @var string $name nombre pata el boton
    * @var string $id id para el boton
    * @var string $val Texto que contendra el boton
    * @return $craft elemento HTML
    */
    function btnSubmit($classes, $name, $id, $val){
        $craft ='<input type="submit" class="'. $classes. '" id="' .$id. '" name="' .$name. '" value="' .$val. '" />';
        return $craft;
    }