
<div class="row" style="padding: 10px;">

    <div class="col-xl-7">
        <div class="card">

            <div class="card-header"><b>Perfiles de Usuario</b></div>
            <div class="card-body">

                <table id="usuarios" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id          </th>
                            <th>Perfil       </th>
                            <th>Acciones    </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $link=Conectarse();
                            $SQL = "SELECT * FROM perfiles Order By IdPerfil";
                            $firstUsr = '';

                            if(isset($_POST['IdPerfil']))           { $firstUsr = $_POST['IdPerfil'];   }
                            if(isset($_POST['EliminarUsuario']))    { $firstUsr = '';                   }

                            $bd=$link->query($SQL);
                            while ($row=mysqli_fetch_array($bd)){
                                if($firstUsr == ''){
                                    $firstUsr = $row['IdPerfil'];
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row['IdPerfil']; ?>  </td>
                                    <td>
                                        <?php 
                                            echo $row['Perfil'];
                                            $modulos = '';
                                            $SQLmm = "SELECT * FROM menugrupos Order By nMenu";
                                            $bdmm=$link->query($SQLmm);
                                            while ($rowmm=mysqli_fetch_array($bdmm)){
                                                $SQLpe = "SELECT * FROM modperfil where nMenu = '".$rowmm['nMenu']."' and IdPerfil = '".$row['IdPerfil']."'";
                                                $bdpe=$link->query($SQLpe);
                                                if ($rowpe=mysqli_fetch_array($bdpe)){
                                                    if($modulos){ 
                                                        $modulos .= ', '.$rowmm['nomMenu'];
                                                    }else{
                                                        $modulos .= $rowmm['nomMenu']; 
                                                    }
                                                }
                                            }
                                            if($modulos){
                                                echo '<br><b>('.$modulos.')</b>';
                                            }
                                        ?>   
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-info" href="index.php?IdPerfil=<?php echo $row['IdPerfil']; ?>">Ver</a>
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
    <div class="col-xl-5">
        <?php
            if(isset($_GET['Accion']) == 'Agregar'){
                if(isset($_POST['GuardarUsuario'])){?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Exito!</strong> REGISTRO AGREGADO CON EXITO ...
                    </div>                      
                <?php 
                }
                ?>
               <form action="index.php" method="post">
                <div class="card">
                    <div class="card-header">
                        <b>Nuevo Perfil</b>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="IdPerfil">Id Perfil:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="IdPerfil" name="IdPerfil" placeholder="Id Perfil" autofocus required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="Perfil">Perfil:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="Perfil" name="Perfil" placeholder="Nombre del Perfil" required />
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="submit" name="GuardarUsuario" class="btn btn-primary">
                            Guardar
                        </button>
                    </div>
                </div>
                </form>
 


                <?php
            }else{

            if(isset($_GET['IdPerfil'])){ $firstUsr = $_GET['IdPerfil']; }

            $link=Conectarse();
            $SQL = "SELECT * FROM perfiles where IdPerfil = '".$firstUsr."'";
            
            $bd=$link->query($SQL);
            if ($row=mysqli_fetch_array($bd)){
                if(isset($_POST['GuardarUsuario'])){?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Exito!</strong> REGISTRO GUARDADO CON EXITO ...
                    </div>                      
                <?php 
                }
                ?>
                <form action="index.php" method="post">
                <div class="card">
                    <div class="card-header">
                        <?php echo $row['Perfil']; ?>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="IdPerfil">Id Perfil:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="IdPerfil" name="IdPerfil" value="<?php echo $row['IdPerfil']; ?>" placeholder="Nombre del Perfil" autofocus required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="Perfil">Perfil:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="Perfil" name="Perfil" value="<?php echo $row['Perfil']; ?>" placeholder="Perfil" required />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" name="GuardarUsuario" class="btn btn-primary">
                            Guardar
                        </button>
                         <button type="submit" name="EliminarUsuario" class="btn btn-warning">
                            Eliminar
                        </button>
                       
                    </div>
                </div>
                </form>
                <?php
            }
            $link->close();
        }
        ?>
        <br>
        
        <div class="card">
            <div class="card-header"><b>Módulos Asociados al Perfil</b></div>
            <div class="card-body">

                <form action="index.php" method="post">
                <div class="card" style="padding: 5px;">
                    
                    <div class="row">
                        <div class="col-1">
                        </div>
                        <div class="col-10">
                            <div class="form-group">
                            <input name="IdPerfil" type="hidden" value="<?php echo $firstUsr; ?>" />
                            <label for="sel1">Agregar Módulo al perfil:</label>
                            <select class="form-control" id="nMenu" name="nMenu">

                                <?php
                                    $link=Conectarse();
                                    $i = 0;
                                    $SQLmp = "SELECT * FROM menugrupos Order By nMenu Asc";
                                    $bdmp=$link->query($SQLmp);
                                    while ($rowmp=mysqli_fetch_array($bdmp)){
                                        $SQLm = "SELECT * FROM modperfil Where nMenu = '".$rowmp['nMenu']."' and IdPerfil = '$firstUsr'";
                                        $bdm=$link->query($SQLm);
                                        if ($rowm=mysqli_fetch_array($bdm)){
                                        }else{
                                            $i++;
                                            ?>
                                            <option value="<?php echo $rowmp['nMenu']; ?>"><?php echo $rowmp['nomMenu']; ?></option>
                                            <?php
                                        }
                                    }
                                    $link->close();
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-1">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-1">
                        </div>
                        <div class="col-10">
                            <?php
                                if($i>0){?>
                                    <button type="submit" name="agregarModulo" class="btn btn-primary btn-block">
                                        Agregar Módulo al Perfil
                                    </button>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-1">
                        </div>

                    </div>
                </div>
                </form>
                <br>

                <table id="modulos" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#          </th>
                            <th>Módulos       </th>
                            <th>Acciones    </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $link=Conectarse();
                            $SQLmp = "SELECT * FROM modperfil where IdPerfil = '$firstUsr' Order By nMenu Asc";
                            $firstUsr = '';

                            if(isset($_POST['nMenu']))            { $nMenu = $_POST['nMenu'];   }

                            $bdmp=$link->query($SQLmp);
                            while ($rowmp=mysqli_fetch_array($bdmp)){?>
                                <tr>
                                    <td><?php echo $rowmp['nMenu']; ?>  </td>
                                    <td>
                                        <?php 
                                            $SQLm = "SELECT * FROM menugrupos Where nMenu = '".$rowmp['nMenu']."'";
                                            $bdm=$link->query($SQLm);
                                            if($rowm=mysqli_fetch_array($bdm)){
                                                echo $rowm['nomMenu'];
                                            } 
                                        ?>   
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-warning" href="index.php?IdPerfil=<?php echo $row['IdPerfil']; ?>&nMenu=<?php echo $rowm['nMenu']; ?>&accion=Quitar">Quitar</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            $link->close();
                            ?>
                    </tbody>
                </table> 



            </div>
        </div>
        



    </div>
</div>
