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
    $rootScope.resultadosSubidos    = false;
    $rootScope.procesando           = false;
    $rootScope.msgUsr               = false;

});

app.controller('ctrlEspectometro', function($scope, $http) {
    $scope.Df                 = '';
    $scope.Otam                 = '';
    $scope.tpMuestra            = 'Re';
    $scope.muestraPlana         = false;
    $scope.muestraRedonda       = false;
    $scope.muestraEspecial      = false;
    $scope.tecRes               = 'SML';
    //alert($scope.fechaRegistro);
    $scope.Observacion = '';
    $scope.statusBtnRegistrar   = false;
    $scope.statusBtnRespaldar   = true;


    const $archivosSeg = document.querySelector("#archivosSeguimiento");
    $scope.fileName = $archivosSeg;
    $scope.enviarFormularioSeg = function (evento) {
        //alert($scope.Otam);
        $scope.procesando = true;
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
                    .post("guardar_archivosEspectrometroXXX.php", formdata, configuracion) 
                    .then(function (respuesta) {
                        //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                        $scope.pdf = respuesta.data;
                        $scope.resultadosSubidos = true;
                        // $scope.statusBtnRegistrar = false;
                        $scope.loadDatosEspectometro();
                        // alert('Fichero subido correctamente...');
                        window.location.href = 'Espectrometro.php';
                    })
                    .catch(function (detallesDelError) {
                        //console.warn("Error al enviar archivos:", detallesDelError);
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
            } else {
                alert("Rellena el formulario y selecciona algunos archivos");
            }
    };




    $scope.loadDatosEspectometro = function(){
        // alert('Entra aqui');
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


    $scope.cerrarProcesamiento = function(){
        $scope.procesando = false;
    }

    $scope.keyOtam = function(idItem, tpMuestra){
        $scope.idItem       = idItem;
        $scope.tpMuestra    = tpMuestra;
    }

    $scope.registrarDatos = function(){
        alert($scope.fechaRegistro);
        $http.post('registroData.php',{ 
            fechaRegistro:  $scope.fechaRegistro,
            Temperatura:    $scope.Temperatura, 
            Humedad:        $scope.Humedad,
            tecRes:         $scope.tecRes,
            accion:         "grabarDatosQu" 
        })
        .then(function (response) {
            $scope.msg = 'Se ha registrado los datos a las tablas de los ensayos químicos...';
            // $scope.msgUsr = true;
            // $scope.respaldarOtams = true;
        }, function(error) {
            $scope.errors = error.message;
            alert(error);
        });

    }

    $scope.registrarDatosOLD = function(){  

        for(var i = 0; i < $scope.dataEspectometro.length; i++){ 
            var x = $scope.dataEspectometro[i];
            alert(x.tpMuestra+' '+x.RAM+' '+x.cSi);
            $http.post('registroData.php',{ 
                idItem:         x.RAM,
                fechaRegistro:  $scope.fechaRegistro,
                Programa:       x.Programa,
                tpMuestra:      x.tpMuestra,
                Temperatura:    $scope.Temperatura,
                Humedad:        $scope.Humedad,
                tecRes:         $scope.tecRes,
                cC:             x.cC,
                cSi:            x.cSi,
                cMn:            x.cMn,
                cP:             x.cP,
                cS:             x.cS,
                cCr:            x.cCr,
                cMo:            x.cMo,
                cNi:            x.cNi,
                cAl:            x.cAl,
                cCo:            x.cCo,
                cCu:            x.cCu,
                cNb:            x.cNb,
                cTi:            x.cTi,
                cV:             x.cV,
                cW:             x.cW,
                cPb:            x.cPb,
                cSn:            x.cSn,
                cAs:            x.cAs,
                cZr:            x.cZr,
                cBi:            x.cBi, 
                cCa:            x.cCa, 
                cCe:            x.cCe, 
                cSb:            x.cSb,
                cSe:            x.cSe,
                cTe:            x.cTe,
                cTa:            x.cTa,
                cB:             x.cB,
                cZn:            x.cZn,
                cAg:            x.cAg,
                cMg:            x.cMg,
                cBa:            x.cBa,
                cCd:            x.cCd,
                cGa:            x.cGa,
                cHg:            x.cHg,
                cIn:            x.cIn,
                cLa:            x.cLa,
                cNa:            x.cNa,
                cSr:            x.cSr,
                cTl:            x.cTl,
                cHf:            x.cHf,
                cSc:            x.cSc,
                cY:             x.cY, 
                cBg:            x.cBg,
                cN:             x.cN,
                cFe:            x.cFe,
                accion:         "grabarDatosQu" 
            })
            .then(function (response) {
                $scope.msg = 'Se ha registrado los datos a las tablas de los ensayos químicos...';
                $scope.msgUsr = false;
            }, function(error) {
                $scope.errors = error.message;
                alert(error);
            });
    
        }
    }

    $scope.cargarTablaOrientacion = function(){
        //alert($scope.dataEspectometro.length);
        $scope.msgUsr = false;
        for(var i = 0; i < $scope.dataEspectometro.length; i++){
            var x = $scope.dataEspectometro[i];
            //alert(x.RAM);
            if(x.Tipo == 'Average'){
                $http.post('registroData.php',{ 
                    idItem:         x.RAM,
                    accion:         "cargarTablaOrientacion"
                })
                .then(function (response) {
                    $scope.msgUsr = false;
                }, function(error) {
                    $scope.errors = error.message;
                    alert(error);
                });
            }

        }
       
    }

    $scope.cargarRamsEspectometro = function(){
        $http.post('registroData.php',{
            accion: "cargarRamsEspectometro"
        })
        .then(function (response) {
            $scope.dataRAMs = response.data.records;
        }, function(error) {
            $scope.msgUsr = false;
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

    $scope.buscarMuestras();

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