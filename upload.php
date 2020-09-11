<?php
require_once('functions.php');
session_start();

$message = ''; 
$type_msg='success';
$_SESSION['ERROR_SLICE_FILES']=false;

//borramos la carpeta de divididos por si existía
__removeDirectoryAndFiles('slice_files');

//si se ha pulsado en procesar
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Procesar')
{
    // si existe algún fichero  y no existen errores en la subida
    if($_FILES["jsons"]["name"][0] && $_FILES['jsons']['error'][0] === UPLOAD_ERR_OK){
        
        // recorremos los ficheros
        for ($i=0; $i < count($_FILES["jsons"]["name"]); $i++) { 
           
            // detalles de los ficheros
            $fileTmpPath = $_FILES['jsons']['tmp_name'][$i];
            $fileName = $_FILES['jsons']['name'][$i];
            $fileSize = $_FILES['jsons']['size'][$i];
            $fileType = $_FILES['jsons']['type'][$i];
            
            // dividimos el nombre del fichero en un array
            $nombreFicheroArray = explode(".", $fileName);
            
            //end devuelve el ultimo elemento (extensión)
            $fileExtension = strtolower(end($nombreFicheroArray));

            // creamos un nombre de fichero único
            $newFileName = __createNewNameFile($fileName);

            // comprobamos si tiene alguna de las extensiones permitidas
            $allowedfileExtensions = array('json');
            if (in_array($fileExtension, $allowedfileExtensions))
            {
            
                // definimos el directorio donde se subirán
                $directory = './uploaded_files/';

                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                if(!file_exists($directory)){
                    mkdir($directory, 0777) or die("No se puede crear el directorio");	
                }

                //ruta de destino
                $dest_path = $directory . $newFileName;

                // subimos el ficheros a la ruta de destino
                if(move_uploaded_file($fileTmpPath, $dest_path)) 
                {
                    $message ='Ficheros subidos correctamente.';  $type_msg ="success";                  
                }
                else 
                {
                    $message = 'Hubo algún error al mover el archivo al directorio de carga. Asegúrese de que el servidor web pueda escribir en el directorio de carga.';
                    $type_msg ="danger";
                    $_SESSION['ERROR_UPLOAD_FILES']=true;
                }
            }
            else
            {
                $message = 'Subida fallida. Tipos de archivo permitidos: ' . implode(',', $allowedfileExtensions);
                $type_msg ="danger";
            }
        }


    }else{
        $message = 'Hay algún error en la carga del archivo. Compruebe el siguiente error.<br>';
        
        foreach ($_FILES['jsons']['error'] as $error ) {
            $message .= 'Error: ' .$error;

            /* Códigos de error: */
            /* $phpFileUploadErrors = array(
                0 => 'There is no error, the file uploaded with success',
                1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                3 => 'The uploaded file was only partially uploaded',
                4 => 'No file was uploaded',
                6 => 'Missing a temporary folder',
                7 => 'Failed to write file to disk.',
                8 => 'A PHP extension stopped the file upload.',
            );*/
        }
        $type_msg ="danger";
    }

    $_SESSION['message']['msg'] = $message;
    $_SESSION['message']['type'] = $type_msg;


    if (!$_SESSION['ERROR_UPLOAD_FILES']){
        gestionaJsons($directory);
        ($_SESSION['ERROR_SLICE_FILES']) ? $message.= "<br> HA HABIDO ALGÚN ERROR AL DIVIDIR LOS ARCHIVOS!!! " :$message.= "<br> Archivos divididos correctamente";
    }
    

    header("Location: index.php");
}

