    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.Estado           = "P";
        $rootScope.enProceso        = false;
        $rootScope.tablasAM         = false;
        $rootScope.swCotizaciones   = true;
        $rootScope.btnMuestraCAM    = false; 
        $rootScope.btnOcultaCAM     = true;
        $rootScope.errorSupervisor  = false;
        $rootScope.progreso         = 0;
        $rootScope.usr              = '';
        $rootScope.rutSuper         = '';
    });

    app.controller('personCtrl', function($scope, $http) {   

        $scope.loadConfig = function(usr){
            $scope.usr = usr;
        }

        $scope.activaCAM = function(){
            $scope.swCotizaciones = true;
            $scope.btnMuestraCAM = false;
            $scope.btnOcultaCAM = true;
    
        }
        $scope.ocultaCAM = function(){
            $scope.swCotizaciones = false;
            $scope.btnMuestraCAM = true;
            $scope.btnOcultaCAM = false;
    
        }

        $scope.grabarSupervisor = function(){
            estadoSuper = 'New';
            if($scope.errorSupervisor == false){
                estadoSuper = 'Old';
            }
            $http.post('dataPlataforma.php',{
                estadoSuper : estadoSuper,
                rutSuper    : $scope.rutSuper,
                nombreSuper : $scope.nombreSuper,
                cargoSuper  : $scope.cargoSuper,
                accion      :  "grabarSupervisor"
            })

            .then(function (response) {
                alert('Se grabo correctamente...');
                $scope.tablaDependencias    = true;
                $scope.regDependencia       = false;
                $scope.cargarDependencias();
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });

        }

        $scope.grabarProyecto = function(IdProyecto, Proyecto, Rut_JefeProyecto, JefeProyecto, Email, Banco, Cta_Corriente){
            //alert(IdProyecto+'\n'+Proyecto+' - '+$scope.Proyecto+'\n'+Rut_JefeProyecto+'\n'+JefeProyecto+'\n'+Email+'\n'+Banco+'\n'+Cta_Corriente+'\n'+Cta_Corriente);
            
            $http.post('dataPlataforma.php',{
                IdProyecto          : IdProyecto        ,
                Proyecto            : Proyecto          ,
                Rut_JefeProyecto    : Rut_JefeProyecto  ,
                JefeProyecto        : JefeProyecto      ,
                Email               : Email             ,
                Banco               : Banco             ,
                Cta_Corriente       : Cta_Corriente     ,
                accion              : "grabarProyecto"
            })
            .then(function (response) {
                $scope.IdProyecto       = response.data.IdProyecto;
                $scope.Grabado          = response.data.Grabado;
                alert($scope.Grabado);
                $scope.leerProyectos();

            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });
            
        }


        $scope.cargarDatosSupervisor = function(){
            $scope.errorSupervisor = false;
            $http.post("dataPlataforma.php",{
                accion  : "cargarDatosSupervisor"
            })
            .then(function(response){  
                $scope.rutSuper     = response.data.rutSuper;
                $scope.nombreSuper  = response.data.nombreSuper;
                $scope.cargoSuper   = response.data.cargoSuper;
                $scope.firmaSuper   = response.data.firmaSuper;
                $scope.imgSuper     = response.data.imgSuper;
                if($scope.rutSuper == 'Error') { 
                    $scope.errorSupervisor = true;  
                    $scope.rutSuper = '';
                }
            }, function(error) {
                $scope.errors = error.message;
                $scope.errorSupervisor = true;

            });

        }

        $scope.leerProyectos = function(){ 
            $http.post("dataPlataforma.php",{
                accion      : "leerProyectos"
            })   
            .then(function(response){  
                $scope.dataProyectos = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        $scope.leerProyectos();

        $scope.leerCotizacionesEnAM = function(){ 
            //alert('Entra...');
            $scope.enProceso = true;
            progreso = $scope.progreso;
            progreso++;
            $scope.progreso = progreso;
            $http.get("leerCotizacionesAMRes.php")    
            .then(function(response){  
                $scope.cotizacionesAM = response.data.records;
                $scope.enProceso = false;
                $scope.tablasAM = true;
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        $scope.leerCotizacionesEnAM();

        $scope.comparadorBlanco = function(item){
            if(item.infoSubidos == 0 || item.infoSubidos < item.infoNumero){
                if(item.Fan == 0){
                    return true;
                }
            }
            if(item.informeUP == ''){
                return true;
            }

        }
        $scope.comparadorAmarillo = function(item){
            retorno = false;
            if(item.informeUP == 'on' && item.nSolicitud == 0 && item.nFactura == 0){
                /*
                if(item.HES == 'on'  && item.HEScot != ''){
                    retorno = true; 
                }
                */
               
                if(item.nOC.length > 0){
                    if(item.HES == 'on'  && item.HEScot == 0){
                        retorno = false;
                    }else{
                        retorno = true; 
                    }
                }else{
                    retorno = false; 
                }
            }
            return retorno;
        }
        $scope.comparadorRosado = function(item){
            retorno = false;
            //if(item.informeUP == 'on' && item.nSolicitud == 0 && item.nFactura == 0 && item.nOC == ''){
            if(item.informeUP == 'on' && item.nSolicitud == 0 && item.nFactura == 0){
                if(item.nOC == ''){
                    retorno = true; 
                }else{
                    retorno = false
                    if(item.HES == 'on'  && item.HEScot == 0){
                        retorno = true; 
                    }
                }
                /*
                */
            }
            return retorno;
        }
        $scope.comparadorVerde = function(item){
            if(item.nSolicitud > 0 && item.nFactura == 0){
               return true; 
            }
        }
        $scope.comparadorAzul = function(item){
            if(item.nSolicitud > 0 && item.nFactura > 0){
               return true; 
            }
        }

        $scope.getTotalBlancas = function(){
            var totalBlancas = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'blanco'){
                    totalBlancas += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalBlancas;
        }
        $scope.getTotalRosados = function(){
            var totalRosados = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'rosado'){
                    totalRosados += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalRosados;
        }
        $scope.getTotalAmarillos = function(){
            var totalAmarillos = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'amarillo'){
                    totalAmarillos += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalAmarillos;
        }
        $scope.getTotalVerdes = function(){
            var totalVerdes = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'verde'){
                    totalVerdes += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalVerdes;
        }
        $scope.getTotalAzules = function(){
            var totalAzules = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'azul'){
                    totalAzules += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalAzules;
        }

        $scope.getTotal = function(){
            var total = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                    var x = $scope.cotizacionesAM[i];
                if(x.color == 'blanco'){
                    total += parseInt(x.BrutoUF);
                }
            }
            $scope.tResultados = total;
            return total;
        }



        $scope.leerCotizacionesCAM = function(usr){
            $scope.tablaCAM = false;
            $scope.cargaDatos = true;
            $scope.errors = "";
            //$http.post("leerCAMs.php")   
            $http.post("leerCAMs.php", {usr:usr})   
            .then(function(response){  
                $scope.CotizacionesCAM = response.data.records;
                $scope.tablaCAM = true;
                $scope.cargaDatos = false;
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        //$scope.leerCotizacionesCAM();
    
        $scope.verColorLinea = function(Estado, RAM, BrutoUF, nDias, rCot, fechaAceptacion, proxRecordatorio, colorCam){
            mColor = 'Blanco';
            retorno = {'default-color': true};
            if(Estado == 'E'){
                if(nDias <= 3){
                    retorno = {'rojo-class': true};
                    mColor = 'Rojo';
                }else{
                    retorno = {'amarillo-class': true};
                    mColor = 'Amarillo';
                }
            }
            if(RAM > 0){
                retorno = {'verde-class': true};
                mColor = 'Verde';
            }
           
            if(mColor == 'Rojo'){
                if(BrutoUF <= rCot){
                    retorno = {'verde-class': true};
                    mColor = 'Verde';
                }
            }
            if(Estado == 'C'){
                retorno = {'azul-class': true};
                mColor = 'Azul';
            }

            if(proxRecordatorio == '0000-00-00'){
                retorno = {'verde-class': true};
                mColor = 'Verde';
            }


            if(Estado != 'E'){
                retorno = {'default-color': true};
                mColor = 'Blanco';
            }
            if(colorCam == 'Blanco'){ retorno = {'default-color': true}; }
            if(colorCam == 'Rojo'){ retorno = {'rojo-class': true}; }
            if(colorCam == 'Amarilla'){ retorno = {'amarillo-class': true}; }
            if(colorCam == 'Verde'){ retorno = {'verde-class': true}; }
            return retorno;
        }

    });

