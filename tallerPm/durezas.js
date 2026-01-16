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
    $rootScope.fechaRegistro            = new Date();
    $rootScope.Df                       = '';
    $rootScope.Temperatura              = '19';
    $rootScope.Humedad                  = '55';
    $rootScope.ficherosDurezas          = false;
    $rootScope.resultadosDurezas        = false;
    $rootScope.muestraOtamsDurezas      = false;
});

app.controller('ctrlEspectometro', function($scope, $http) {
    $scope.Df                 = '';
    $scope.Otam                 = '';
    $scope.tpMuestra            = 'Re';


    const $archivosSeg = document.querySelector("#archivosSeguimiento");
    $scope.fileName = $archivosSeg;
    $scope.enviarFormularioSeg = function (evento) {

        
            let archivosSeg = $archivosSeg.files;
            if (archivosSeg.length > 0) {
                let formdata = new FormData();
                
                angular.forEach(archivosSeg, function (archivosSeg) {
                    formdata.append(archivosSeg.name, archivosSeg);
                });
                // alert($scope.Otam);
                
                formdata.append("OTAM", $scope.Otam);
                let configuracion = {
                    headers: {
                        "Content-Type": undefined,
                    },
                    transformRequest: angular.identity, 
                };
                var id = $scope.Otam;
                $http
                    .post("guardar_archivosTracciones.php?Otam="+id, formdata, configuracion) 
                    .then(function (respuesta) {
                        $scope.pdf = respuesta.data;

                        $scope.mostrarTracciones($scope.RAM);
                        alert('Fichero subido correctamente OTAM...'+id);
                        $scope.resultadosTracciones = true;
                        $scope.dataTraccionesTabla();

                        $scope.ficherosTracciones = false;
                        $scope.TraccionesEnsayar();
                
                        //window.location.href = 'lectorTracciones.php';
                    })
                    .catch(function (detallesDelError) {
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
                
            }
            
    };


    $scope.DurezasEnsayar = function(){
        $http.post('dataControlDurezas.php',{
            accion:     "dataControlDurezas" 
        })
        .then(function (response) {
            $scope.dataDurezas = response.data.records;    
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });
    }

    $scope.DurezasEnsayar();

    $scope.mostrarDurezas = function(RAM){
        $scope.RAM = RAM;
        $scope.muestraOtamsTracciones   = true;
        $scope.ficherosDurezas       = false;
        
        $http.post('dataControlDurezas.php',{
            RAM     : RAM,
            accion  : "mostrarDurezas"
        })
        .then(function (response) {
            $scope.dataDurezasOtam = response.data.records; 
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });
        
    }

    $scope.cargarResultadosEnsayos = function(idItem){
        $scope.ficherosTracciones   = true;
        $scope.idItem               = idItem;
        $scope.Otam                 = idItem;
    }


    $scope.dataTraccionesTabla = function(){
        $http.post('dataTracciones.php',{
            Otam:       $scope.Otam,
            accion:     "dataTraccionesTabla"
        })
        .then(function (response) {
            $scope.idItem           = response.data.idItem;
            $scope.Humedad          = response.data.Humedad;
            $scope.idItem           = response.data.idItem;
            $scope.Humedad          = response.data.Humedad;
            $scope.Temperatura      = response.data.Temperatura;
            $scope.tpMuestra        = response.data.tpMuestra;
            $scope.Espesor          = response.data.Espesor;
            $scope.Ancho            = response.data.Ancho;
            $scope.aIni             = response.data.aIni;
            $scope.Modulo           = response.data.Modulo;
            $scope.cFlu             = response.data.cFlu;
            $scope.cMax             = response.data.cMax;
            $scope.tMax             = response.data.tMax;
            $scope.tFlu             = response.data.tFlu;
            $scope.aSob             = response.data.aSob;
            $scope.Li               = response.data.Li;
            $scope.Lf               = response.data.Lf;
            $scope.Di               = response.data.Di;
            $scope.Df               = response.data.Df;
            //$scope.fechaRegistro    = response.data.fechaRegistro;
            $scope.fechaRegistro    = new Date(response.data.fechaRegistro.replace(/-/g, '\/').replace(/T.+/, ''));
            //alert($scope.fechaRegistro);

    
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });
        
    }

    $scope.loadEnsayo = function(Otam){
        $scope.Otam = Otam;
        $http.post('registroData.php',{
            idEnsayo:   'Tr',
            Otam:       Otam,
            accion:     "LeerOtams"
        })
        .then(function (response) {
            $scope.tpMuestra    = response.data.tpMuestra;
            $scope.Muestra      = response.data.Muestra;
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
            // $scope.loadFicheros(Otam);
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
        $http.post('registroData.php',{
            idEnsayo:   'Tr',
            Otam:       Otam,
            accion:     "LeerTraccion"
        })
        .then(function (response) {
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

    $scope.muestraFichero = function(f){
        alert(f);
        window.location.href = f;
    }

});