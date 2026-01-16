var app = angular.module('myApp', []);
app.run(function($rootScope){
    $rootScope.cMg                  = 0;
});

app.controller('CtrlTaller', function($scope, $http) {

    $scope.Exito = false;
    $scope.tecRes               = 'SML';

    $scope.leerEnsayos = function(Otam, CodInforme){
        //alert(Otam+' '+CodInforme);

        $scope.Otam     = Otam;
        $scope.leerEnsayo(Otam, CodInforme);
        $scope.cargarEnsayos(Otam, CodInforme);
    }

    $scope.cargarEnsayos = function(Otam, CodInforme) {
        //alert(CodInforme);
        $http.post("dataRecord.php", {
            idItem: Otam,
            CodInforme: CodInforme,
            accion: "lecturaEnsayos"
        })  
        .then(function(response){  
            $scope.dataEnsayos = response.data.records;
        }, function(error) {
            $scope.errors = error.message;
            alert(error);
        });
    };

    $scope.leerEnsayo = function(Otam, CodInforme) {
        $http.post("dataRecord.php", { 
            idItem: Otam,
            CodInforme: CodInforme,
            accion: "leerEnsayoAsignado"
        })  
        .then(function(response){  
            $scope.CodInforme       = response.data.CodInforme;
            $scope.idItem           = response.data.idItem;
            $scope.idItemSel        = Otam;
            //alert($scope.idItemSel);
            $scope.tecRes           = response.data.tecRes;
            $scope.Rep              = response.data.Rep;
            $scope.Programa         = response.data.Programa;
            $scope.Temperatura      = response.data.Temperatura;
            $scope.Humedad          = response.data.Humedad;
            $scope.Observacion      = response.data.Observacion;
            $scope.cC               = response.data.cC;
            $scope.cSi              = response.data.cSi;
            $scope.cMn              = response.data.cMn;
            $scope.cP               = response.data.cP;
            $scope.cS               = response.data.cS;
            $scope.cCr              = response.data.cCr;
            $scope.cNi              = response.data.cNi;
            $scope.cMo              = response.data.cMo;
            $scope.cAl              = response.data.cAl;
            $scope.cCu              = response.data.cCu;
            $scope.cCo              = response.data.cCo;
            $scope.cTi              = response.data.cTi;
            $scope.cNb              = response.data.cNb;
            $scope.cV               = response.data.cV;
            $scope.cB               = response.data.cB;
            $scope.cW               = response.data.cW;
            $scope.cSn              = response.data.cSn;
            $scope.cFe              = response.data.cFe; 
            $scope.cZn              = response.data.cZn; 
            $scope.cMg              = response.data.cMg;
            $scope.cPb              = response.data.cPb;
            $scope.cZn              = response.data.cZn,
            $scope.cPb              = response.data.cPb,
            $scope.cTe              = response.data.cTe,
            $scope.cAs              = response.data.cAs,
            $scope.cSb              = response.data.cSb,
            $scope.cCd              = response.data.cCd,
            $scope.cBi              = response.data.cBi,
            $scope.cAg              = response.data.cAg,
            $scope.cAi              = response.data.cAi,
            $scope.cZr              = response.data.cZr,
            $scope.cAu              = response.data.cAu,
            $scope.cSe              = response.data.cSe,


            $scope.fechaRegistro    = new Date(response.data.fechaRegistro.replace(/-/g, '\/').replace(/T.+/, ''));

            $scope.idItemSel    = response.data.idItem+' '+response.data.Rep+' '+response.data.Programa;
            //$scope.idItemSel    = response.data.idItem;
            $scope.cCarbono();
        }, function(error) {
            $scope.errors = error.message;
            alert(error);
        });
    };

    $scope.cCarbono = function(){
        //alert($scope.CodInforme);
        
        $http.post("dataRecord.php", { 
            idItem      : $scope.Otam,
            CodInforme  : $scope.CodInforme,
            accion: "calcularCarbonoEquivalente"
        })  
        .then(function(response){  
            $scope.vCarbono  = response.data.vCarbono
        }, function(error) {
            $scope.errors = error.message;
            alert(error);
        });
        
    }

    

});

