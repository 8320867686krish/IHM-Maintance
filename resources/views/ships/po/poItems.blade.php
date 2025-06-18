@can('ships.edit')
<a href="{{ url('poOrderSample') }}" class="btn btn-primary float-right btn-rounded addNewBtn mb-3 ml-2" download>Download Sample</a>
<form method="POST" action="{{route('import')}}" enctype="multipart/form-data" id="uploadForm">
    @csrf
    <a href="#" class="btn btn-primary float-right btn-rounded addNewBtn mb-3 ml-2" onclick="document.getElementById('excel_file').click(); return false;">Import</a>
    <input type="file" name="excel_file" id="excel_file" required style="display: none;">
    <input type="hidden" name="ship_id" id="ship_id" value="{{$ship_id}}">
</form>
<a href="{{route('po.add',['ship_id'=>$ship_id])}}" class="btn btn-primary float-right btn-rounded addNewBtn mb-3">Add PO</a>
@endcan

<div class="table-responsive">
    <table class="table table-striped table-bordered first" id="porecordsTable">
        <thead>
            <tr>
                <th width="15%">SR NO</th>
                <th>PO NO</th>
                <th width="20%">Supplier Name</th>
                <th width="20%">Machinery</th>
                <th width="20%">Total No Of Items</th>
                <th>PO Status</th>
                @can('ships.edit')
                <th>Action</th>
                @endcan
            </tr>
        </thead>
        <tbody class="PoIteamstbody">
            <x-po-order-item :poOrders=$poOrders></x-po-order-item>

        </tbody>
    </table>
</div>
@push('js')

<script src="{{ asset('assets/js/poOrder.js') }}"></script>

@endpush