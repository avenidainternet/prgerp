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
    $rootScope.mediaDureza          = 0.000;
    $rootScope.Temperatura          = 19;
    $rootScope.Humedad              = 55;
    $rootScope.ensayoDureza         = true;
    $rootScope.bdBrinell            = false;
    $rootScope.showGeometria        = true;
    $rootScope.showCarga            = false;
    $rootScope.showInicial          = false;
    $rootScope.showEntre            = false;
    $rootScope.showPuntualHR        = false;
    $rootScope.showPuntualHB        = false;
    $rootScope.showPerfilHR         = false;
    $rootScope.showPerfilHB         = false;

    $rootScope.tipotpEnsayoDurezaData = [ 
        {
            codEstado:"Medi",
            descripcion:"Puntual"   
        },{
            codEstado:"Perf",
            descripcion:"Perfil"
        }
        ];
    $rootScope.tpEnsayoDureza = "Medi"; 

    $rootScope.dataCargaDureza = [
        {
            codEstado   : 3000,
            descripcion : 3000   
        },{
            codEstado   : 1500,
            descripcion : 1500
        },{
            codEstado   : 1000,
            descripcion : 1000
        },{
            codEstado   : 500,
            descripcion : 500
        },{
            codEstado   : 250,
            descripcion : 250
        },{
            codEstado   : 125,
            descripcion : 125
        },{
            codEstado   : 100,
            descripcion : 100
        }
        ];
    $rootScope.cargaDureza = ""; 

});

