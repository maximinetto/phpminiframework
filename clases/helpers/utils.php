<?php

function objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }
    
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    }
    else {
        // Return array
        return $d;
    }
}

function uploadImagen(){
    $res=false;
    $imgFile = $_FILES['foto']['name'];
    $tmp_dir = $_FILES['foto']['tmp_name'];
    $imgSize = $_FILES['foto']['size'];
    $errMSG="";
    if(!empty($imgFile)){

        $upload_dir = 'uploads/'; // directorio donde vamos a subir
        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // extensión de la img
        //"Hola"->"hola"
        // extensiones  válidas
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
        // renombramos la imágen
        $coverpic = rand(1000,1000000).".".$imgExt;
        // chequeamos que la extensión sea válida
        if(in_array($imgExt, $valid_extensions)){
            // Chequeamos tamaño menor a 5mb
            if($imgSize < 5000000){
                                            //uploads/
                move_uploaded_file($tmp_dir,$upload_dir.$coverpic);
                $res=true;
            }else{
                $errMSG = "Tamaño muy grande.";
            }
        }else{
            $errMSG = "Formatos soportados: JPG, JPEG, PNG & GIF.";
        }
    }
    return array("res"=>$res,"error"=>$errMSG,"ruta"=>$upload_dir.$coverpic);
} 