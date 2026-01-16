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
    $rootScope.Df                   = '';
    $rootScope.Temperatura          = '19';
    $rootScope.Humedad              = '55';
    $rootScope.tecRes               = 'SML';
    $rootScope.msgUsr               = false;
});

app.controller('ctrlEspectometro', function($scope, $http) {
    $scope.Df                 = '';
    $scope.Otam                 = '';
    $scope.tpMuestra            = 'Re';
    $scope.muestraPlana         = false;
    $scope.muestraRedonda       = false;
    $scope.muestraEspecial      = false;
    //alert($scope.fechaRegistro);
    $scope.Observacion = '';




    $scope.enviarFormularioSeg = function (idItem) {
        //alert($scope.RAM);
        const $archivosSeg = document.querySelector("#archivosSeguimiento"); 
        $scope.fileName = $archivosSeg;
        let archivosSeg = $archivosSeg.files;
            if (archivosSeg.length > 0) {
                let formdata = new FormData();

                // Agregar cada archivo al formdata
                angular.forEach(archivosSeg, function (archivosSeg) {
                    formdata.append(archivosSeg.name, archivosSeg);
                });
 
                // Finalmente agregamos el nombre
                formdata.append("OTAM", $scope.Otam);
                //$scope.res = formdata;
 
                // Hora de enviarlo
 
                // Primero la configuración
                let configuracion = {
                    headers: {
                        "Content-Type": undefined,
                    },
                    transformRequest: angular.identity,
                };
                var id = $scope.RAM;
                // Ahora sí
                $http
                    .post("guardar_archivosOrientacion.php?RAM="+id, formdata, configuracion)  
                    .then(function (respuesta) {
                        //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                        $scope.pdf = respuesta.data;
                        $scope.actualizarTablaEnsayos($scope.RAM);
                        $scope.cargarRamsEspectometro();
                        alert('Fichero subido correctamente...');
                        //window.location.href = 'orientacion.php';
                    })
                    .catch(function (detallesDelError) {
                        //console.warn("Error al enviar archivos:", detallesDelError);
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
            } else {
                alert("Rellena el formulario y selecciona algunos archivos");
            }
    };












    $scope.cargarRamsEspectometro = function(){
        $http.post('registroData.php',{
            accion: "cargarRamsEspectometro"
        })
        .then(function (response) {
            $scope.dataRAMs = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }
    
    $scope.cargarRamsEspectometro();

    $scope.SelecionarEnsayo = function(idItem){
        $http.post('registroData.php',{
            idItem      : idItem,
            accion      : "SelecionarEnsayo"
        })
        .then(function (response) {
            $scope.actualizarTablaEnsayos($scope.RAM);
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }

    $scope.quitarEnsayo = function(idItem){
        //alert(RAM);
        $http.post('registroData.php',{
            idItem      : idItem,
            accion      : "quitarEnsayo"
        })
        .then(function (response) {
            $scope.actualizarTablaEnsayos($scope.RAM);
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }
    
    $scope.actualizarTablaEnsayos = function(RAM){
        //alert(RAM);
        $scope.RAM = RAM;
        $http.post('registroData.php',{
            RAM     : RAM,
            accion  : "actualizarTablaEnsayos" 
        })
        .then(function (response) {
            $scope.dataEnsayosDisponibles = response.data.records;
            $scope.mostrarEnsayosSeleccionados($scope.RAM);
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }

    $scope.mostrarEnsayosSeleccionados = function(RAM){
        //alert(RAM);
        $scope.RAM = RAM;
        $http.post('registroData.php',{
            RAM     : RAM,
            accion  : "mostrarEnsayosSeleccionados"
        })
        .then(function (response) {
            $scope.dataEnsayosSeleccionados = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }

    $scope.mostrarEnsayos = function(RAM){
        //alert(RAM);
        $scope.RAM = RAM;
        $http.post('registroData.php',{
            RAM     : RAM,
            accion  : "mostrarEnsayos"
        })
        .then(function (response) {
            $scope.dataEnsayos = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }






    $scope.cargarTablaOrientacion = function(){
        //alert($scope.dataEspectometro.length);
        for(var i = 0; i < $scope.dataEspectometro.length; i++){
            var x = $scope.dataEspectometro[i];
            //alert(x.RAM);
            if(x.Tipo == 'Average'){
                $http.post('registroData.php',{ 
                    idItem:         x.RAM,
                    accion:         "cargarTablaOrientacion"
                })
                .then(function (response) {
                    $scope.msgUsr = true;
                }, function(error) {
                    $scope.errors = error.message;
                    alert(error);
                });
            }

        }
       
    }




    $scope.registrarDatos = function(){
        for(var i = 0; i < $scope.dataEspectometro.length; i++){
            var x = $scope.dataEspectometro[i];
            //alert(x.RAM+' '+x.cC);
            if(x.Tipo == 'Average'){
                $http.post('registroData.php',{ 
                    idItem:         x.RAM,
                    fechaRegistro:  $scope.fechaRegistro,
                    Programa:       x.Programa,
                    Tipo:           x.Tipo,
                    Temperatura:    $scope.Temperatura,
                    Humedad:        $scope.Humedad,
                    tecRes:         $scope.tecRes,
                    cC:             x.cC,
                    cSi:            x.cSi,
                    cMn:            x.cMn,
                    cP:             x.cP,
                    cS:             x.cS,
                    cCr:            x.cCr,
                    cNi:            x.cNi,
                    cMo:            x.cMo,
                    cAl:            x.cAl,
                    cCu:            x.cCu,
                    cCo:            x.cCo,
                    cTi:            x.cTi,
                    cNb:            x.cNb,
                    cV:             x.cV,
                    cW:             x.cW,
                    cB:             x.cB,
                    cZn:            x.cZn,
                    cPb:            x.cPb,
                    cSn:            x.cSn,
                    cFe:            x.cFe,
                    cTe:            x.cTe,
                    cAs:            x.cAs,
                    cSb:            x.cSb,
                    cCd:            x.cCd,
                    cBi:            x.cBi, 
                    cAg:            x.cAg,
                    cZr:            x.cZr,
                    cAu:            x.cAu,
                    cSe:            x.cSe,
                    cMg:            x.cMg,
                    accion:         "grabarDatosQu"
                })
                .then(function (response) {
                    $scope.msg = 'Se ha registrado los datos a las tablas de los ensayos químicos...';
                    $scope.msgUsr = true;
                }, function(error) {
                    $scope.errors = error.message;
                    alert(error);
                });
            }
    
            
        }
    }





    $scope.Actualizando = function(){
        const myArray = $scope.Otam.split("-"); 
        var RAM = myArray[0];
        Estado = '';
        if($scope.tpMuestra == 'Re'){
            $scope.Espesor      = 0;
            $scope.Ancho        = 0;
            $scope.aSob         = 0;
            $scope.rAre         = 0;

            $scope.aIni         = 0;
            $scope.cFlu         = 0;
            $scope.tMax         = 0;
            $scope.Zporciento   = 0;
            $scope.UTS          = 0;
        }
        if($scope.tpMuestra == 'Pl'){
            $scope.Di           = 0;
            $scope.Df           = 0;
            //$scope.cMax         = 0;

            $scope.aIni         = 0;
            $scope.cFlu         = 0;
            $scope.tMax         = 0;
            $scope.Zporciento   = 0;
            $scope.UTS          = 0;
        }
        //alert($scope.Otam);

        $http.post('registroData.php',{
            idEnsayo:       'Tr',
            tpMuestra:      $scope.tpMuestra,
            Estado:         Estado,
            Otam:           $scope.Otam,
            Espesor:        $scope.Espesor,
            Ancho:          $scope.Ancho,
            Li:             $scope.Li,
            Lf:             $scope.Lf,
            Di:             $scope.Di,
            Df:             $scope.Df,
            cMax:           $scope.cMax,
            tFlu:           $scope.tFlu,
            Observacion:    $scope.Observacion,
            Temperatura:    $scope.Temperatura,
            Humedad:        $scope.Humedad,
            fechaRegistro:  $scope.fechaRegistro,
            accion:         "calcularGrabar"
        })
        .then(function (response) {
            $scope.loadEnsayo($scope.Otam);
            $scope.loadTraccion($scope.Otam);

        }, function(error) {
            $scope.errors = error.message;
            alert(error);
        });
        
        window.location.href = 'formularios/otamTraccion.php?accion=Imprimir&RAM='+RAM+'&Otam='+$scope.Otam+'&CodInforme=';
        alert('Se guardo correctamente el registro del ensayo'+$scope.Otam+'...');
        window.location.href = 'iTraccion.php?Otam='+$scope.Otam;
        
    }

    $scope.ActualizandoCerrado = function(){
        const myArray = $scope.Otam.split("-"); 
        var RAM = myArray[0];
        Estado = 'R';
        if($scope.tpMuestra == 'Re'){
            $scope.Espesor      = 0;
            $scope.Ancho        = 0;
            $scope.aSob         = 0;
            $scope.rAre         = 0;

            $scope.aIni         = 0;
            $scope.cFlu         = 0;
            $scope.tMax         = 0;
            $scope.Zporciento   = 0;
            $scope.UTS          = 0;
        }
        if($scope.tpMuestra == 'Pl'){
            $scope.Di           = 0;
            $scope.Df           = 0;
            //$scope.cMax         = 0;

            $scope.aIni         = 0;
            $scope.cFlu         = 0;
            $scope.tMax         = 0;
            $scope.Zporciento   = 0;
            $scope.UTS          = 0;
        }
        //alert($scope.Otam);

        $http.post('registroData.php',{
            idEnsayo:       'Tr',
            tpMuestra:      $scope.tpMuestra,
            Estado:         Estado,
            Otam:           $scope.Otam,
            Espesor:        $scope.Espesor,
            Ancho:          $scope.Ancho,
            Li:             $scope.Li,
            Lf:             $scope.Lf,
            Di:             $scope.Di,
            Df:             $scope.Df,
            cMax:           $scope.cMax,
            tFlu:           $scope.tFlu,
            Observacion:    $scope.Observacion,
            Temperatura:    $scope.Temperatura,
            Humedad:        $scope.Humedad,
            fechaRegistro:  $scope.fechaRegistro,
            accion:         "calcularGrabar"
        })
        .then(function (response) {
            $scope.loadEnsayo($scope.Otam);
            $scope.loadTraccion($scope.Otam);

        }, function(error) {
            $scope.errors = error.message;
            alert(error);
        });
        
        window.location.href = 'formularios/otamTraccion.php?accion=Imprimir&RAM='+RAM+'&Otam='+$scope.Otam+'&CodInforme=';
        alert('Se guardo correctamente el registro del ensayo'+$scope.Otam+'...');
        window.location.href = 'pTallerPM.php';
        
        
    }





});