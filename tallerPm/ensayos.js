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
    $rootScope.Df                   = ''
});

app.controller('ctrlEnsayos', function($scope, $http) {
    $scope.Df                 = '';
    $scope.Otam                 = '';
    $scope.tpMuestra            = 'Re';
    $scope.muestraPlana         = false;
    $scope.muestraRedonda       = false;
    $scope.muestraEspecial      = false;
    //alert($scope.fechaRegistro);
    $scope.Observacion = '';


    const $archivosSeg = document.querySelector("#archivosSeguimiento"); 
    $scope.fileName = $archivosSeg;
    $scope.enviarFormularioSeg = function (evento) {
        //alert($scope.Otam);
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
                var id = $scope.Otam;
                // Ahora sí
                $http
                    .post("guardar_archivos.php?Otam="+id, formdata, configuracion)  
                    .then(function (respuesta) {
                        //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                        $scope.pdf = respuesta.data;
                        alert('Fichero subido correctamente...');
                        window.location.href = 'iTraccion.php?Otam='+$scope.Otam;
                    })
                    .catch(function (detallesDelError) {
                        //console.warn("Error al enviar archivos:", detallesDelError);
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
            } else {
                alert("Rellena el formulario y selecciona algunos archivos");
            }
    };









    
    $scope.loadEnsayo = function(Otam, CodInforme){
        // alert(Otam+' '+CodInforme);
        $scope.Otam = Otam;
        $scope.CodInforme = CodInforme;
        $http.post('registroData.php',{
            idEnsayo:   'Tr',
            Otam            : Otam,
            CodInforme      : CodInforme,
            accion          : "LeerOtams"
        })
        .then(function (response) {
            $scope.tpMuestra    = response.data.tpMuestra;
            $scope.Muestra      = response.data.Muestra;
            $scope.tecRes       = response.data.tecRes;
            if($scope.tpMuestra == 'Pl'){
                $scope.muestraPlana = true;
            }
            if($scope.tpMuestra == 'Re'){
                $scope.muestraRedonda = true;
            }
            if($scope.tpMuestra == 'Es'){
                $scope.muestraEspecial = true;
            }
            $scope.loadTraccion(Otam);
            //$scope.loadFicheros(Otam);
            //alert($scope.tpMuestra);
        }, function(error) {
            $scope.errors = error.message;
        });
    }

    $scope.loadFicheros = function(Otam){
        $http.post('registroData.php',{
            Otam:       Otam,
            accion:     "LeerArchivos"
        })
        .then(function (response) {
            $scope.dataFicheros = response.data.records;
            
        }, function(error) {
            $scope.errors = error.message;
            //alert(error);
        });

    }
    $scope.loadTraccion = function(Otam){
        //alert('Leer Traccion...'+$scope.Otam);
        var vcMax = 0;
        $http.post('registroData.php',{
            idEnsayo:   'Tr',
            Otam:       Otam,
            accion:     "LeerTraccion"
        })
        .then(function (response) {
            //alert('Entra...');
            $scope.tecRes           = response.data.tecRes;
            $scope.Di               = response.data.Di;
            $scope.Df               = response.data.Df;
            $scope.aIni             = response.data.aIni;
            $scope.cFlu             = response.data.cFlu;
            $scope.tFlu             = response.data.tFlu;
            $scope.Zporciento       = response.data.Zporciento;
            $scope.rAre             = parseInt(response.data.rAre);
            $scope.Espesor          = response.data.Espesor;
            $scope.tMax             = response.data.tMax;
            $scope.Temperatura      = response.data.Temperatura;
            $scope.Ancho            = response.data.Ancho;
            $scope.aSob             = response.data.aSob;
            $scope.Humedad          = response.data.Humedad;
            $scope.cMax             = response.data.cMax;
            vcMax                   = parseInt(response.data.cMax);
            $scope.vcMax            = vcMax;
            
            $scope.Observacion      = response.data.Observacion;
            $scope.Li               = response.data.Li;
            $scope.Lf               = response.data.Lf;
            if(response.data.fechaRegistro == '0000-00-00'){
                $scope.fechaRegistro = new Date();
            }else{
                $scope.fechaRegistro    = new Date(response.data.fechaRegistro.replace(/-/g, '\/').replace(/T.+/, ''));
            }
            $scope.aSob             = response.data.aSob;
        }, function(error) {
            $scope.errors = error.message;
        });
    }
    
    $scope.buscarMuestras = function(){
        $http.post('registroData.php',{
            idEnsayo:   'Tr',
            accion:     "Muestras"
        })
        .then(function (response) {
            $scope.dataMuestras = response.data.records;
            //console.log(response.data.records);
        }, function(error) {
            $scope.errors = error.message;
        });
        
    }

    $scope.buscarMuestras();

    $scope.Operadores = function(){
        $http.post('registroData.php',{
            accion:     "Operadores"
        })
        .then(function (response) {
            $scope.dataOperador = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
        });
        
    }

    $scope.Operadores();

    $scope.grabarDataMuestra = function(){
        // alert($scope.Otam+' '+$scope.tpMuestra);
        if($scope.tpMuestra == 'Pl'){
            $scope.muestraPlana     = true;
            $scope.muestraRedonda   = false;
            $scope.muestraEspecial  = false;
            $scope.rAre = '';
            $scope.Di = '';
        }
        if($scope.tpMuestra == 'Re'){
            $scope.muestraPlana     = false;
            $scope.muestraRedonda   = true;
            $scope.muestraEspecial  = false;
            $scope.Espesor = '';
            $scope.Ancho = '';
        }
        if($scope.tpMuestra == 'Es'){
            $scope.muestraPlana     = false;
            $scope.muestraRedonda   = false;
            $scope.muestraEspecial  = true;
            $scope.Observacion      = "Tracción Especial";
        }
        $http.post('registroData.php',{
            idEnsayo:   'Tr',
            Otam:       $scope.Otam,
            tpMuestra:  $scope.tpMuestra,
            accion:     "cambiarMuestra"
        })
        .then(function (response) {
            
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });

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
            tpMuestra:      $scope.tpMuestra    ,
            Estado:         Estado              ,
            Otam:           $scope.Otam         ,
            Espesor:        $scope.Espesor      ,
            Ancho:          $scope.Ancho        ,
            Li:             $scope.Li           , 
            Lf:             $scope.Lf           ,
            Di:             $scope.Di           ,
            Df:             $scope.Df           ,
            cMax:           $scope.cMax         ,
            tFlu:           $scope.tFlu         ,
            Observacion:    $scope.Observacion  ,
            Temperatura:    $scope.Temperatura  ,
            Humedad:        $scope.Humedad      ,
            fechaRegistro:  $scope.fechaRegistro,
            tecRes:         $scope.tecRes       ,
            accion:         "calcularGrabar" 
        })
        .then(function (response) {

            $scope.loadEnsayo($scope.Otam, $scope.CodInforme);
            $scope.loadTraccion($scope.Otam);
        }, function(error) {
            $scope.errors = error.message;
            alert(error);
        });

        window.location.href = 'formularios/otamTraccion.php?accion=Imprimir&RAM='+RAM+'&Otam='+$scope.Otam+'&CodInforme=';
        alert('Se guardó Otam '+$scope.Otam+' Aceptar para continuar...');
        window.location.href = 'iTraccion.php?Otam='+$scope.Otam+'&CodInforme='+$scope.CodInforme;
       


    }


    $scope.muestraFichero = function(f){
        alert(f);
        window.location.href = f;
    }

});