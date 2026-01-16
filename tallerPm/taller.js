var app = angular.module('myApp', []);
app.run(function($rootScope){
    $rootScope.CodInforme           = 'AM';
    $rootScope.Otam                 = '';
    $rootScope.idItem               = '';
    $rootScope.idItemSel            = '';
    $rootScope.usrResponzable       = '';
    $rootScope.tecRes               = '';
    $rootScope.tpoProx              = 0;
    $rootScope.tpoAvisoAct          = 0; 
    $rootScope.Actividad            = '';
    $rootScope.actRepetitiva        = true;
    $rootScope.respaldoEnsayo       = false;
    $rootScope.Acreditado           = false; 
    $rootScope.msg                  = false;
    $rootScope.requeridaActividad   = true;
    $rootScope.prgActividad         = new Date();
    $rootScope.fechaProxAct         = new Date();
    $rootScope.mostrarValImpacto    = true;
    $rootScope.cC                   = 0;
    $rootScope.cSi                  = 0;
    $rootScope.cMn                  = 0;
    $rootScope.cP                   = 0;
    $rootScope.cS                   = 0;
    $rootScope.cCr                  = 0;
    $rootScope.cNi                  = 0;
    $rootScope.cMo                  = 0;
    $rootScope.cAl                  = 0;
    $rootScope.cCu                  = 0;
    $rootScope.cCo                  = 0;
    $rootScope.cTi                  = 0;
    $rootScope.cNb                  = 0;
    $rootScope.cV                   = 0;
    $rootScope.cB                   = 0;
    $rootScope.cW                   = 0;
    $rootScope.cSn                  = 0;
    $rootScope.cFe                  = 0;
    $rootScope.cZn                  = 0;
    $rootScope.cPb                  = 0;
    $rootScope.cTe                  = 0;
    $rootScope.cAs                  = 0;
    $rootScope.cSb                  = 0;
    $rootScope.cCd                  = 0;
    $rootScope.cBi                  = 0;
    $rootScope.cAg                  = 0;
    $rootScope.cAi                  = 0;
    $rootScope.cZr                  = 0;
    $rootScope.cAu                  = 0;
    $rootScope.cSe                  = 0;
    $rootScope.cMg                  = 0;

});

app.controller('controlTaller', function($scope, $http) {

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

    $scope.cambiarEnsayo = function(){
        //alert($scope.CodInforme+' '+$scope.idItemSel);
        var arrayId = $scope.idItemSel.split(' ');
        //alert(arrayId.length);
        //alert(arrayId[0]+' '+arrayId[1]+' '+arrayId[2]);
        var idItem      = arrayId[0];
        var Rep         = arrayId[1];
        var Programa    = arrayId[2];

        $http.post("dataRecord.php", {
            CodInforme: $scope.CodInforme,
            idItem:     idItem,
            Rep:        Rep,
            Programa:   Programa,
            accion: "cambiarEnsayoGraba"
        })  
        .then(function(response){ 
            alert('Actualizado ensayo...'); 
            $scope.leerEnsayos(idItem, $scope.CodInforme);
            //window.location.href = 'iQuimico.php?Otam='+idItem+'&CodInforme='+$scope.CodInforme;
        }, function(error) {
            $scope.errors = error.message; 
            alert(error);
        });


    }
    
    $scope.Actualizando = function(Estado){
        alert("Actualiza... "+$scope.Otam); 
        $http.post("dataRecord.php", { 
            Estado:         Estado,
            idItem:         $scope.Otam,
            Rep:            $scope.Rep,
            Programa:       $scope.Programa,
            Temperatura:    $scope.Temperatura,
            Humedad:        $scope.Humedad,
            Observacion:    $scope.Observacion,
            tecRes         :$scope.tecRes,
            fechaRegistro  :$scope.fechaRegistro,
            cC             :$scope.cC,
            cSi            :$scope.cSi,
            cMn            :$scope.cMn,
            cP             :$scope.cP,
            cS             :$scope.cS,
            cCr            :$scope.cCr,
            cNi            :$scope.cNi,
            cMo            :$scope.cMo,
            cAl            :$scope.cAl,
            cCu            :$scope.cCu,
            cCo            :$scope.cCo,
            cTi            :$scope.cTi,
            cNb            :$scope.cNb,
            cV             :$scope.cV,
            cB             :$scope.cB,
            cW             :$scope.cW,
            cSn            :$scope.cSn,
            cFe            :$scope.cFe,
            cZn            :$scope.cZn,
            cMg            :$scope.cMg,
            cPb            :$scope.cPb,
            cZn            :$scope.cZn,
            cPb            :$scope.cPb,
            cTe            :$scope.cTe,
            cAs            :$scope.cAs,
            cSb            :$scope.cSb,
            cCd            :$scope.cCd,
            cBi            :$scope.cBi,
            cAg            :$scope.cAg,
            cAi            :$scope.cAi,
            cZr            :$scope.cZr,
            cAu            :$scope.cAu,
            cSe            :$scope.cSe,
            accion         : "grabarQuimico"
        })  
        .then(function(response){  
            alert("Guardado correctamente...")
            window.location.href = 'iQuimico.php?Otam='+$scope.Otam+'&CodInforme='+$scope.CodInforme;

            //$scope.idItemSel    = response.data.idItem;
        }, function(error) {
            $scope.errors = error.message;
            alert(error.message);
        });

    }

});

