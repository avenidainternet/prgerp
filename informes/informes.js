    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.RAM                  = '';
        $rootScope.usr                  = '';
        $rootScope.CodInforme           = '';
        $rootScope.tpoProx              = 0;
        $rootScope.tpoAvisoAct          = 0;
        $rootScope.Actividad            = '';
        $rootScope.estModi              = false;
        $rootScope.Acreditado           = false;
        $rootScope.msg                  = false;
        $rootScope.msgOk                = false;
        $rootScope.msgNoOk              = false;
        $rootScope.requeridaActividad   = true;
        //$rootScope.fechaUp              = new Date();
        $rootScope.fechaProxAct         = new Date();

        $rootScope.Situacion = [
            {
                codSituacion:"1",
                descripcion:"Pendiente"
            },{
                codSituacion:"2",
                descripcion:"Terminado"
            }
            ];
    

    });

    app.controller('CtrlInformes', function($scope, $http) {

            $scope.Exito                = false;
            $scope.estadoSituacion      = 'P';

            $scope.buscarInforme = function(CodInforme){
                $http.post('dataInformes.php',{
                    CodInforme:CodInforme,
                    accion:"bInforme"
                })
                .then(function (response) {
                    $scope.CodInforme           = response.data.CodInforme;
                    $scope.CodigoVerificacion   = response.data.CodigoVerificacion;
                    $scope.RutCli               = response.data.RutCli;
                    $scope.informePDF           = response.data.informePDF;
                    $scope.Detalle              = response.data.Detalle;
                    $scope.fechaUp  = new Date(response.data.fechaUp.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.DiaInforme           = response.data.DiaInforme;
                    $scope.MesInforme           = response.data.MesInforme;
                    $scope.AgnoInforme          = response.data.AgnoInforme;
                    $scope.estadoSituacion      = response.data.estadoSituacion;
                    $scope.Cliente              = response.data.Cliente;
                    $scope.Rev = $scope.informePDF.includes('Rev') ? 'Si' : 'No';
                    $scope.buscaModificaciones($scope.CodInforme);
                }, function(error) {
                    alert(error.message);
                });
            }
            $scope.cambia = function(){
               $scope.txt = $scope.Detalle;
            }
            $scope.iconoModi = function(e){
                if(e == 'on'){
                    return "fas fa-edit";
                }else{
                    return "fas fa-toggle-off";
                }
            }


            $scope.generaCodVer = function(){
                $http.post('dataInformes.php',{
                    CodInforme  : $scope.CodInforme,
                    accion      : "generaCodigoVerificacion"
                })
                .then(function (response) {
                    $scope.CodigoVerificacion  = response.data.CodigoVerificacion;
                }, function(error) {
                    console.log(error.message);
                });
            }
            $scope.Guardar = function(){
                //alert($scope.RutCli);
                var swGrabacion = false;
                var total = 0;
                var totalSinRev = 0;
                var valEstado = '';
                for(var i = 0; i < $scope.regModificaciones.length; i++){
                    var x = $scope.regModificaciones[i];
                    if(x.Estado == 'on' && x.nMod < 8){
                        total++;
                    }
                    if(x.Estado == 'on' && x.nMod == 8){
                        totalSinRev++;
                    }
                    if(x.Estado == 'on' && x.nMod == 4){
                        valEstado = 'on';
                    }
                }
                if(valEstado == 'on'){
                    alert('Problemas con el resultado del ensayo. DEBE INFORMAR A ALFREDO ARTIGAS SITUACIÓN...');
                    //document.getElementById("botonModi").value = 'Problemas con el resultado del ensayo. INFORMAR A AAA';
                }

                if(totalSinRev == 0){
                    if(total > 0){
                        swGrabacion = true;
                        if($scope.Detalle == ''){
                            alert('DEBE INGRESAR UNA DESCRIPCION...');
                            document.getElementById("Detalle").focus();
                            swGrabacion = false;
                        }
                    }else{
                        alert('DEBE SELECCIONAR AL MENOS UNA SITUACIÓN...');
                        swGrabacion = false;
                    }
                }else{
                    document.getElementById("Detalle").value = '';
                    swGrabacion = true;
                }


                if($scope.fechaUp == undefined){
                    alert('Fecha Invalida');
                    document.getElementById("fechaUp").focus();
                    swGrabacion = false;
                }

                if(swGrabacion == true){
                    $http.post('dataInformes.php',{
                        CodInforme:             $scope.CodInforme,
                        CodigoVerificacion:     $scope.CodigoVerificacion,
                        fechaUp:                $scope.fechaUp,
                        estadoSituacion:        $scope.estadoSituacion,
                        Detalle:                $scope.Detalle,
                        accion:                 "guardarDatoInforme"
                    })
                    .then(function (response) {
                        $scope.msgOk = true;
                    }, function(error) {
                       // console.log(error.message);
                        $scope.msgError = error;
                        $scope.msgNoOk = true;    
                    });
                }


                

            }
            $scope.buscaModificaciones = function(CodInforme){
                //alert($scope.CodInforme);
                $http.post('dataInformes.php',{
                    CodInforme  : $scope.CodInforme,
                    Rev         : $scope.Rev,
                    accion      : "leeRevisiones"
                })
                .then(function (response) {
                    $scope.regModificaciones  = response.data.records;
                }, function(error) {
                    console.log(error.message);
                });
            }

            $scope.marcarChek = function(nMod, Estado){
                var valEstado = Estado;
                if(Estado == 'on'){
                    Estado = 'off';
                    valEstado = 'off';
                }
                if(Estado == 'off'){
                    Estado = 'on';
                    valEstado = 'on';
                }
                if(nMod == 8 && Estado == 'on'){
                    document.getElementById("Detalle").value = '';
                }
                $http.post('dataInformes.php',{
                    CodInforme  : $scope.CodInforme,
                    Estado      : Estado,
                    nMod        : nMod,
                    fechaUp     : $scope.fechaUp,
                    accion      : "ctrlRevisiones"
                })
                .then(function (response) {
                    $scope.buscaModificaciones($scope.CodInforme);
                }, function(error) {
                    console.log(error.message);
                });
          
            }
            $scope.verColorTexto = function(nMod, Modificacion){
                mColor = 'Blanco';
                retorno = {'default-color': true};
                if(nMod == '4'){
                    retorno = {'text-danger': true};
                }
                return retorno;
            }
    
            $scope.claseModi = function(nMod, Estado){
                //alert(nMod+' '+Estado);
                if(Estado == 'on'){
                    //$scope.claseModi = true;
                    return "btn btn-primary m-1";
                }else{
                    //$scope.claseModi = false;
                    return "btn btn-danger m-1";
                }
            }

            $scope.seguimientoActividad = function(idActividad){
                $scope.msg = false;

                $scope.tpoProx      = 0;
                $scope.tpoAvisoAct  = 10;
                console.log($scope.prgActividad);
                //alert('Entra');
                $http.post('dataActividades.php',{
                    idActividad: idActividad,
                    accion:"Editar"
                })
                .then(function (response) {

                    $scope.idActividad  = response.data.idActividad;
                    $scope.Actividad    = response.data.Actividad;
                    $scope.usr          = response.data.usrResponsable;
                    $scope.Acreditado   = response.data.Acreditado;
                    $scope.prgActividad  = new Date(response.data.prgActividad.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaProxAct  = new Date(response.data.fechaProxAct.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.Estado       = response.data.Estado;
                    $scope.tpoProx      = response.data.tpoProx;
                    $scope.tpoAvisoAct  = response.data.tpoAvisoAct;
                }, function(error) {
                    alert(error.message);
                });
            }

            $scope.editarActividad = function(idActividad){
                $scope.msg = false;

                $scope.tpoProx      = 0;
                $scope.tpoAvisoAct  = 10;
                console.log($scope.prgActividad);
                //alert('Entra');
                $http.post('dataActividades.php',{
                    idActividad: idActividad,
                    accion:"Editar"
                })
                .then(function (response) {

                    $scope.idActividad  = response.data.idActividad;
                    $scope.Actividad    = response.data.Actividad;
                    $scope.usr          = response.data.usrResponsable;
                    $scope.Acreditado   = response.data.Acreditado;
                    $scope.prgActividad  = new Date(response.data.prgActividad.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaProxAct  = new Date(response.data.fechaProxAct.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.Estado       = response.data.Estado;
                    $scope.tpoProx      = response.data.tpoProx;
                    $scope.tpoAvisoAct  = response.data.tpoAvisoAct;
                }, function(error) {
                    alert(error.message);
                });
            }


            $scope.eliminarActividad = function(id, Act){
                var r = confirm("Seguro quiere Borrar actividad! "+id+'.- '+Act);
                if(r == true){
                    $http.post('dataActividades.php',{
                        idActividad:id,
                        accion:"Borrar"
                    })
                    .then(function (response) {
                        $scope.ConsultaActividades();
                    }, function(error) {
                        console.log(error.message);
                    });    
                }
            }

            $scope.actualizarActividad = function(evento){
                var swErr = false;

                var dd = $scope.prgActividad.getDate();
                var mm = $scope.prgActividad.getMonth()+1;
                var aa = $scope.prgActividad.getFullYear();
                var prgActividad = new Date($scope.prgActividad+" 00:00:00");

                if(dd<10){ dd = '0'+dd; }
                if(mm<10){ mm = '0'+mm; }
                var prgActividad = aa+'-'+mm+'-'+dd;
            
                if($scope.Actividad == ''){
                    Actividad.focus();
                    swErr = true;
                }
                //console.log(swErr);
                if($scope.usr == '' && swErr != true){
                    usr.focus();
                }
                $scope.msg = false;
                console.log($scope.msg);
                if(swErr == false){
                }

            }

    });

