    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.RAM                  = '';
        $rootScope.usr                  = '';
        $rootScope.usrResponzable       = '';
        $rootScope.tpoProx              = 0;
        $rootScope.tpoAvisoAct          = 0;
        $rootScope.Actividad            = '';
        $rootScope.actRepetitiva        = true;
        $rootScope.Acreditado           = false;
        $rootScope.msg                  = false;
        $rootScope.requeridaActividad   = true;
        $rootScope.prgActividad         = new Date();
        $rootScope.fechaProxAct         = new Date();

    });

    app.controller('CtrlActividades', function($scope, $http, $interval) {


        const $archivosSeg = document.querySelector("#archivosSeguimiento");
        $scope.fileName = $archivosSeg;
        $scope.enviarFormularioSeg = function (evento) {
            //console.log($scope.idActividad);
            let archivosSeg = $archivosSeg.files;
                if (archivosSeg.length > 0) {
                    let formdata = new FormData();
    
                    // Agregar cada archivo al formdata
                    angular.forEach(archivosSeg, function (archivosSeg) {
                        formdata.append(archivosSeg.name, archivosSeg);
                    });
     
                    // Finalmente agregamos el nombre
                    formdata.append("CAM", $scope.idActividad);
                    $scope.res = formdata;
     
                    // Hora de enviarlo
     
                    // Primero la configuración
                    let configuracion = {
                        headers: {
                            "Content-Type": undefined,
                        },
                        transformRequest: angular.identity,
                    };
                    var id = $scope.idActividad;
                    // Ahora sí
                    $http
                        .post("guardar_archivos.php?id="+id+"&evento="+evento+"&Actividad="+$scope.Actividad, formdata, configuracion) 
                        .then(function (respuesta) {
                            //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                            $scope.pdf = respuesta.data;
                        })
                        .catch(function (detallesDelError) {
                            //console.warn("Error al enviar archivos:", detallesDelError);
                            alert("Error al enviar archivos: "+ detallesDelError);
                        })
                } else {
                    alert("Rellena el formulario y selecciona algunos archivos");
                }
        };

        const $archivos2 = document.querySelector("#archivosActividad");
        $scope.fileName = $archivos2;
        $scope.enviarFormularioAct = function (evento) {
            //console.log($scope.idActividad);
            let archivos2 = $archivos2.files;
                if (archivos2.length > 0) {
                    let formdata = new FormData();
    
                    // Agregar cada archivo al formdata
                    angular.forEach(archivos2, function (archivo2) {
                        formdata.append(archivo2.name, archivo2);
                    });
     
                    // Finalmente agregamos el nombre
                    formdata.append("CAM", $scope.idActividad);
                    $scope.res = formdata;
     
                    // Hora de enviarlo
     
                    // Primero la configuración
                    let configuracion = {
                        headers: {
                            "Content-Type": undefined,
                        },
                        transformRequest: angular.identity,
                    };
                    var id = $scope.idActividad;
                    // Ahora sí
                    $http
                        .post("guardar_archivos.php?id="+id+"&evento="+evento+"&Actividad="+$scope.Actividad, formdata, configuracion) 
                        .then(function (respuesta) {
                            //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                            $scope.pdf = respuesta.data;
                        })
                        .catch(function (detallesDelError) {
                            //console.warn("Error al enviar archivos:", detallesDelError);
                            alert("Error al enviar archivos: "+ detallesDelError);
                        })
                } else {
                    alert("Rellena el formulario y selecciona algunos archivos");
                }
        };

        const $archivos = document.querySelector("#archivos");
        $scope.fileName = $archivos;
        $scope.enviarFormulario = function (evento) {
            //console.log($scope.idActividad);
            let archivos = $archivos.files;
                if (archivos.length > 0) {
                    let formdata = new FormData();
    
                    // Agregar cada archivo al formdata
                    angular.forEach(archivos, function (archivo) {
                        formdata.append(archivo.name, archivo);
                    });
     
                    // Finalmente agregamos el nombre
                    formdata.append("CAM", $scope.idActividad);
                    $scope.res = formdata;
     
                    // Hora de enviarlo
     
                    // Primero la configuración
                    let configuracion = {
                        headers: {
                            "Content-Type": undefined,
                        },
                        transformRequest: angular.identity,
                    };
                    var id = $scope.idActividad;
                    // Ahora sí
                    $http
                        .post("guardar_archivos.php?id="+id+"&evento="+evento+"&Actividad="+$scope.Actividad, formdata, configuracion) 
                        .then(function (respuesta) {
                            //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                            $scope.pdf = respuesta.data;
                        })
                        .catch(function (detallesDelError) {
                            //console.warn("Error al enviar archivos:", detallesDelError);
                            alert("Error al enviar archivos: "+ detallesDelError);
                        })
                } else {
                    alert("Rellena el formulario y selecciona algunos archivos");
                }
            };
        


            $interval(function () {
                var d = new Date();
                var t = d.toLocaleTimeString();
                document.getElementById("hora").innerHTML = t;
            }, 1000);

            $scope.Exito = false;
    
            $scope.buscaActividad = function(){
                $scope.prgActividad = new Date();
                $scope.fechaProxAct = new Date();
                $scope.tpoProx      = 0;
                $scope.tpoAvisoAct  = 10;
                $scope.Actividad    = '';
                $scope.msg          = false;
                //alert('Entra');
                $http.post('dataActividades.php',{
                    accion:"Ultima"
                })
                .then(function (response) {
                    $scope.idActividad  = response.data.idActividad;
                    //alert($scope.idActividad);
                }, function(error) {
                    alert(error.message);
                });
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

            $scope.ConsultaActividades = function(){
                $http.post('dataActividades.php',{
                    accion:"Lectura"
                })
                .then(function (response) {
                    $scope.regActividades  = response.data.records;
                }, function(error) {
                    console.log(error.message);
                });
            }
            $scope.ConsultaUsuarios = function(){
                $http.post('dataActividades.php',{
                    accion:"Usuarios"
                })
                .then(function (response) {
                    $scope.regUsuarios  = response.data.records;
                    console.log($scope.regUsuarios);
                }, function(error) {
                    console.log(error.message);
                });
            }
            $scope.ConsultaUsuarios();

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

            $scope.ConsultaActividades();

            $scope.diasPrgAct = function(){
                if($scope.tpoProx == ''){
                    $scope.tpoProx = 0;
                }
                var fecha = new Date();
                fecha.setDate($scope.prgActividad.getDate() + parseInt($scope.tpoProx));
                $scope.fechaProxAct = fecha;
            }
            $scope.fechaProgActEd = function() {
                $scope.prgActividad = $scope.prgActividad;
            }
            $scope.fechaProgAct = function() {
                if($scope.tpoProx == ''){
                    $scope.tpoProx = 0;
                }
                //console.log($scope.prgActividad);
                $scope.fechaProxAct = $scope.prgActividad;
                var fecha = $scope.prgActividad;
                fecha.setDate(fecha.getDate() + parseInt($scope.tpoProx));
                //alert(fecha);
            }

            $scope.guardarActividad = function(evento){
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
                if(swErr == false){
                    $http.post('dataActividades.php',{
                        idActividad:    $scope.idActividad,
                        Actividad:      $scope.Actividad,
                        actRepetitiva:  $scope.prgActividad,
                        Acreditado:     $scope.Acreditado,
                        usrResponsable: $scope.usr,
                        prgActividad:   $scope.prgActividad,
                        tpoProx:        $scope.tpoProx,
                        tpoAvisoAct:    $scope.tpoAvisoAct,
                        fechaProxAct:   $scope.fechaProxAct,
                        dd:             dd,
                        mm:             mm,
                        aa:             aa,
                        accion:"Grabar"
                    })
                    .then(function (response) {
                        console.log('GrabaOK');
                        $scope.enviarFormulario(evento);
                        $scope.msg = true;
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
                    $http.post('dataActividades.php',{
                        idActividad:    $scope.idActividad,
                        Actividad:      $scope.Actividad,
                        actRepetitiva:  $scope.prgActividad,
                        Acreditado:     $scope.Acreditado,
                        usrResponsable: $scope.usr,
                        prgActividad:   $scope.prgActividad,
                        tpoProx:        $scope.tpoProx,
                        tpoAvisoAct:    $scope.tpoAvisoAct,
                        fechaProxAct:   $scope.fechaProxAct,
                        dd:             dd,
                        mm:             mm,
                        aa:             aa,
                        accion:"Grabar"
                    })
                    .then(function (response) {
                        $scope.msg = true;
                        console.log('GrabaOK');
                        //$scope.enviarFormularioAct(evento);
                        $scope.ConsultaActividades();
                    }, function(error) {
                        console.log(error.message);
                    });    
                }

            }

            $scope.subirActividad = function(evento){
                var swErr = false;
                var dd = $scope.prgActividad.getDate();
                var mm = $scope.prgActividad.getMonth()+1;
                var aa = $scope.prgActividad.getFullYear();
                var prgActividad = new Date($scope.prgActividad+" 00:00:00");
                $scope.msg = false;
                if(dd<10){ dd = '0'+dd; }
                if(mm<10){ mm = '0'+mm; }
                var prgActividad = aa+'-'+mm+'-'+dd;
            
                if(swErr == false){
                    $http.post('dataActividades.php',{
                        idActividad:    $scope.idActividad,
                        accion:"Seguimiento"
                    })
                    .then(function (response) {
                        console.log('GrabaOK');
                        $scope.enviarFormularioSeg(evento);
                        $scope.msg = true;

                        $scope.ConsultaActividades();
                    }, function(error) {
                        console.log(error.message);
                    });    
                }

            }
        $scope.lecturaUsuarios = function(){
            $scope.errors = "";
            $http.get("leerUsuarios.php")  
            .then(function(response){  
                $scope.Ingenieros = response.data.records; 
            }, function(error) {
                $scope.errors = error.message;
            });
        }


        $scope.verColorLinea = function(fAct, tAviso){
            var fActual = new Date();
            var fAct = new Date(fAct);

            var diferencia= Math.abs(fActual-fAct);
            dias = parseInt(diferencia/(1000 * 3600 * 24));

            mColor = 'Blanco';
            retorno = {'default-color': true};
            if(fAct > fActual){
                //console.log('Fecha posterior '+dias);
                retorno = {'verde-class': true};
                if(dias <= tAviso){
                    retorno = {'amarillo-class': true};
                }
            }else{
                retorno = {'rojo-class': true};
                if(dias == 0){
                    retorno = {'amarillo-class': true};
                }

            }
            //console.log(dias);
            return retorno;
        }

    });

