var app = angular.module('myApp', []);
app.run(function($rootScope){
    $rootScope.CodInforme           = 'AM';
    $rootScope.Otam                 = '';
    $rootScope.prgActividad         = new Date();
    $rootScope.fechaRegistro        = new Date();

    $rootScope.Tem                  = "";
    $rootScope.Hum                  = "";
    $rootScope.usrResponsable       = "";
    $rootScope.separacionApoyos     = "";
    $rootScope.nDiametroDoblado     = "";
    $rootScope.diametroPunzon       = "";
    $rootScope.anguloAlcanzado      = "";
    $rootScope.diametroFisuras      = "";
    $rootScope.normaRefDoblado      = "";
    $rootScope.Tipo                 = "";
    $rootScope.Observaciones        = "";
    $rootScope.Condicion            = "";


    $rootScope.responsable = [
        {
            usrResponsable  : "RPM",
            descripcion     : "RPM"  
        },{
            usrResponsable  : "GRC",
            descripcion     : "GRC"
        },{
            usrResponsable  : "RCG",
            descripcion     : "RCG"
        }
        ];

    $rootScope.dataCondicion = [
        {
            Condicion       : "Si",
            descripcion     : "Cumple"  
        },{
            Condicion       : "No",
            descripcion     : "NO Cumple"
        }
        ];

});

app.controller('controlDoblados', function($scope, $http) { 

    $scope.Exito    = false;
    $scope.tecRes   = 'SML';

    $scope.loadDoblado = function(Otam){
        //alert(Otam);
        $http.post('dataDoblado.php',{
            Otam        : Otam,
            accion      : "loadDoblado"
        })
        .then(function (response) {
            
            $scope.CodInforme       = response.data.CodInforme;
            $scope.CAM              = response.data.CAM;
            $scope.RAM              = response.data.RAM; 
            $scope.Otam             = response.data.Otam;
            $scope.idItem           = response.data.idItem;
            $scope.idEnsayo         = response.data.idEnsayo;
            $scope.tpMuestra        = response.data.tpMuestra;
            //$scope.fechaRegistro    = response.data.fechaRegistro;
            $scope.Tem              = response.data.Tem;
            $scope.Hum              = response.data.Hum;
            $scope.normaRefDoblado  = response.data.normaRefDoblado;
            $scope.nDiametroDoblado = response.data.nDiametroDoblado;
            $scope.Tipo             = response.data.Tipo;
            $scope.Observaciones    = response.data.Observaciones;
            $scope.separacionApoyos = response.data.separacionApoyos;
            $scope.diametroPunzon   = response.data.diametroPunzon;
            $scope.anguloAlcanzado  = response.data.anguloAlcanzado;
            $scope.diametroFisuras  = response.data.diametroFisuras;
            $scope.Condicion        = response.data.Condicion;
            $scope.usrResponsable   = response.data.usrResponsable;
            $scope.Estado           = response.data.Estado;
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });

    }

    $scope.loadDiametros = function(){
        $http.post("dataDoblado.php",{
            accion  : 'loadDiametros'
        })  
        .then(function(response){  
            $scope.dataDiametro = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });
    }

    $scope.loadNormaRef = function(){
        $http.post("dataDoblado.php",{
            accion  : 'loadNormaRef'
        })  
        .then(function(response){  
            $scope.dataNormaRef = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });
    }

    $scope.loadTipo = function(){
        $http.post("dataDoblado.php",{
            accion  : 'loadTipo'
        })  
        .then(function(response){  
            $scope.dataTipo = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });
    }

    $scope.loadObservaciones = function(){
        $http.post("dataDoblado.php",{
            accion  : 'loadObservaciones'
        })  
        .then(function(response){  
            $scope.dataObservaciones = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });
    }

    $scope.loadDiametros();
    $scope.loadNormaRef();
    $scope.loadTipo();
    $scope.loadObservaciones();

    
    $scope.grabarDoblado = function(){
        $http.post('dataDoblado.php',{
            Otam                : $scope.Otam,
            CodInforme          : $scope.CodInforme,
            fechaRegistro       : $scope.fechaRegistro,
            Tem                 : $scope.Tem,
            Hum                 : $scope.Hum,
            usrResponsable      : $scope.usrResponsable,
            separacionApoyos    : $scope.separacionApoyos,
            nDiametroDoblado    : $scope.nDiametroDoblado,
            diametroPunzon      : $scope.diametroPunzon,
            anguloAlcanzado     : $scope.anguloAlcanzado,
            diametroFisuras     : $scope.diametroFisuras,
            normaRefDoblado     : $scope.normaRefDoblado,
            Tipo                : $scope.Tipo,
            Observaciones       : $scope.Observaciones,
            Condicion           : $scope.Condicion,
            accion              : "grabarDoblado"
        })
        .then(function (response) {
            $scope.loadDoblado(Otam);
        }, function(error) {
            $scope.errors = error.message;
            alert('Error...'+$scope.errors);
        });
        
        const myArray = $scope.Otam.split("-"); 
        var RAM = myArray[0];

        window.location.href = 'formularios/otamDoblado.php?accion=Imprimir&RAM='+RAM+'&Otam='+$scope.Otam+'&CodInforme=';
        alert('Se guardó Otam '+$scope.Otam+' Aceptar para continuar...');
        window.location.href = 'iDoblado.php?Otam='+$scope.Otam+'&CodInforme='+$scope.CodInforme;

    }
    


});

