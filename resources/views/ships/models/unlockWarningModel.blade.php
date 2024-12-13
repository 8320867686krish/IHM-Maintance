<div class="modal" tabindex="-1" role="dialog" id="unlockModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Unlock Vscp</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="amededmodel" id="amededmodel">
        <p class="remrksText">before unlock plese download summery report.</p>
      </div>
      <div class="modal-footer">
            
                <a type="button" class="btn btn-primary downloadReport" href="{{url('summeryReport/'.$ship_id)}}" download  target="_self">Download</a>
            </div>
      
    </div>
  </div>
</div>