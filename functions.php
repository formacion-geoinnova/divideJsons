<?php

function gestionaJsons($directory){
    $allFilesDirectory= __listFiles($directory);
    __divideFiles($allFilesDirectory, $directory);
}


/**
 * Devuelve un array de los archivos de un directorio dado
 */
function __listFiles($directorio)
{
    $aJsons = [];
    if (is_dir($directorio)) {
        if ($dir = opendir($directorio)) {
            while (($archivo = readdir($dir))) { //leer archivo por archivo
                if ($archivo != '.' && $archivo != '..' && $archivo != '.DS_Store' && $archivo != 'PASADOS') { //Omitimos los archivos del sistema . y .. y cualquier otro
                    $aJsons[] = $archivo;
                }
            }
            closedir($dir);
            //var_dump($aJsons);
        }
    } else {
        echo 'No Existe el directorio'; 
    }
    return $aJsons;
}


function __divideFiles($archivos,$directory){
    foreach ($archivos as $archivo) {
    
        $aEventosArchivoActual = json_decode(file_get_contents($directory.$archivo));
      
        //divido el array en 2 arrays
        $aEventos1 = array_slice($aEventosArchivoActual,0,count($aEventosArchivoActual)/2);        
        $aEventos2 = array_slice($aEventosArchivoActual,(count($aEventosArchivoActual)/2),count($aEventosArchivoActual));

    
        //guardamos los dos archivos divididos, que ahora están en 2 arrays
        __saveJson($aEventos1,$archivo);
        __saveJson($aEventos2,$archivo);

    }
   
    // si no ha habido errores al dividir y guardar borramos la carpeta de uploaded_files
    if (!$_SESSION['ERROR_SLICE_FILES']){
        __removeDirectoryAndFiles('uploaded_files');
    }
        
  
}

function __saveJson($contenido,$archivo)
{
    
    $directorio= './slice_files/';

    //Validamos si la ruta de destino existe, en caso de no existir la creamos
    if(!file_exists($directorio)){
        mkdir($directorio, 0777) or die("No se puede crear el directorio");	

    }
    
    $jsonContent = json_encode($contenido);
    $pathJson=$directorio.__createNewNameFile($archivo);
    
    // si devuelve falso es que ha habido algún error
    if (!file_put_contents($pathJson, $jsonContent)){
        $_SESSION['ERROR_SLICE_FILES'] = true;
    }
   
}

function __removeDirectoryAndFiles($carpeta){
    
      foreach(glob($carpeta . "/*") as $archivos_carpeta){             
        if (is_dir($archivos_carpeta)){
          rmDir_rf($archivos_carpeta);
        } else {
        unlink($archivos_carpeta);
        }
      }
      rmdir($carpeta);
}

function __createNewNameFile($fileName){
    // dividimos la cadena en un array
    $nombreFicheroArray = explode(".", $fileName);
            
    //end devuelve el ultimo elemento del array
    $fileExtension = strtolower(end($nombreFicheroArray));

    // sanitize file-name
    $newFileName = md5(time().rand(0,10000). $fileName) . '.' . $fileExtension;
    return $newFileName;
}