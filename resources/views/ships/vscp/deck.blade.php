 <div class="title"><span>VSCP</span>
     @can('ships.edit')
     <div style="float:right">
         <button class="btn btn-primary" onclick="triggerFileInput('pdfFile')">Add</button>&nbsp;&nbsp;
       
         <input type="file" id="pdfFile" name="pdfFile" accept=".pdf" style="display: none;">
     </div>


     @endcan
 </div>
 <div class="row mt-4 deckView">
    @if (isset($ship->decks) && $ship->decks->count() > 0)
    <x-deck-list :decks="$ship->decks" :amended="$amended" />
    
    @endif
</div>


<div class="modal fade" data-backdrop="static" id="deckEditFormModal" tabindex="-1" role="dialog" aria-labelledby="deckEditFormModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Title</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span>×</span>
                </a>
            </div>
            <form method="post" id="deckEditForm" action="{{ route('updateDeckDetails') }}">
            <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="deckEditFormId">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="deckEditSubmitBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel"  style="padding-right: 0px !important;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document" style="width: 98% !important; max-width: none !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Deck Title</h5>
                <a href="#" class="close pdfModalCloseBtn" data-dismiss="modal" aria-label="Close">
                    <span >&times;</span>
                </a>
            </div>
            <div class="modal-body" style="overflow-x: auto; overflow-y: auto; height: calc(81vh - 1rem);">
                <div class="d-flex justify-content-center align-items-center spinnerDiv">
                    {{-- style="height: 100%;" --}}
                    <span class="dashboard-spinner spinner-md text-center"></span>
                </div>
                <div id="img-container" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-secondary pdfModalCloseBtn" data-dismiss="modal">Close</a>
                <button class="btn btn-primary" id="getDeckCropImg" data-id="{{ $ship_id }}">Save</button>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    var shipData = "{{ $ship_id }}";
    var token = "{{ csrf_token() }}";
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
<script src="{{ asset('assets/vendor/jquery.areaSelect.js') }}"></script>
<script src="{{ asset('assets/js/vscp.js') }}"></script>


@endpush