<table class="table table-dark table-hover" style="margin-top: 5px;" ng-show="tablaCAM">
		<thead>
			<tr>
				<th>&nbsp; 		</th>
				<th>CAM			</th>
				<th>Fecha		</th>
				<th>Clientes	</th>
				<th>Validez		</th>
				<th>ASOCIAR	    </th>
			</tr>
		</thead>
		<tbody>

			<tr ng-repeat="Cam in CotizacionesCAM | filter: filtroClientes" 
				ng-class="verColorLinea(Cam.Estado, Cam.RAM, Cam.BrutoUF, Cam.nDias, Cam.rCot, Cam.fechaAceptacion, Cam.proxRecordatorio, Cam.colorCam)">

				<td>
					<div ng-if="Cam.Clasificacion > 0">
						<br>
						<div ng-if="Cam.Clasificacion == 1">
							<img src="../../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
						<div ng-if="Cam.Clasificacion == 2">
							<img src="../../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
						<div ng-if="Cam.Clasificacion == 3">
							<img src="../../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
					</div>
				</td>
				<td>
					C{{Cam.CAM}}<br>
					<div ng-if="Cam.RAM > 0">
						R{{Cam.RAM}} 
					</div>
					<div ng-if="Cam.Rev > 0">
						Rev. 0{{Cam.Rev}} 
					</div>
					<div ng-if="Cam.fechaAceptacion != '0000-00-00'">
						<span class="badge badge-warning">Aceptada</span> 
					</div>
					<div ng-if="Cam.sDeuda > 0">
						<img class="p-2" src="../../imagenes/bola_amarilla.png">
						<h5><span class="badge badge-warning" title="Moroso">{{Cam.sDeuda | currency:"$ ":0}}</span></h5>
					</div>

				</td>
				<td>
					{{Cam.fechaCotizacion | date:'dd/MM'}}<br>
					{{Cam.usrCotizador}}
				</td>
				<td>{{Cam.Cliente}}</td>
				<td>
					<!-- {{Cam.fechaEstimadaTermino | date:'dd/MM'}} -->
					{{Cam.fechaxVencer | date:'dd/MM'}}<br>
					{{Cam.fechaTermino | date:'dd/MM'}}<br>
					<span class="badge badge-pill badge-danger" ng-if="Cam.nDias < 0">
						<h6>{{Cam.nDias}}</h6>
					</span>
					<span class="badge badge-pill badge-primary" ng-if="Cam.nDias > 0">
						<h6>{{Cam.nDias}}</h6>
					</span>
					<br>
				</td>
				<td>
					<div ng-if="Cam.RAM == 0 || Cam.RAM == RAM">
						<button type="button" ng-if="CAM != Cam.CAM"
								ng-click="asociarMuestra(RAM,Cam.CAM, Fan)"
								class="btn btn-warning">
								<i class="fas fa-bezier-curve"></i>
						</button>
						<button type="button" ng-if="CAM == Cam.CAM"
								ng-click="desasociarMuestra(RAM,Cam.CAM, Fan)"
								title="Desasociar"
								class="btn btn-danger">
								<i class="fas fa-crop"></i>
						</button>
					</div>
		        </td>
			</tr>
		</tbody>
	</table>
