var app = angular.module('myApp', []);

app.controller('ctrlEspectometro', function($scope, $http) {
    
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
                    .post("pruebaGuardar.php", formdata, configuracion) 
                    .then(function (respuesta) {
                        //console.log("Después de enviar los archivos, el servidor dice:", respuesta.data);
                        $scope.pdf = respuesta.data;
                        alert('Fichero subido correctamente...');
                        // window.location.href = 'lectorEspectrometro.php?up="SI"';
                    })
                    .catch(function (detallesDelError) {
                        //console.warn("Error al enviar archivos:", detallesDelError);
                        alert("Error al enviar archivos: "+ detallesDelError);
                    })
            } else {
                alert("Rellena el formulario y selecciona algunos archivos");
            }
    };


});