    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.muestraBotones           = false;
        $rootScope.agregarDataObservacion   = false;
        $rootScope.actualizaData            = false;
        $rootScope.muestraData              = true;
        $rootScope.btnAgregarObs            = true;

        $rootScope.Situacion                = 0;
        $rootScope.Lote                     = '';
        $rootScope.Dimension                = '';
        $rootScope.RutCli                   = '';
        $rootScope.Cliente                  = '';
        $rootScope.Direccion                = '';
        $rootScope.CodigoVerificacion       = '';
        $rootScope.nObservacion             = '';
        $rootScope.fechaCertificado         = new Date();
        $rootScope.resultadoCertificacion   = '';

        $rootScope.tipoResultados = [
            {
                codRes:"A",
                descripcion:"ACEPTADO" 
            },{
                codRes:"R",
                descripcion:"RECHAZADO"
            }
            ];

    });
    app.controller('CtrlClientes', function($scope, $http)  { 
        $scope.leerClientes = function(){ 
            $http.get("leerCli.php")
            .then(function (response) {$scope.dataCli = response.data.records;});        
        };
        $scope.leerClientes();

        $scope.leerInformesAsociados = function(Rut){ 
            //alert($scope.RAMAR);
            $http.post("leerInfo.php",{ 
                                        CodInforme      : $scope.CodInformeAM, 
                                        RutCli          : Rut 
            }).then(function (response) { 
                $scope.dataInfo = response.data.records; 
                //alert($scope.CodInformeAM);
                if($scope.dataInfo == ''){
                    // alert('No existe infome(s) asociado(s)...');
                }
            }, function(error) {
                alert(error);
            });        
        };

        $scope.leerLosProductos = function(){ 
            $http.post("leerTiposProductos.php",{
                                        RutCli  : $scope.RutCli 
            }).then(function (response) { 
                $scope.dataProductos = response.data.records;
                if($scope.dataProductos == ''){
                    // alert('No existen Productos asociado(s)...'); 
                }
            }, function(error) {
                alert(error);
            });        
        };

        $scope.leerLosProductos();

        $scope.leerNormas = function(){ 
            //alert($scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                        CodCertificado  : $scope.CodCertificado,
                        accion  : "leerNormas"
            }).then(function (response) { 
                $scope.dataNormas = response.data.records;
                if($scope.dataNormas == ''){
                    // alert('No existen Productos asociado(s)...');
                }
            }, function(error) {
                alert(error);
            });        
        };

        $scope.leerObservacionesAsignadas = function(){ 
            //alert($scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                        CodCertificado  : $scope.CodCertificado,
                        accion  : "leerObservacionesAsignadas"
            }).then(function (response) { 
                $scope.dataObservacionesAs = response.data.records;
                if($scope.dataObservaciones == ''){
                    // alert('No existen Productos asociado(s)...');
                }
            }, function(error) {
                alert(error);
            });        
        };

        $scope.leerTodasObservaciones = function(){ 
            //alert($scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                        CodCertificado  : $scope.CodCertificado,
                        accion          : "leerTodasObservaciones"
            }).then(function (response) { 
                $scope.dataTodasObservaciones = response.data.records;
                if($scope.dataTodasObservaciones == ''){
                    alert('No existen Observaciones...');
                }
            }, function(error) {
                alert(error);
            });        
        };

        $scope.leerObservaciones = function(){ 
            //alert($scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                        CodCertificado  : $scope.CodCertificado,
                        accion          : "leerObservaciones"
            }).then(function (response) { 
                $scope.dataObservaciones = response.data.records;
                if($scope.dataObservaciones == ''){
                    alert('No existen Observaciones...');
                }
            }, function(error) {
                alert(error);
            });        
        };

        $scope.leerNormasAc = function(){ 
            //alert($scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                        CodCertificado  : $scope.CodCertificado,
                        accion  : "leerNormasAc"
            }).then(function (response) { 
                $scope.dataNormasAc = response.data.records;
                if($scope.dataNormas == ''){
                    // alert('No existen Productos asociado(s)...');
                }
            }, function(error) {
                alert(error);
            });        
        };

        $scope.leerNormasRefAsignadas = function(){ 
            //alert($scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                        CodCertificado  : $scope.CodCertificado,
                        accion  : "leerNormasRefAsignadas"
            }).then(function (response) { 
                $scope.dataNormasRefAs = response.data.records;
                if($scope.dataNormas == ''){
                    // alert('No existen Productos asociado(s)...');
                }
            }, function(error) {
                alert(error);
            });        
        };

        $scope.leerNormasAceptacionRechazo = function(){ 
            //alert($scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                        CodCertificado  : $scope.CodCertificado,
                        accion  : "leerNormasAceptacionRechazo"
            }).then(function (response) { 
                $scope.dataNormasAcRe = response.data.records;
                if($scope.dataNormas == ''){
                    // alert('No existen Productos asociado(s)...');
                }
            }, function(error) {
                alert(error);
            });        
        };

        //$scope.leerNormas();

        $scope.cambiarResultado = function(){
            $http.post("leerDatoCertificado.php",{
                CodCertificado          :   $scope.CodCertificado, 
                resultadoCertificacion  :   $scope.resultadoCertificacion, 
                accion                  :   'cambiarResultado'
            })
            .then(function(response){
                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });
        }

        $scope.gardarLote = function(){
            Lote = '';
            if($scope.Lote != undefined){ Lote = $scope.Lote};
            $http.post("leerDatoCertificado.php",{
                CodCertificado  :   $scope.CodCertificado, 
                Lote            :   Lote, 
                accion          :   'asignarLote'
            })
            .then(function(response){
                $scope.idCertificado            = response.data.idCertificado;
                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });
        }

        $scope.asignarObservaciones = function(CodCertificado, nObservacion){
            //alert('Entra '+CodCertificado+' '+nNorma);
            $http.post("leerDatoCertificado.php",{
                CodCertificado      :   CodCertificado, 
                nObservacion        :   nObservacion, 
                accion              :   'asignarObservaciones'
            })
            .then(function(response){
                
                $scope.leerObservaciones();
                $scope.leerObservacionesAsignadas();


                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });
        }

        $scope.asignarNormaRef = function(CodCertificado, nNorma){
            //alert('Entra '+CodCertificado+' '+nNorma);
            $http.post("leerDatoCertificado.php",{
                CodCertificado  :   CodCertificado, 
                nNorma          :   nNorma, 
                accion:'asignarNormaRef'
            })
            .then(function(response){

                $scope.leerNormas();
                $scope.leerNormasRefAsignadas();


                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });
        }

        $scope.asignarNormaAc = function(CodCertificado, nNorma){
            //alert('Entra '+CodCertificado+' '+nNorma);
            $http.post("leerDatoCertificado.php",{
                CodCertificado  :   CodCertificado, 
                nNorma          :   nNorma, 
                accion:'asignarNormaAc'
            })
            .then(function(response){

                $scope.leerNormasAc();
                $scope.leerNormasAceptacionRechazo(); // Aqui


                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });
        }

        $scope.quitarObservaciones = function(CodCertificado, nObservacion){
            //alert('Entra '+CodCertificado+' '+nNorma);
            $http.post("leerDatoCertificado.php",{
                CodCertificado  :   CodCertificado, 
                nObservacion    :   nObservacion, 
                accion          :   'quitarObservaciones'
            })
            .then(function(response){

                $scope.leerObservacionesAsignadas();


                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });
        }

        $scope.quitarNormaRef = function(CodCertificado, nNorma){
            //alert('Entra '+CodCertificado+' '+nNorma);
            $http.post("leerDatoCertificado.php",{
                CodCertificado  :   CodCertificado, 
                nNorma          :   nNorma, 
                accion:'quitarNormaRef'
            })
            .then(function(response){

                $scope.leerNormasRefAsignadas();


                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });
        }

        $scope.quitarNormaAcRe = function(CodCertificado, nNorma){
            //alert('Entra '+CodCertificado+' '+nNorma);
            $http.post("leerDatoCertificado.php",{
                CodCertificado  :   CodCertificado, 
                nNorma          :   nNorma, 
                accion:'quitarNormaAcRe'
            })
            .then(function(response){

                $scope.leerNormasAceptacionRechazo(); // Aqui Tambien


                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });
        }
        
        $scope.mostrarProducto = function(Producto){
            // alert($scope.nProducto+' '+$scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                CodCertificado  :   $scope.CodCertificado, 
                nProducto       :   $scope.nProducto, 
                accion:'guardarProducto'
            })
            .then(function(response){
                $scope.idCertificado            = response.data.idCertificado;

                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });

        }

        $scope.mostrarAcero = function(){
            // alert($scope.nProducto+' '+$scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                CodCertificado  :   $scope.CodCertificado, 
                nAcero          :   $scope.nAcero, 
                accion:'guardarAcero'
            })
            .then(function(response){
                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });

        }

        $scope.guardarDimension = function(){
            Dimension = '';
            if($scope.Dimension != undefined){ Dimension = $scope.Dimension; }
            $http.post("leerDatoCertificado.php",{
                CodCertificado      :   $scope.CodCertificado, 
                Dimension           :   Dimension, 
                accion              : 'guardarDimension'
            })
            .then(function(response){
                $scope.idCertificado            = response.data.idCertificado;
            }, function(error) {
                alert(error);
            });

        }
        $scope.guardarPeso = function(){
            // alert($scope.nProducto+' '+$scope.CodCertificado);
            $http.post("leerDatoCertificado.php",{
                CodCertificado      :   $scope.CodCertificado, 
                Peso                :   $scope.Peso, 
                accion:'guardarPeso'
            })
            .then(function(response){
                //alert('Guardado...');
            }, function(error) {
                alert(error);
            });

        }


        $scope.leerGradosAceros = function(){ 
            $http.post("leerGradosAceros.php",{
                                        RutCli  : $scope.RutCli 
            }).then(function (response) { 
                $scope.dataAceros = response.data.records;
                if($scope.dataAceros == ''){
                    alert('No Grados de aceros...');
                }
            }, function(error) {
                alert(error);
            });        
        };

        $scope.leerGradosAceros();

        $scope.loadDataCertificado = function(c){
            $scope.CodCertificado = c;
            $scope.Situacion = $scope.RutCli.length; 
            if($scope.CodCertificado.length >= 12){
                $http.post("leerDatoCertificado.php",{
                    CodCertificado  :   c, 
                    accion          :   'L'
                })
                .then(function(response){ 
                        $scope.RutCli                   = response.data.RutCli;
                        $scope.Contacto                 = response.data.Contacto;
                        $scope.Cliente                  = response.data.Cliente;
                        $scope.Direccion                = response.data.Direccion;
                        $scope.fechaCertificado         = new Date(response.data.fechaCertificado.replace(/-/g, '\/').replace(/T.+/, ''));
                        $scope.fechaUpLoad              = new Date(response.data.fechaUpLoad.replace(/-/g, '\/').replace(/T.+/, ''));
                        $scope.Lote                     = response.data.Lote;
                        $scope.CodCertificado           = response.data.CodCertificado;
                        $scope.CodInformeAM             = response.data.CodInforme;
                        $scope.idCertificado            = response.data.idCertificado;
                        $scope.RAMAR                    = response.data.RAMAR;
                        $scope.CodigoVerificacion       = response.data.CodigoVerificacion;
                        $scope.resultadoCertificacion   = response.data.resultadoCertificacion;
                        $scope.nProducto                = response.data.nProducto;
                        $scope.nAcero                   = response.data.nAcero;
                        $scope.Dimension                = response.data.Dimension;
                        $scope.Peso                     = response.data.Peso;
                        $scope.Estado                   = response.data.Estado;
                        $scope.pdf                      = response.data.pdf;
                        $scope.muestraBotones           = true;
                        if($scope.CodInformeAM){
                            $scope.mostrarQR($scope.CodInformeAM);
                        }
                        if($scope.pdf){
                            $scope.botonesUpCertificado = true; 
                        }
                        $scope.leerInformesAsociados($scope.RutCli);

                }, function(error) {
                    $scope.errors = error.message;
                    $scope.rutRes = error;
                });
            }
        }

        $scope.guardaContacto = function(){
            //alert($scope.Contacto);
            $http.post("leerDatoCertificado.php",{
                Contacto        :   $scope.Contacto, 
                CodCertificado  :   $scope.CodCertificado, 
                accion          :   'guardaContacto'
            })
            .then(function(response){
                //alert();
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });

        }

        $scope.mostrarQR = function(CodInforme){
            //alert(CodInforme);
            $http.post("leerDatoCertificado.php",{
                CodInforme      :   CodInforme, 
                CodCertificado  :   $scope.CodCertificado, 
                accion:'rescataCodigos'
            })
            .then(function(response){
                $scope.CodigoVerificacionAM   = response.data.CodigoVerificacion;
                $scope.idMuestra              = response.data.idMuestra;
                $scope.fechaTerminoTaller   = new Date(response.data.fechaTerminoTaller.replace(/-/g, '\/').replace(/T.+/, ''));
                $scope.imgQR                  = response.data.imgQR;
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }

        $scope.upCertificado = function(){
                $http.post("upLoadCertificado.php",{CodCertificado:$scope.CodCertificado, pdf:$scope.pdf, accion:'L'})
                    .then(function(response){
                      alert('Certificado en la nuve...');  
                      //$location.url("https://simet.cl/certificados/certificados/leerbd.php");
                }, function(error) {
                    $scope.errors = error.message;
                    $scope.rutRes = error;
                });
        }
        
        $scope.guardarDatosCertificado = function(){
            //alert($scope.RutCli);
            Grabar = true;
            //alert($scope.CodigoVerificacion);
            CodCertificado = $scope.CodCertificado.toUpperCase();
            //alert($scope.CodCertificado);
            if($scope.pdf){
                $scope.botonesUpCertificado = true;
            }

            $http.post("leerDatoCertificado.php",{
                                                    CodCertificado:CodCertificado, 
                                                    CodigoVerificacion:$scope.CodigoVerificacion, 
                                                    Lote:$scope.Lote, 
                                                    RutCli:$scope.RutCli, 
                                                    pdf:$scope.pdf, 
                                                    accion:'G'
                                               })
            .then(function(response){
                    $scope.rutRes = 'Registro grabado...'+CodCertificado;
                    $scope.muestraBotones = true;
                    $scope.loadDataCertificado(CodCertificado);
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
            
        }
        $scope.desabilitarDatos = function(){
            //alert($scope.RutCli);
            $http.post("leerDatoCertificado.php",{
                                                CodCertificado:$scope.CodCertificado, 
                                                accion:'D'
                                            })
                .then(function(response){
                    $scope.rutRes = 'Deshabilitado el registro...';
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }
        $scope.eliminarDatos = function(){
            //alert($scope.RutCli);
            $http.post("leerDatoCertificado.php",{
                                                CodCertificado:$scope.CodCertificado, 
                                                accion:'E'
                                            })
                .then(function(response){
                    $scope.rutRes = 'Eliminado el registro...';
                    location.href="index.php";
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }
        $scope.habilitarDatos = function(){
            //alert($scope.RutCli);
            $http.post("leerDatoCertificado.php",{
                                                CodCertificado:$scope.CodCertificado, 
                                                accion:'H'
                                            })
                .then(function(response){
                    $scope.rutRes = 'Habilitado...';
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }


        const $archivos = document.querySelector("#archivos");
        $scope.fileName = $archivos;
        $scope.enviarFormulario = function () { 
            $scope.botonesUpCertificado = true;
            let archivos = $archivos.files;
            if (archivos.length > 0) {
                let formdata = new FormData();

                // Agregar cada archivo al formdata
                angular.forEach(archivos, function (archivo) {
                    formdata.append(archivo.name, archivo);
                });
 
                // Finalmente agregamos el nombre
                formdata.append("CodCertificado", $scope.CodCertificado);
                $scope.res = formdata;
 
                // Hora de enviarlo
 
                // Primero la configuración
                let configuracion = {
                    headers: {
                        "Content-Type": undefined,
                    },
                    transformRequest: angular.identity,
                };
                // Ahora sí
                $http
                    .post("guardar_archivos.php", formdata, configuracion)
                    .then(function (respuesta) {
                        // alert("Después de enviar los archivos, el servidor dice:"+respuesta.data);
                        $scope.pdf = respuesta.data;
                        $scope.grabarPdf($scope.CodCertificado, $scope.pdf);
                    })
                    .catch(function (detallesDelError) {
                        //console.warn("Error al enviar archivos:", detallesDelError);
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
            } else {
                alert("Rellena el formulario y selecciona algunos archivos");
            }
        };

        $scope.grabarPdf = function(CodCertificado, pdf){
            $http.post("leerDatoCertificado.php",{
                CodCertificado  :   CodCertificado, 
                pdf             :   pdf, 
                accion          :   'grabarPdf'
           })
            .then(function(response){
                $scope.rutRes = 'Registro grabado...'+CodCertificado;
                $scope.muestraBotones = true;
                $scope.loadDataCertificado(CodCertificado);
            }, function(error) {
                $scope.errors = error.message;
            });

        }

        $scope.msgActivacion = function(){
            alert('Se activado Certificado en el sitio web...');
        }

        $scope.editarData = function(nObservacion, Observacion){
            $scope.muestraData      = false;
            $scope.actualizaData    = true;
            $scope.nObservacion     = nObservacion;
            $scope.Observacion      = Observacion;
            document.getElementById("observacion").focus();
        }

        $scope.agregarObservacion = function(){
            $scope.muestraData              = false;
            $scope.btnAgregarObs            = false;
            $scope.agregarDataObservacion   = true;


            $http.post("leerDatoCertificado.php",{
                accion          :   'buscarCodObservacion'
            })
            .then(function(response){
                    $scope.nObservacion = response.data.nObservacion;
            }, function(error) {
                $scope.errors = error.message;
            });
            
            $scope.Observacion              = '';
            document.getElementById("observacion").focus();
        }

        $scope.activarNormalidad = function(){
            $scope.muestraData              = true;
            $scope.actualizaData            = false;
            $scope.btnAgregarObs            = true;
            $scope.agregarDataObservacion   = false;
        }

        $scope.deshabilitaObservaciones = function(nObservacion){
            $http.post("leerDatoCertificado.php",{
                nObservacion    :   nObservacion, 
                accion          :   'deshabilitaObservaciones'
            })
            .then(function(response){
                $scope.leerTodasObservaciones();
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }
        $scope.habilitaObservaciones = function(nObservacion){
            $http.post("leerDatoCertificado.php",{
                nObservacion    :   nObservacion, 
                accion          :   'habilitaObservaciones'
            })
            .then(function(response){
                $scope.leerTodasObservaciones();
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }


        $scope.gardarFechaEmision = function(){
            //alert($scope.fechaCertificado);
            $http.post("leerDatoCertificado.php",{
                fechaCertificado    :   $scope.fechaCertificado, 
                CodCertificado      :   $scope.CodCertificado, 
                accion              :   'gardarFechaEmision'
            })
            .then(function(response){
                $scope.btnAgregarObs            = true;
                $scope.agregarDataObservacion   = false;

                $scope.leerTodasObservaciones();
            }, function(error) {
                $scope.errors = error.message;
            }); 
        }
        $scope.guardarData = function(){
            //alert($scope.nObservacion);
            $http.post("leerDatoCertificado.php",{
                nObservacion    :   $scope.nObservacion, 
                Observacion     :   $scope.Observacion, 
                accion          :   'actualizaObservaciones'
            })
            .then(function(response){
                $scope.btnAgregarObs            = true;
                $scope.agregarDataObservacion   = false;

                $scope.leerTodasObservaciones();
            }, function(error) {
                $scope.errors = error.message;
            });

            $scope.muestraData      = true;
            $scope.actualizaData    = false;
            // $scope.leerTodasObservaciones();
        }

    });
