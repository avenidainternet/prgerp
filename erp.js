var app = angular.module('myApp', []);
app.filter('formatoNumero', function() {
    return function(x) {
      if (x == null) {
        return null;
      }
  
      if (x == undefined) { 
        return undefined; 
      }
  
      let str = '';
      let rest, floor;
  
      do {
        rest = x % 1000;
        floor = Math.floor(x / 1000);
  
        str = (floor == 0) ? rest + str : '.' + x.toString().slice(-3) + str;
  
        x = Math.floor(x / 1000);
      } while (x > 0);
  
      return str;
    }
});

app.run(function($rootScope){
    $rootScope.fechaRegistro        = new Date();
    $rootScope.activaHes            = false;
    $rootScope.clienteHES           = false;
    $rootScope.HES                  = '';
});

app.controller('ctrlCAM', function($scope, $http) {
    $scope.CAM          = '';
    $scope.RAM          = '';
    $scope.cColor       = '';
    $scope.bColor       = '';



    const $archivosSeg = document.querySelector("#archivosSeguimiento");
    $scope.fileName = $archivosSeg;
    $scope.enviarFormularioRosado = function (evento) {
        //alert('Entra '+$scope.CAM);
        let archivosSeg = $archivosSeg.files;
            if (archivosSeg.length > 0) {
                let formdata = new FormData();

                // Agregar cada archivo al formdata
                angular.forEach(archivosSeg, function (archivosSeg) {
                    formdata.append(archivosSeg.name, archivosSeg);
                });
 
                // Finalmente agregamos el nombre
                formdata.append("CAM", $scope.CAM);
                //$scope.res = formdata;
 
                // Hora de enviarlo
 
                // Primero la configuración
                let configuracion = {
                    headers: {
                        "Content-Type": undefined,
                    },
                    transformRequest: angular.identity,
                };
                var id = $scope.Otam;
                // Ahora sí
                $http
                    .post("guardar_archivosOC.php?CAM="+$scope.CAM , formdata, configuracion) 
                    .then(function (respuesta) {
                        //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                        $scope.pdf = respuesta.data;
                        alert('OC subida correctamente...');
                        //window.location.href = 'segAM.php?CAM='+$scope.CAM+'&RAM='+$scope.RAM+'&Rev=0&Cta=0';
                    })
                    .catch(function (detallesDelError) {
                        //console.warn("Error al enviar archivos:", detallesDelError);
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
            } else {
                if($scope.archivosSeguimiento == ''){
                    alert("No se ha seleccionado ningún archivo para subir...");
                }
            }
    };



    const $archivosSegHES = document.querySelector("#archivosSeguimientoHES");
    $scope.fileName = $archivosSegHES;
    $scope.enviarFormularioRosadoHES = function (evento) {
        // alert($scope.CAM);
        let archivosSeg = $archivosSegHES.files;
            if (archivosSeg.length > 0) {
                let formdata = new FormData();

                // Agregar cada archivo al formdata
                angular.forEach(archivosSeg, function (archivosSeg) {
                    formdata.append(archivosSeg.name, archivosSeg);
                });
 
                // Finalmente agregamos el nombre
                formdata.append("CAM", $scope.CAM);
                //$scope.res = formdata;
 
                // Hora de enviarlo
 
                // Primero la configuración
                let configuracion = {
                    headers: {
                        "Content-Type": undefined,
                    },
                    transformRequest: angular.identity,
                };
                var id = $scope.CAM;
                // Ahora sí
                $http
                    .post("guardar_archivosHES.php?CAM="+$scope.CAM , formdata, configuracion) 
                    .then(function (respuesta) {
                        //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                        $scope.pdf = respuesta.data;
                        alert('Fichero subido correctamente...');
                        //window.location.href = 'segAM.php?CAM='+$scope.CAM+'&RAM='+$scope.RAM+'&Rev=0&Cta=0';
                    })
                    .catch(function (detallesDelError) {
                        //console.warn("Error al enviar archivos:", detallesDelError);
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
            } else {
                if($scope.archivosSeguimientoHES == ''){
                    // alert("No se ha seleccionado ningún archivo para subir...");
                }
            }
    };
















    
    $scope.retocederATerminadosSinInforme = function(){
        $http.post('registroDataErp.php',{ 
            CAM:        $scope.CAM,
            RAM:        $scope.RAM,
            Fan:        $scope.Fan,
            HES:        '',
            nOC:        '',
            accion:     "volverTrabajosSinInformes"
        })
        .then(function (response) {
            alert('Registro AM enviado al paso anterior...');
            window.location.href = 'plataformaErp.php?CAM='+$scope.CAM;
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }

    $scope.retocederSeguimientoRosado = function(){
        $http.post('registroDataErp.php',{ 
            CAM:        $scope.CAM,
            RAM:        $scope.RAM,
            Fan:        $scope.Fan,
            HES:        $scope.HES,
            nOC:        '',
            accion:     "grabarAmRosado"
        })
        .then(function (response) {
            alert('Registro AM enviado al paso anterior...');
            window.location.href = 'plataformaErp.php?CAM='+$scope.CAM;
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }
    $scope.guardarSeguimientoRosado = function(){
        $scope.enviarFormularioRosado()
        $scope.enviarFormularioRosadoHES()
        $http.post('registroDataErp.php',{ 
            CAM:        $scope.CAM,
            RAM:        $scope.RAM, 
            Fan:        $scope.Fan,
            nOC:        $scope.nOC,
            HES:        $scope.HES,
            accion:     "grabarAmRosado"
        })
        .then(function (response) {
            alert('Registro guardado correctamente...');
            window.location.href = 'plataformaErp.php?CAM='+$scope.CAM;
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }

    $scope.existeOC = function(){
        $scope.activaUp = true;
    }

    $scope.activarSubidaOC = function(){
        if($scope.nOC != ''){
            $scope.activaUp = true;
        }else{
            $scope.activaUp = false;
        }
    }

    $scope.activarSubidaHES = function(){
        if($scope.HES != ''){
            $scope.activaHes = true;
        }else{
            $scope.activaHes = false;
        }
    }

    $scope.loadCAM = function(CAM, RAM, accion){
        $scope.CAM      = CAM;
        $scope.RAM      = RAM;
        $scope.cColor   = accion;

        if(accion == 'Amarillo'){ $scope.bColor = 'bg-warning text-dark' }
        if(accion == 'Rosado')  { $scope.bColor = 'bg-danger text-white' }
        
        $http.post('registroData.php',{
            CAM:        $scope.CAM,
            RAM:        $scope.RAM,
            accion:     "LeerCAM"
        })
        .then(function (response) {
            $scope.CAM              = response.data.CAM;
            $scope.RAM              = response.data.RAM;
            $scope.nOC              = response.data.nOC;
            $scope.HES              = response.data.HES;
            $scope.HEScli           = response.data.HEScli;
            $scope.Cliente          = response.data.Cliente;
            $scope.Contacto         = response.data.Contacto;
            $scope.Fan              = response.data.Fan;
            $scope.obsServicios     = response.data.obsServicios;
            $scope.informeUP        = response.data.informeUP;
            $scope.fechaInformeUP   = new Date(response.data.fechaInformeUP.replace(/-/g, '\/').replace(/T.+/, ''));
            $scope.nContacto        = response.data.nContacto;
            $scope.usrCotizador     = response.data.usrCotizador;
            $scope.usrResponzable   = response.data.usrResponzable;
            $scope.archivosSeguimiento = "archivo.pdf";
            console.log($scope.HEScli);
            if($scope.nOC != '')        { $scope.activaUp = true; }
            if(response.data.HEScli == 'on')    { $scope.clienteHES = true; }
            if(response.data.HEScli == '')      { $scope.clienteHES = false; }
            if(response.data.HEScli == 'off')   { $scope.clienteHES = false; }
            // $scope.clienteHES = true;
        }, function(error) {
            alert(error);
        });
    }

});