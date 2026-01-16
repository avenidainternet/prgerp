
<div class="row" style="padding: 10px;">

    <div class="col-xl-7">
        <div class="card">

            <div class="card-header">Usuarios</div>
            <div class="card-body">

                <table id="usuarios" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Usuario     </th>
                            <th>Cargo       </th>
                            <th>Firma       </th>
                            <th>CodiFi      </th>
                            <th>Perfiles    </th>
                            <th>Acciones    </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $link=Conectarse();
                            $SQL = "SELECT * FROM usuarios Order By usuario";
                            $firstUsr = '';

                            if(isset($_POST['usr']))                { $firstUsr = $_POST['usr'];    }
                            if(isset($_POST['EliminarUsuario']))    { $firstUsr = '';               }

                            $bd=$link->query($SQL);
                            while ($row=mysqli_fetch_array($bd)){
                                if($firstUsr == ''){
                                    $firstUsr = $row['usr'];
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row['usuario']; ?>  </td>
                                    <td><?php echo $row['cargoUsr']; ?> </td>
                                    <td><?php echo $row['firmaUsr']; ?> </td>
                                    <td><?php echo $row['usr']; ?>      </td>
                                    <td>
                                        <?php 
                                            $SQLpf = "SELECT * FROM perfiles Where IdPerfil = '".$row['nPerfil']."'";
                                            $bdpf=$link->query($SQLpf);
                                            if ($rowpf=mysqli_fetch_array($bdpf)){
                                                echo $rowpf['Perfil']; 
                                            }
                                        ?>      
                                    </td>
                                    <td>
                                        <?php
                                            if($row['status'] == 'off'){?>
                                                <a type="button" class="btn btn-danger" href="index.php?usr=<?php echo $row['usr']; ?>">Ver</a                                                <?php
                                            }else{?>
                                                <a type="button" class="btn btn-info" href="index.php?usr=<?php echo $row['usr']; ?>">Ver</a>
                                                <?php
                                            }
                                        ?>
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
                <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <b>Nuevo Usuario</b>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="usuario">Usuario:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nombre de Usuario" autofocus required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="cargoUsr">Cargo:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="cargoUsr" name="cargoUsr" placeholder="Cargo..." required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="nPerfil">Perfil:</label>
                                </div>
                                <div class="col-9">
                                    <select class="form-control" id="nPerfil" name="nPerfil" placeholder="Seleccione Perfil..." required />
                                        <option></option>
                                        <?php
                                            $link=Conectarse();
                                            $SQLpf = "SELECT * FROM perfiles Order By IdPerfil";
                                            $bdpf=$link->query($SQLpf);
                                            while ($rowpf=mysqli_fetch_array($bdpf)){?>
                                                <option value="<?php echo $rowpf['IdPerfil'];?>">
                                                    <?php echo $rowpf['Perfil'];?>
                                                </option>
                                                <?php
                                            }
                                            $link->close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="email">Correo :</label>
                                </div>
                                <div class="col-9">
                                    <input type="email" class="form-control" id="email" name="email"  placeholder="Correo" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="celular">Celular:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="celular" name="celular"  placeholder="+569..." required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="responsableInforme">Firma Informes:</label>
                                </div>
                                <div class="col-9">
                                    <select class="form-control" id="responsableInforme" name="responsableInforme"  placeholder="Firma Informe" required />
                                        
                                        <option value="on">Si</option>
                                        <option selected value="off">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="titPie">Pie Firma:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="titPie" name="titPie">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="apruebaOfertas">Aprueba Ofertas:</label>
                                </div>
                                <div class="col-9">
                                    <select class="form-control" id="apruebaOfertas" name="apruebaOfertas"  placeholder="Aprueba Informes" required />
                                        
                                        <option value="on">Si</option>
                                        <option selected value="off">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="usr">CodiFi:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="usr" name="usr" placeholder="Código de acceso" required maxlength="4" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="pwd">Password :</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="pwd" name="pwd"  placeholder="Password" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    
                                </div>
                                <div class="col-9">
                                    <?php
                                        if($row['firmaUsr']){
                                            $pieFirma = "../ft/".$row['firmaUsr'];
                                            ?>
                                            <img src="<?php echo $pieFirma; ?>">
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="imgFirma">Firma :</label>
                                </div>
                                <div class="col-9">
                                    <!-- <input type="hidden" name="MAX_FILE_SIZE"> -->
                                    <input name="imagen" type="file" id="imagen">
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

            if(isset($_GET['usr'])){ $firstUsr = $_GET['usr']; }

            $link=Conectarse();
            $SQL = "SELECT * FROM usuarios where usr = '$firstUsr'";
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
                <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <?php echo $row['usuario']; ?>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="usuario">Usuario:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $row['usuario']; ?>" placeholder="Nombre de Usuario" autofocus required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="cargoUsr">Cargo:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="cargoUsr" name="cargoUsr" value="<?php echo $row['cargoUsr']; ?>" placeholder="Cargo" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="nPerfil">Perfil:</label>
                                </div>
                                <div class="col-9">
                                    <select class="form-control" id="nPerfil" name="nPerfil" placeholder="Seleccione Perfil" required />
                                        <option></option>
                                        <?php
                                            $SQLpf = "SELECT * FROM perfiles Order By IdPerfil";
                                            $bdpf=$link->query($SQLpf);
                                            while ($rowpf=mysqli_fetch_array($bdpf)){
                                                if($rowpf['IdPerfil'] === $row['nPerfil']){?>
                                                    <option selected value="<?php echo $rowpf['IdPerfil'];?>">
                                                        <?php echo $rowpf['Perfil'];?>
                                                    </option>
                                                    <?php
                                                }else{?>
                                                    <option value="<?php echo $rowpf['IdPerfil'];?>">
                                                        <?php echo $rowpf['Perfil'];?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="email">Correo :</label>
                                </div>
                                <div class="col-9">
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" placeholder="email" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="celular">Celular:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $row['celular']; ?>" placeholder="Celular" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Firma Informes:</label>
                                </div>
                                <div class="col-9">
                                    <select class="form-control" id="responsableInforme" name="responsableInforme" placeholder="Seleccione Firma Informe" required />
                                        <?php
                                        if($row['responsableInforme'] == 'on'){?>
                                            <option selected value="on">Si</option>
                                            <option value="off">No</option>
                                            <?php
                                        }else{?>
                                            <option value="on">Si</option>
                                            <option selected value="off">No</option>
                                            <?php
                                        }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="titPie">Pie Firma:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="titPie" name="titPie" value="<?php echo $row['titPie']; ?>" placeholder="Pie de Firma" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="apruebaOfertas">Aprueba Ofertas:</label>
                                </div>
                                <div class="col-9">
                                    <select class="form-control" id="apruebaOfertas" name="apruebaOfertas"placeholder="Seleccione Aprueba Ofertas" required />
                                      <?php
                                        if($row['apruebaOfertas'] == 'on'){?>
                                            <option selected value="on">Si</option>
                                            <option value="off">No</option>
                                            <?php
                                        }else{?>
                                            <option value="on">Si</option>
                                            <option selected value="off">No</option>
                                            <?php
                                        }
                                        ?>
                                      </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="usr">CodiFi:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="usr" name="usr" value="<?php echo $row['usr']; ?>" maxlength="4" placeholder="Código de Acceso" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="pwd">Password :</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="pwd" name="pwd" value="<?php echo $row['pwd']; ?>" placeholder="Password" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    
                                </div>
                                <div class="col-9">
                                    <?php
                                        if($row['firmaUsr']){
                                            $pieFirma = "../ft/".$row['firmaUsr'];
                                            ?>
                                            <img src="<?php echo $pieFirma; ?>">
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="imgFirma">Firma :</label>
                                </div>
                                <div class="col-9">
                                    <!-- <input type="hidden" name="MAX_FILE_SIZE"> -->
                                    <input name="imagen" type="file" id="imagen">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" name="GuardarUsuario" class="btn btn-primary">
                            Guardar
                        </button>
                        <?php
                            if($row['status'] != 'off'){?>
                                <button type="submit" name="EliminarUsuario" class="btn btn-danger">
                                    Bloquear
                                </button>
                                <?php
                            }else{?>
                                <button type="submit" name="ActivarUsuario" class="btn btn-warning">
                                    Activar
                                </button>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                </form>
                <?php
            }
            $link->close();
        }
        ?>
    </div>
</div>