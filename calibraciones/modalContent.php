  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"><h4>Ensayo "{{idEnsayo}}" Muestra "{{tpMuestra}}"</h4></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <input class="form-control" type="hidden" ng-model="idEnsayo">
          <input class="form-control" type="hidden" ng-model="tpMuestra">
          <div class="row">
            <div class="col-4">
              <div class="form-group">
                 <label for="email">Símbolo Químico:</label>
                  <input class="form-control" type="text" ng-model="Simbolo" size="2" maxlength="2" autofocus required />
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                 <label for="email">Valor por Defecto:</label>
                  <input class="form-control" type="text" ng-model="valorDefecto" size="9" maxlength="9">
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                 <label for="email">Imprimible:</label>
                  <input class="form-control" type="text" ng-model="imprimible">
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <a type="button" class="btn btn-success" data-dismiss="modal" ng-click="guardarNewQu(Simbolo, valorDefecto, imprimible)">Guardar</a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
