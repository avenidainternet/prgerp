    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.Certificados         = false;
        $rootScope.Situacion            = 'New';
        $rootScope.RutCli               = '';
        $rootScope.Cliente              = '';
        $rootScope.Direccion            = '';
        $rootScope.ar                   = 'AR-';
        $rootScope.noBloqueo            = true;
        $rootScope.Bloqueo              = false;
        $rootScope.nColadaAct           = 0;


        $rootScope.fechaInspeccion      = new Date(); 

    });
    app.controller('CtrlAR', function($scope, $http)  { 
        $scope.leerClientes = function(){ 
            $http.get("leerCli.php")
            .then(function (response) {$scope.dataCli = response.data.records;});        
        };
        $scope.leerClientes();

        $scope.leerInspector = function(){  
            $http.get("leerIns.php")
            .then(function (response) {$scope.dataIns = response.data.records;});        
        };
        $scope.leerInspector();

        $scope.loadDataCertificado = function(ar){
            $scope.ar = ar;
                $http.post("leerDatoCertificado.php",{
                                                        ar:     ar, 
                                                        accion: 'L'
                                                    })
                    .then(function(response){
                        $scope.RutCli               = response.data.RutCli;
                        $scope.ar                   = response.data.ar;
                        $scope.codAr                = response.data.coAr;
                        $scope.RAMAR                = response.data.RAMAR;
                        $scope.CAMAR                = response.data.CAMAR;
                        $scope.fechaInspeccion      = new Date(response.data.fechaInspeccion.replace(/-/g, '\/').replace(/T.+/, ''));
                        $scope.nColadas             = response.data.nColadas;
                        $scope.Situacion            = response.data.Situacion;
                        $scope.certAsociado         = response.data.certAsociado;
                        //$scope.Bloqueo              = response.data.Bloqueo;
                        if(response.data.Bloqueo == 'Si'){
                            $scope.Bloqueo = true;
                            $scope.noBloqueo = false;
                        }
                        $scope.usr                  = response.data.usrInspector;
                        if($scope.Situacion == 'Old'){ $scope.Certificados = true; }
                        $scope.buscarCertificados();

                }, function(error) {
                    $scope.errors = error.message;
                    $scope.rutRes = error;
                });
        }

        $scope.buscarCertificados = function(){
            $http.post("leerDatoCertificado.php",{
                ar          : $scope.ar,
                accion      : "leerCertificadosConformidad"
            })
            .then(function(response){  
                $scope.Certificados = response.data.records;
            })    
        }

        $scope.crearCertificado = function(){ 
            let ar = $scope.ar+'-01'+'0'+$scope.nColadas;
            let swOk = true;
            // Validar info
            if($scope.RutCli == undefined){
                swOk = false;
                alert("Debe seleccionar un cliente...");
                document.getElementById("RutCli").focus();
            }
            else if($scope.nColadas == undefined){
                swOk = false;
                alert("Debe tener al menos 1 colada...");
                $scope.nColadas = 1;
                document.getElementById("nColadas").focus();
            }
            else if($scope.fechaInspeccion == undefined){
                swOk = false;
                alert("Debe ingresar una fecha valida...");
                $scope.fechaInspeccion      = new Date();
                document.getElementById("fechaInspeccion").focus();
            }
            else if($scope.usr == undefined){
                swOk = false;
                alert("Debe asignar un inspector...");
                document.getElementById("usr").focus();
            }
            // Fin Validacion
            if(swOk == true){
                //alert($scope.ar+' '+$scope.nColadas+' '+$scope.fechaInspeccion+' '+$scope.RutCli+' '+$scope.usr);

                $http.post("leerDatoCertificado.php",{
                    ar                  :   $scope.ar                       , 
                    nColadas            :   $scope.nColadas                 , 
                    fechaInspeccion     :   $scope.fechaInspeccion          ,  
                    RutCli              :   $scope.RutCli                   , 
                    usrInspector        :   $scope.usr                      , 
                    accion              :   'crearCertificadoConformidad'
               })
                .then(function(response){
                    //alert('Creado Certificado de Conformidad...'+$scope.ar);
                    $scope.certAsociado = 'No';
                    $scope.loadDataCertificado($scope.ar);
                }, function(error) {
                    $scope.errors = error.message;
                    $scope.rutRes = error;
                });
            }

            
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
        
        $scope.informarLE = function(){
            alert('Informando al LE '+$scope.ar+' '+$scope.RutCli+' RAMAR '+$scope.RAMAR);
            
            $http.post("leerDatoCertificado.php",{ 
                ar              : $scope.ar,
                RAMAR           : $scope.RAMAR,
                RutCli          : $scope.RutCli,
                nColadas        : $scope.nColadas,
                fechaInspeccion : $scope.fechaInspeccion,
                accion          : "informarLE"
            })
            .then(function(response){  
                $scope.loadDataCertificado($scope.ar);

            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
            
        }

        $scope.grabarFechaInspeccion = function(){
            //alert($scope.fechaInspeccion);
            
            $http.post("leerDatoCertificado.php",{
                ar              : $scope.ar,
                fechaInspeccion : $scope.fechaInspeccion,
                accion          : "grabarFechaInspeccion"
            })
            .then(function(response){  
                $scope.loadDataCertificado($scope.ar);
                //$scope.Certificados = response.data.records;
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
                        //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                        $scope.pdf = respuesta.data;
                    })
                    .catch(function (detallesDelError) {
                        //console.warn("Error al enviar archivos:", detallesDelError);
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
            } else {
                alert("Rellena el formulario y selecciona algunos archivos");
            }
        };

        $scope.msgActivacion = function(){
            alert('Se activado Certificado en el sitio web...');
        }


    });
