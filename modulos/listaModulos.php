
<div class="row" style="padding: 10px;">

    <div class="col-xl-7">
        <div class="card">

            <div class="card-header"><b>Menú</b></div>
            <div class="card-body">

                <table id="usuarios" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#          </th>
                            <th>Módulos     </th>
                            <th>Acciones    </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $link=Conectarse();
                            $SQL = "SELECT * FROM modulos Order By nModulo";
                            $firstModulo = '';

                            if(isset($_POST['nModulo']))         { $firstModulo = $_POST['nModulo'];   }
                            if(isset($_POST['EliminarModulo']))    { $firstModulo = '';                   }

                            $bd=$link->query($SQL);
                            while ($row=mysqli_fetch_array($bd)){
                                if($firstModulo == ''){
                                    $firstModulo = $row['nModulo'];
                                }
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row['nModulo']; ?>  </td>
                                    <td>
                                        <span class="<?php echo $row['iconoMod']; ?>">
                                        </span>
                                        <?php 
                                            echo $row['Modulo'];
                                        ?>   
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-info" href="index.php?nModulo=<?php echo $row['nModulo']; ?>">Ver</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            $link->close();
                            ?>
                    </tbody>
                </table>      
            </div> 
            <div class="card-footer">
                

            </div>
        </div>
    </div>
    <div class="col-xl-5" ng-app="myApp" ng-controller="custCtr">
        <?php
            if(isset($_GET['nModulo'])){ $firstModulo = $_GET['nModulo']; }
            if(isset($_POST['GuardarModulo'])){?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Exito!</strong> REGISTRO GUARDADO CON EXITO ...
                </div>                      
            <?php 
            }
            if(isset($_GET['Accion'])) { $firstModulo = ''; }
            $link=Conectarse();
            $SQL = "SELECT * FROM modulos where nModulo = '".$firstModulo."'";
            $bd=$link->query($SQL);
            if ($row=mysqli_fetch_array($bd)){

            }
            $link->close();
        ?>
        {{res}}
        <form action="index.php" method="post">
                <div class="card">
                    <div class="card-header">
                        <b>
                        <?php 
                            if(isset($_GET['Accion'])) { echo 'Nuevo Módulo'; }
                            echo 'Módulo '.$row['Modulo']; 
                        ?>
                        </b>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="nModulo">Id Módulo:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nModulo" name="nModulo" value="<?php echo $row['nModulo']; ?>" placeholder="Id del Módulo" autofocus required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="Perfil">Nombre Modulo:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="Modulo" name="Modulo" value="<?php echo $row['Modulo']; ?>" placeholder="Nombre del Módulo" ng-model="Modulo" ng-init="Modulo='<?php echo $row['Modulo']; ?>'" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="dirProg">Link:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="dirProg" name="dirProg" value="<?php echo $row['dirProg']; ?>" placeholder="Link Programa" ng-model="dirProg" ng-init="dirProg='<?php echo $row['dirProg']; ?>'" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="iconoMod">          Ícono:                                         
                                    </label>
                                </div>
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-1">
                                            <span style="padding-top: 10px;" class="<?php echo $row['iconoMod']; ?>"></span>
                                        </div>
                                        <div class="col-11">
                                            <input type="text" class="form-control" id="iconoMod" name="iconoMod" value="<?php echo $row['iconoMod']; ?>" placeholder="Ícono" ng-model="iconoMod" ng-init="iconoMod='<?php echo $row['iconoMod']; ?>'" />
                                            <a href="https://www.w3schools.com/icons/fontawesome5_icons_writing.asp" target="_blank">Íconos</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" name="GuardarModulo" class="btn btn-primary">
                            Guardar
                        </button>
                        <button type="submit" ng-click="modi()" class="btn btn-primary">
                            Guardar Reg.
                        </button>
                        <?php
                            if(!isset($_GET['Accion'])) {?>
                                <button type="submit" name="EliminarModulo" class="btn btn-warning">
                                    Eliminar
                                </button>
                                <?php
                            }
                        ?>
                    </div>
                </div>
        </form>
    </div>
</div>