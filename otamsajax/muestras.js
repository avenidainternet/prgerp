    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.Estado       = "P";
        $rootScope.res          = '';
        $rootScope.regMuestra   = false;
        $rootScope.formMuestra  = false; 
        $rootScope.msgGraba     = false;
        $rootScope.conRef       = true;

        $rootScope.conEnsayo  = "off";
        $rootScope.ensayar = [
            {
                codEnsayo:"on",
                descripcion:"Si"
            },{
                codEnsayo:"off",
                descripcion:"No"
            }
            ];

        $rootScope.Taller  = "off";
        $rootScope.RAM = 0;
        $rootScope.ServicioTaller = [
            {
                codTaller:"on",
                descripciontaller:"Si"
            },{
                codTaller:"off",
                descripciontaller:"No"
            }
            ];

    });

    app.controller('CtrlMuestras', function($scope, $http) {
        $scope.loadMuestras = function(r){
            $scope.RAM = r;

            $http.post("leerMuestras.php", {RAM: r, accion: "lectura"})   
            .then(function(response){  
                $scope.regMuestras = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.conReferencia = function(){
            alert('Referencia');
        }

        $scope.verColorLineaPAM = function(m){
            mColor = 'Blanco';
            retorno = {'verde-class': true};
            return retorno;
        }

        $scope.verColorLineaMuestras = function(m){
            mColor = 'Blanco';
            retorno = {'default-color': true};
            if(m != ''){
                retorno = {'verde-class': true};
                mColor = 'Verde';
            }
           
            return retorno;
        }



        

        $scope.editarMuestra = function(i){

            $http.post("leerMuestras.php", {idItem: i, accion: "buscar"})   
            .then(function(response){  
                $scope.idItem       = response.data.idItem;
                $scope.idMuestra    = response.data.idMuestra;
                $scope.conEnsayo    = response.data.conEnsayo;
                $scope.Taller       = response.data.Taller;
                $scope.nSolTaller   = response.data.nSolTaller;
                $scope.Objetivo     = response.data.Objetivo;
                $scope.regMuestra = true;
                $scope.formMuestra = true;
                $scope.msgGraba = false;

            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.guardarConfiguracionMuestra = function(){
            $scope.resp = 'Guardar '+$scope.idItem;
            $scope.msgGraba = true;
            $http.post("leerMuestras.php", {
                                            idItem: $scope.idItem, 
                                            idMuestra: $scope.idMuestra, 
                                            nSolTaller: $scope.nSolTaller, 
                                            conEnsayo: $scope.conEnsayo, 
                                            Taller: $scope.Taller, 
                                            Objetivo: $scope.Objetivo, 
                                            accion: "guardar"})   
            .then(function(response){  
                //alert('Guardada...');
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.guardarMuestra = function(){
            //alert('Muestra '+$scope.idItem+' '+$scope.idMuestra);
            $http.post("leerMuestras.php", {
                                            idItem: $scope.idItem, 
                                            idMuestra: $scope.idMuestra, 
                                            accion: "guardar"})   
            .then(function(response){  
                $scope.res = response.data.estatus;
                //alert('Guardada...');
            }, function(error) {
                $scope.errors = error.message;
            });

        }

        $scope.guardarMuestra2 = function(i, m, e, t, o){
            //alert('Muestra '+o);
            
            $http.post("leerMuestras.php", {
                                            idItem: i, 
                                            idMuestra: m,  
                                            conEnsayo: e, 
                                            Taller: t, 
                                            Objetivo: o, 
                                            accion: "guardar"})   
            .then(function(response){  
                $scope.res = 'Registro guardado correctamente';
                $scope.loadMuestras($scope.RAM);
                //alert('Guardada...');
            }, function(error) {
                $scope.errors = error.message;
            });
            
        }

    });

