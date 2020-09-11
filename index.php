<!DOCTYPE html>
<html lang="es" class="h-80">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Divide Json</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body class="h-100">


    <?php 
        session_start(); 
    ?>
    
    <div class="container text-center h-100 center-block justify-content-center align-items-center">
        <div class="mx-auto mt-5">
            <h2>DIVIDE TUS JSONS</h2>
        </div>

        <div class="mx-auto">
            <img alt="JSON" width="300px" src="https://byspel.com/wp-content/uploads/2017/06/JSON-Logo.png">
        </div>
        


        <div class="mx-auto">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="form-group mx-auto mt-4 mb-4">
                    <label for="jsons" class="text-info">SELECCIONA LOS JSONS A SUBIR</label>
                    <span class="mx-auto">
                        <input type="file" class="form-control-file text-center" id="jsons[]" name="jsons[]" multiple accept=".json">
                    </span>
                    <input type="submit" value="Procesar" name="uploadBtn" class=" btn btn-primary pl-4 pr-4 mt-2" >
                </div>
            </form>
        </div>

        <!-- Mensajes de error -->
        <?php
                if (isset($_SESSION['message']) && $_SESSION['message'])
                {
                    echo '
                        <div class="alert alert-'.$_SESSION['message']['type'].' alert-dismissible fade show" role="alert">
                            '.$_SESSION['message']['msg'].'
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        ';
                    unset($_SESSION['message']);
                }
            ?>
      </div>    
      
      
</body>
</html>