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

    $scope.loadDatosEspectometro = function(){
        $http.get('resultadosQu/vEspectrometro.json')
        .then(function (response) {
            $scope.dataEspectometro = response.data.records;
            $scope.cargarTablaOrientacion();
            $scope.cargarRamsEspectometro();
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

    }
    
    $scope.loadDatosEspectometro();


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
            // alert(x.RAM);
            if(x.Tipo == 'Average'){
                // alert(x.cCu);
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