app.controller('ctrlDoblados', function($scope, $http) {
    $scope.Df                 = '';
    $scope.Otam               = '';
    $scope.tpMuestra          = '';
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



    $scope.tablaEnsayo = function(){
        $scope.ensayoDureza = true;
        $scope.bdBrinell    = false;
    }

    $scope.tablaBrinell = function(){
        $scope.ensayoDureza = false;
        $scope.bdBrinell    = true;
        $scope.leerCargas();
    }

    $scope.guardarDureza = function(){
        // alert($scope.Otam);
        window.location.href = 'formularios/otamDureza.php?accion=Imprimir&RAM='+$scope.RAM;
        alert('Se guardo correctamente Ensayo '+$scope.Otam);

        window.location.href = 'iDureza.php?Otam='+$scope.Otam;

    }


    $scope.mediaDu = function(){
        var mediaDureza = 0;
        var sumaDurezas  = 0;
        for(var i = 0; i < $scope.dataDurezas.length; i++){
            var x = $scope.dataDurezas[i];
            sumaDurezas += parseFloat(x.vIndenta);
        }
        mediaDureza = sumaDurezas / i;
        $scope.mediaDureza = mediaDureza;
        return mediaDureza;
    }

    $scope.actualizarIndentacion = function(){
        //alert($scope.Otam+' '+$scope.Ind);

        $http.post('registroDataDureza.php',{
            Otam            : $scope.Otam,
            Ind             : $scope.Ind,
            accion          : "actualizarIndentacion"
        })
        .then(function (response) {
            $scope.loadEnsayo($scope.Otam);
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });
    }
    
    $scope.guardarTecRes = function(){
        //alert($scope.tecRes);
        
        $http.post('registroDataDureza.php',{
            Otam            : $scope.Otam,
            tecRes          : $scope.tecRes,
            accion          : "guardarTecRes"
        })
        .then(function (response) {
            $scope.loadEnsayo($scope.Otam);
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });
        
    }
    $scope.guardarGeometria = function(){
        //alert($scope.Otam);
        
        $http.post('registroDataDureza.php',{
            Otam            : $scope.Otam,
            Geometria       : $scope.Geometria,
            accion          : "guardarGeometria"
        })
        .then(function (response) {
            $scope.loadEnsayo($scope.Otam);
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });
        
    }

    $scope.guardarCargaDureza = function(){
        //alert($scope.cargaDureza);
        $http.post('registroDataDureza.php',{
            Otam            : $scope.Otam,
            cargaDureza     : $scope.cargaDureza,
            accion          : "guardarCargaDureza"
        })
        .then(function (response) {
            $scope.loadEnsayo($scope.Otam);
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });

    }

    $scope.guardarDistanciaEntreInd = function(){
        //alert($scope.cargaDureza);
        if($scope.distanciaEntreInd.length == 3){
            $http.post('registroDataDureza.php',{
                Otam                : $scope.Otam,
                distanciaEntreInd   : $scope.distanciaEntreInd,
                accion              : "guardarDistanciaEntreInd"
            })
            .then(function (response) {
                $scope.loadEnsayo($scope.Otam);
            }, function(error) {
                $scope.errors = error.message;
                alert(error.message);
            });

        }

    }

    $scope.guardarDistanciaInicial = function(){
        //alert($scope.cargaDureza);
        $http.post('registroDataDureza.php',{
            Otam            : $scope.Otam,
            distanciaInicial: $scope.distanciaInicial,
            accion          : "guardarDistanciaInicial"
        })
        .then(function (response) {
            $scope.loadEnsayo($scope.Otam);
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });

    }

    $scope.calculoHuella = function(nIndenta, diametroHuella){
        //alert(diametroHuella+' '+$scope.Otam);
        if(diametroHuella.length == 4){
            $http.post('registroDataDureza.php',{
                idItem          : $scope.Otam,
                nIndenta        : nIndenta,
                diametroHuella  : diametroHuella,
                accion:         "calculoHuella"
            })
            .then(function (response) {
                $scope.loadEnsayo($scope.Otam);
            }, function(error) {
                $scope.errors = error.message;
                alert(error.message);
            });

        }

    }

    $scope.valorIndentacion = function(nIndenta, vIndenta){
        var mediaDureza = 0;
        var sumaDurezas  = 0;
        for(var i = 0; i < $scope.dataDurezas.length; i++){
            var x = $scope.dataDurezas[i];
            //alert(x.vIndenta);
            if(i+1 == nIndenta){
                x.vIndenta = vIndenta;
            }
            sumaDurezas += parseFloat(x.vIndenta);
        }
        mediaDureza = sumaDurezas / i;
        $scope.mediaDureza = mediaDureza;
        // alert($scope.Otam+' '+nIndenta+' '+vIndenta);

        $http.post('registroDataDureza.php',{
            idEnsayo:       'Du',
            idItem:         $scope.Otam,
            Temperatura:    $scope.Temperatura,
            Humedad:        $scope.Humedad,
            nIndenta:       nIndenta,
            vIndenta:       vIndenta,
            fechaRegistro:  $scope.fechaRegistro,
            accion:         "gardarRegDureza"
        })
        .then(function (response) {
            console.log('Registro grabado correctamente...');
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });







    }


    

    $scope.showTipoDureza = function(){
        
        $http.post('registroDataDureza.php',{
            idEnsayo        : 'Du',
            tpMedicion      : $scope.tpEnsayoDureza,
            Otam            : $scope.Otam,
            accion          : "grabarTipo"
        })
        .then(function (response) {
            $scope.activarCampos();
        }, function(error) {
            $scope.errors = error.message;
        });
        
    }


    $scope.showGeo = function(){

        $http.post('registroDataDureza.php',{
            idEnsayo        : 'Du',
            tpMuestra       : $scope.tpMuestra,
            Otam            : $scope.Otam,
            accion          : "grabarTipoMuestra"
        })
        .then(function (response) {
            $scope.activarCampos();
        }, function(error) {
            $scope.errors = error.message;
        });

    }


    $scope.loadEnsayo = function(Otam){
        $scope.Otam = Otam;
        // alert(Otam);
        $http.post('registroDataDureza.php',{
            idEnsayo:   'Du',
            Otam:       Otam,
            accion:     "LeerOtams"
        })
        .then(function (response) {
            $scope.tpMuestra            = response.data.tpMuestra;
            $scope.Muestra              = response.data.Muestra;
            if(response.data.fechaRegistro == '0000-00-00'){
                $scope.fechaRegistro = new Date();
            }else{
                $scope.fechaRegistro    = new Date(response.data.fechaRegistro.replace(/-/g, '\/').replace(/T.+/, ''));
            }
            $scope.Ind                  = response.data.Ind;
            $scope.RAM                  = response.data.RAM;
            $scope.CAM                  = response.data.CAM;
            $scope.Tem                  = response.data.Tem;
            $scope.Hum                  = response.data.Hum;
            $scope.tecRes               = response.data.tecRes;
            $scope.tipoEnsayo           = response.data.tipoEnsayo;
            $scope.tpMuestra            = response.data.tpMuestra;
            if($scope.tpMuestra == 'HB'){
                $scope.showGeometria    = false;
                $scope.showCarga        = true;
            }
            $scope.tpEnsayoDureza       = response.data.tpMedicion;
            $scope.distanciaInicial     = response.data.distanciaInicial;
            $scope.distanciaEntreInd    = response.data.distanciaEntreInd;
            $scope.Geometria            = response.data.Geometria;
            $scope.Distancia            = response.data.Distancia;
            $scope.cargaDureza          = response.data.cargaDureza;
            $scope.factorY              = response.data.factorY;
            $scope.constanteY           = response.data.constanteY;
            $scope.activarCampos();
            $scope.leerDurezas(Otam);
            $scope.leerTipodDureza(Otam);
        }, function(error) {
            $scope.errors = error.message;
        });
    }


    $scope.activarCampos = function(){
        if($scope.tpEnsayoDureza == 'Medi'){ // Puntual
            //alert($scope.tpEnsayoDureza+' '+$scope.tpMuestra);
            $scope.showPerfilHR    = false;
            $scope.showPerfilHB    = false;

            if($scope.tpMuestra != 'HB'){
                $scope.showPuntualHR    = true;
                $scope.showPuntualHB    = false;

                $scope.showGeometria    = true;
                $scope.showCarga        = false;
                $scope.showInicial      = false;
                $scope.showEntre        = false;
            }
            if($scope.tpMuestra == 'HB'){
                $scope.showPuntualHR    = false;
                $scope.showPuntualHB    = true;

                $scope.showGeometria    = false;
                $scope.showCarga        = true;
                $scope.showInicial      = false;
                $scope.showEntre        = false;
            }
        }
        if($scope.tpEnsayoDureza == 'Perf'){
            $scope.showPuntualHR    = false;
            $scope.showPuntualHB    = false;

            $scope.showGeometria    = false;
            $scope.showInicial      = true;
            $scope.showEntre        = true;
            if($scope.tpMuestra == 'HB'){
                $scope.showPerfilHR    = false;
                $scope.showPerfilHB    = true;
    
                $scope.showCarga        = true;
            }else{
                $scope.showPerfilHR    = true;
                $scope.showPerfilHB    = false;

                $scope.showCarga        = false;
            }
        }
    }

    $scope.leerTipodDureza = function(Otam){
        $http.post('registroDataDureza.php',{
            idEnsayo:   'Du',
            Otam:       Otam,
            accion:     "LeerTiposDurezas"
        })
        .then(function (response) {
            $scope.regtpEnsayosDureza = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
        });
    }

    $scope.leerEscala = function(){
        $http.post('registroDataDureza.php',{
            accion:     "leerEscala"
        })
        .then(function (response) {
            $scope.dataEscala = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
        });
    }

    $scope.leerEscala();

    $scope.leerGeometria = function(){
        $http.post('registroDataDureza.php',{
            accion:     "leerGeometria"
        })
        .then(function (response) {
            $scope.dataGeometria = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
        });
    }

    $scope.leerGeometria();

    $scope.guardarCarga = function(){
        //alert($scope.diametroBola+' '+$scope.c3000);
        
        $http.post('registroDataDureza.php',{
            diametroBola    : $scope.diametroBola,
            c3000           : $scope.c3000,
            c1500           : $scope.c1500,
            c1000           : $scope.c1000,
            c500            : $scope.c500,
            c250            : $scope.c250,
            c125            : $scope.c125,
            c100            : $scope.c100,
            accion          : "guardarCarga"
        })
        .then(function (response) {
            $scope.leerCargas();
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });
        
    }
    $scope.editarCarga = function(diametroBola){
        $http.post('registroDataDureza.php',{
            diametroBola    : diametroBola,
            accion          : "editarCarga"
        })
        .then(function (response) {
            $scope.diametroBola     = response.data.diametroBola;
            $scope.c3000            = response.data.c3000;
            $scope.c1500            = response.data.c1500;
            $scope.c1000            = response.data.c1000;
            $scope.c500             = response.data.c500;
            $scope.c250             = response.data.c250;
            $scope.c125             = response.data.c125;
            $scope.c100             = response.data.c100;
        }, function(error) {
            $scope.errors = error.message;
        });
    }

    $scope.leerCargas = function(){
        $http.post('registroDataDureza.php',{
            accion:     "leerCargas"
        })
        .then(function (response) {
            $scope.dataCargas = response.data.records;
            //alert('Entra');
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });
    }

    $scope.leerDurezas = function(Otam){
        $scope.Otam = Otam;
        $http.post('registroDataDureza.php',{
            idEnsayo:   'Du',
            Otam:       Otam,
            accion:     "LeerDureza"
        })
        .then(function (response) {
            $scope.dataDurezas = response.data.records;
            $scope.Indentaciones = $scope.dataDurezas.length;
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


    $scope.imprimirDureza = function(){

    }
    $scope.imprimirDurezaPerfil = function(){

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
        
        alert('Se guardo correctamente el registro del ensayo'+$scope.Otam+'...');
        // alert('Generar Informe OTAM '+$scope.Otam+'...');
        window.location.href = 'formularios/otamTraccion.php?accion=Imprimir&RAM='+RAM+'&Otam='+$scope.Otam+'&CodInforme=';
        // alert('Se genero Otam '+$scope.Otam+' Aceptar para continuar...');
        window.location.href = 'iTraccion.php?Otam='+$scope.Otam;
        // window.location.href = 'pTallerPM.php';
        
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

    $scope.registraDatosFijos = function(){
        // alert($scope.fechaRegistro+' '+$scope.Temperatura+' '+$scope.Humedad);
        $http.post('registroDataDureza.php',{
            idEnsayo:       'Du',
            idItem:         $scope.Otam,
            Temperatura:    $scope.Temperatura,
            Humedad:        $scope.Humedad,
            fechaRegistro:  $scope.fechaRegistro,
            accion:         "gardarRegDurezaDatosFijos"
        })
        .then(function (response) {
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });

    }

});