

    <?php


    require_once 'config.php';

     
    $nombre = $apellido = $edad = "";

    $nombre_err = $apeliido_err = $edad_err = "";

    
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Validamos Nombre

        $input_nombre = trim($_POST["nombre"]);

        if(empty($input_nombre)){

            $nombre_err = "Ingrese Nombre";

        } elseif(!filter_var(trim($_POST["nombre"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){

            $nombre_err = 'Ingrese un Nombre Valido';

        } else{

            $nombre = $input_nombre;

        }

        

        // Validamos Apellido

        $input_apellido = trim($_POST["apellido"]);

        if(empty($input_apellido)){

            $apeliido_err = 'Ingrese un Apellido';     

        } else{

            $apellido = $input_apellido;

        }

        

        // Validamos Edad

        $input_edad = trim($_POST["edad"]);

        if(empty($input_edad)){

            $edad_err = " Ingrese Erdad ";     

        } elseif(!ctype_digit($input_edad)){

            $edad_err = ' Ingrese un Texto ';

        } else{

            $edad = $input_edad;

        }


 
        if(empty($nombre_err) && empty($apeliido_err) && empty($edad_err)) {

            // Insertamos datos

            $sql = "INSERT INTO estudiantes (nombre, apellido, edad) VALUES (?, ?, ?)";

             

            if($stmt = mysqli_prepare($link, $sql)){

                // Preparamos las variables como parametros

                mysqli_stmt_bind_param($stmt, "sss", $param_nombre, $param_apellido, $param_edad);

                

                // Seteamos Nuestros Parametros

                $param_nombre = $nombre;

                $param_apellido = $apellido;

                $param_edad = $edad;

                // Ejecutamos los parametros

                if(mysqli_stmt_execute($stmt)){

                    // Records created successfully. Redirect to landing page

                    header("location: index.php");

                    exit();

                } else{

                    echo "Algo esta mal, intenta otra vez.";

                }

            }

             

            // Close statement

            mysqli_stmt_close($stmt);

        }

        

        // Close connection

        mysqli_close($link);

    }

    ?>

     

    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Crear</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">

            .wrapper{

                width: 500px;

                margin: 0 auto;

            }

        </style>

    </head>

    <body>

        <div class="wrapper">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-12">

                        <div class="page-header">

                            <h2>Crear Dato</h2>

                        </div>

                        <p>Completa para enviar la informacion</p>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                            <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">

                                <label>Nombre</label>

                                <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">

                                <span class="help-block"><?php echo $nombre_err;?></span>

                            </div>

                            <div class="form-group <?php echo (!empty($apeliido_err)) ? 'has-error' : ''; ?>">

                                <label>Apellido</label>

                                <textarea name="apellido" class="form-control"><?php echo $apellido; ?></textarea>

                                <span class="help-block"><?php echo $apeliido_err;?></span>

                            </div>

                            <div class="form-group <?php echo (!empty($edad_err)) ? 'has-error' : ''; ?>">

                                <label>Edad</label>

                                <input type="text" name="edad" class="form-control" value="<?php echo $edad; ?>">

                                <span class="help-block"><?php echo $edad_err;?></span>

                            </div>

                            <input type="submit" class="btn btn-primary" value="Submit">

                            <a href="index.php" class="btn btn-default">Cancel</a>

                        </form>

                    </div>

                </div>        

            </div>

        </div>

    </body>

    </html>

