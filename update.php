

    <?php


    require_once 'config.php';

     

    $nombre = $apellido = $edad = "";

    $nombre_err = $apellido_err = $edad_err = "";

     

    if(isset($_POST["id"]) && !empty($_POST["id"])){

        $id = $_POST["id"];

        
        $input_nombre = trim($_POST["nombre"]);

        if(empty($input_nombre)){

            $nombre_err = "Ingrese Nombre";

        } elseif(!filter_var(trim($_POST["nombre"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){

            $nombre_err = 'Ingrese Nombre';

        } else{

            $nombre = $input_nombre;

        }

        


        $input_apellido = trim($_POST["apellido"]);

        if(empty($input_apellido)){

            $apellido_err = 'Ingrese Apellido';     

        } else{

            $apellido = $input_apellido;

        }



        $input_edad = trim($_POST["edad"]);

        if(empty($input_edad)){

            $edad_err = "Ingrese Edad ";     

        } elseif(!ctype_digit($input_edad)){

            $edad_err = 'Ingrese Edad ';

        } else{

            $edad = $input_edad;

        }

        


        if(empty($nombre_err) && empty($apellido_err) && empty($edad_err)){

        
            $sql = "UPDATE estudiantes SET nombre=?, apellido=?, edad=? WHERE id=?";

             

            if($stmt = mysqli_prepare($link, $sql)){



                mysqli_stmt_bind_param($stmt, "sssi", $param_nombre, $param_apellido, $param_edad, $param_id);

                

                $param_nombre = $nombre;

                $param_apellido = $apellido;

                $param_edad = $edad;

                $param_id = $id;

                

                if(mysqli_stmt_execute($stmt)){


                    header("location: index.php");

                    exit();

                } else{

                    echo "Algo anda mal, intenta de nuevo";

                }

            }

             


            mysqli_stmt_close($stmt);

        }

        

        mysqli_close($link);

    } else{


        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){


            $id =  trim($_GET["id"]);

            


            $sql = "SELECT * FROM estudiantes WHERE id = ?";

            if($stmt = mysqli_prepare($link, $sql)){


                mysqli_stmt_bind_param($stmt, "i", $param_id);

                $param_id = $id;


                if(mysqli_stmt_execute($stmt)){

                    $result = mysqli_stmt_get_result($stmt);

        

                    if(mysqli_num_rows($result) == 1){

                    

                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                        

                        // Retrieve individual field value

                        $nombre = $row["nombre"];

                        $apellido = $row["apellido"];

                        $edad = $row["edad"];

                    } else{

                        header("location: error.php");

                        exit();

                    }

                    

                } else{

                    echo "Algo anda mal, Intenta de nuevo";

                }

            }

            

            mysqli_stmt_close($stmt);


            mysqli_close($link);

        }  else{


            header("location: error.php");

            exit();

        }

    }

    ?>

     

    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Actualizar</title>

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

                            <h2>Actualizar Datos</h2>

                        </div>

                        <p>Edita y envia los datos</p>

                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                            <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">

                                <label>Nombre</label>

                                <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">

                                <span class="help-block"><?php echo $nombre_err;?></span>

                            </div>

                            <div class="form-group <?php echo (!empty($apellido_err)) ? 'has-error' : ''; ?>">

                                <label>Apellido</label>

                                <textarea name="apellido" class="form-control"><?php echo $apellido; ?></textarea>

                                <span class="help-block"><?php echo $apellido_err;?></span>

                            </div>

                            <div class="form-group <?php echo (!empty($edad_err)) ? 'has-error' : ''; ?>">

                                <label>Edad</label>

                                <input type="text" name="edad" class="form-control" value="<?php echo $edad; ?>">

                                <span class="help-block"><?php echo $edad_err;?></span>

                            </div>

                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>

                            <input type="submit" class="btn btn-primary" value="Submit">

                            <a href="index.php" class="btn btn-default">Cancel</a>

                        </form>

                    </div>

                </div>        

            </div>

        </div>

    </body>

    </html>

