   var app = angular.module('myApp', []);
    app.controller('controlRangos', function($scope, $http) { 
        
        $scope.res = $scope.mesRango;
        $scope.datos = [{
                            mesnum:1,
                            descripcion:"Enero" 
                        },
                        {
                            mesnum:2,
                            descripcion:"Febrero"
                        },
                        {
                            mesnum:3,
                            descripcion:"Marzo"
                        },
                        {
                            mesnum:4,
                            descripcion:"Abril"
                        },
                        {
                            mesnum:5,
                            descripcion:"Mayo"
                        },
                        {
                            mesnum:6,
                            descripcion:"Junio"
                        },
                        {
                            mesnum:7,
                            descripcion:"Julio"
                        },
                        {
                            mesnum:8,
                            descripcion:"Agosto"
                        },
                        {
                            mesnum:9,
                            descripcion:"Septiembre"
                        },
                        {
                            mesnum:10,
                            descripcion:"Octubre"
                        },
                        {
                            mesnum:11,
                            descripcion:"Noviembre"
                        },
                        {
                            mesnum:12,
                            descripcion:"Diciembre"
                        }
                    ];

        function mostrarMes(){
            $scope.EstadoGraba = false;
            var d = new Date();
            var m = d.getMonth()+1;
            var a = d.getFullYear();
            //alert(m + ' ' + a);
            $http.post('datosRango.php',{agnoInd:a, mesInd:m})
            .then(function (response) {
                
                $scope.indMin       = response.data.indMin;
                $scope.indMeta      = response.data.indMeta;
                $scope.indDesc      = response.data.indDesc;
                $scope.descrDesc    = response.data.descrDesc;
                $scope.indDesc2     = response.data.indDesc2;
                $scope.descrDesc2   = response.data.descrDesc2;
                $scope.indDesc3     = response.data.indDesc3;
                $scope.descrDesc3   = response.data.descrDesc3;
                $scope.rCot         = response.data.rCot;
                $scope.valorUFRef   = response.data.valorUFRef;
                $scope.ins45        = response.data.ins45;
               
            });
        }

        $scope.lecturaClasificaciones = function(){
            $scope.errors = "";
            $http.get("leerClasificaciones.php")  
            .then(function(response){  
                $scope.clasificaciones = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.lecturaClasificaciones();

        $scope.cambiarClasifica = function(c, d, h){
            //alert('Desde '+ c + ' ' + d + ' ' + h);
            $http.post('guardarClasificacion.php',{
                Clasificacion:c, 
                desde:d, 
                hasta:h 
            })
            .then(function (res) {
                //$scope.exito = "Guardado exitosamente...";
                //alert('Guardado con exito...');
            });

        }

        $scope.ExitoClasificacion=function(){
            alert('Guardado con exito...');
        }

        $scope.editarAgno = function(){
            $scope.res=$scope.seleccion.mesnum+'-'+$scope.agnoInd;
            $http.post('datosRango.php',{agnoInd:$scope.agnoInd, mesInd:$scope.seleccion.mesnum})
            .then(function (response) {
                
                $scope.indMin       = response.data.indMin;
                $scope.indMeta      = response.data.indMeta;
                $scope.indDesc      = response.data.indDesc;
                $scope.descrDesc    = response.data.descrDesc;
                $scope.indDesc2     = response.data.indDesc2;
                $scope.descrDesc2   = response.data.descrDesc2;
                $scope.indDesc3     = response.data.indDesc3;
                $scope.descrDesc3   = response.data.descrDesc3;
                $scope.rCot         = response.data.rCot;
                $scope.valorUFRef   = response.data.valorUFRef;
                $scope.ins45        = response.data.ins45;
              
            });
        }
        $scope.editar = function(){
            $scope.res=$scope.seleccion.descripcion+'-'+$scope.agnoInd;
            $http.post('datosRango.php',{agnoInd:$scope.agnoInd, mesInd:$scope.seleccion.mesnum})
            .then(function (response) {
                
                $scope.indMin       = response.data.indMin;
                $scope.indMeta      = response.data.indMeta;
                $scope.indDesc      = response.data.indDesc;
                $scope.descrDesc    = response.data.descrDesc;
                $scope.indDesc2     = response.data.indDesc2;
                $scope.descrDesc2   = response.data.descrDesc2;
                $scope.indDesc3     = response.data.indDesc3;
                $scope.descrDesc3   = response.data.descrDesc3;
                $scope.rCot         = response.data.rCot;
                $scope.valorUFRef   = response.data.valorUFRef;
                $scope.ins45        = response.data.ins45;
              
            });
           
        }
        
        mostrarMes();

        $scope.modi = function(){
            $scope.EstadoGraba = true;
            $http.post('guardarRangos.php',{
                mesInd:$scope.seleccion.mesnum, 
                agnoInd:$scope.agno, 
                indMin:$scope.indMin, 
                indMeta:$scope.indMeta, 
                indDesc:$scope.indDesc, 
                descrDesc:$scope.descrDesc,
                indDesc2:$scope.indDesc2, 
                descrDesc2:$scope.descrDesc2,
                indDesc3:$scope.indDesc3, 
                descrDesc3:$scope.descrDesc3,
                rCot:$scope.rCot, 
                valorUFRef:$scope.valorUFRef
            })
            .then(function (res) {
                $scope.exito = "Guardado exitosamente...";
                alert('Guardado con exito...');
            });
        
        }
    });