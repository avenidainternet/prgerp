    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.muestraBotones       = false;
        $rootScope.Situacion            = 0;
        $rootScope.RutCli               = '';
        $rootScope.Cliente              = '';
        $rootScope.Direccion            = '';
        $rootScope.CodigoVerificacion   = '';
        $rootScope.fechaCertificado     = new Date();
        $rootScope.tipoHes = [
            {
                codHes:"on",
                descripcion:"Requiere HES" 
            },{
                codHes:"off",
                descripcion:"Sin HES"
            }
            ];

    });
    app.controller('CtrlClientes', function($scope, $http)  { 
        $scope.leerClientes = function(){ 
            $http.get("leerCli.php")
            .then(function (response) {$scope.dataCli = response.data.records;});        
        };
        $scope.leerClientes();

        $scope.loadDataCertificado = function(c){
            $scope.CodCertificado = c;
            $scope.Situacion = $scope.RutCli.length;
            if($scope.CodCertificado.length >= 12){
                $http.post("leerDatoCertificado.php",{CodCertificado:c, accion:'L'})
                    .then(function(response){
                        $scope.RutCli               = response.data.RutCli;
                        $scope.Contacto             = response.data.Contacto;
                        $scope.fechaUpLoad          = response.data.fechaUpLoad;
                        $scope.Lote                 = response.data.Lote;
                        $scope.CodCertificado       = response.data.CodCertificado;
                        $scope.CodigoVerificacion   = response.data.CodigoVerificacion;
                        $scope.Estado               = response.data.Estado;
                        $scope.pdf                  = response.data.pdf;
                        $scope.muestraBotones       = true;
                        if($scope.pdf){
                            $scope.botonesUpCertificado = true; 
                        }
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
