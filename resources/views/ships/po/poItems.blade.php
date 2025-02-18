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
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>PO NO</th>
                                        <th width="20%">Supplier Name</th>
                                        <th width="20%">Machinery</th>
                                        <th width="20%">Total No Of Items</th>
                                        @can('ships.edit')
                                        <th>Action</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($poOrders as $order)
                                    <tr class="new-po-order" data-id="{{$order['id']}}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$order['po_no']}}</td>
                                        <td>{{$order['supplier_name']}}</td>
                                        <td>{{$order['machinery']}}</td>
                                        <td>{{$order['po_order_items_count']}}</td>
                                        @can('ships.edit')
                                        <td>
                                          
                                            <a title="Edit" href="{{ route('po.add', ['ship_id' => $order['ship_id'], 'po_order_id' => $order['id'] ?? 0]) }}">
                                                <span class="icon"><i class="fas fa-edit text-primary"></i></span>
                                            </a>&nbsp;
                                            <a href="#" title="Delete"  class="deletePo" data-id="{{$order['id']}}" > <i class="fas fa-trash-alt text-danger"></i>
                                            </a>
                                           
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        @push('js')

<script src="{{ asset('assets/js/poOrder.js') }}"></script>

@endpush