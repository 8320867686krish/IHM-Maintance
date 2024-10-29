  <a href="{{ asset('assets/sample.xlsx') }}" class="btn btn-primary float-right btn-rounded addNewBtn mb-3 ml-2" download>Download Sample</a>
                        <form method="POST" action="{{route('import')}}" enctype="multipart/form-data" id="uploadForm">
                            @csrf
                            <a href="#" class="btn btn-primary float-right btn-rounded addNewBtn mb-3 ml-2" onclick="document.getElementById('excel_file').click(); return false;">Import</a>
                            <input type="file" name="excel_file" id="excel_file" required style="display: none;">
                            <input type="hidden" name="ship_id" id="ship_id" value="{{$ship_id}}">
                        </form>
                        <a href="{{route('po.add',['ship_id'=>$ship_id])}}" class="btn btn-primary float-right btn-rounded addNewBtn mb-3">Add PO</a>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>PO NO</th>
                                        <th width="20%">Supplier Name</th>
                                        <th width="20%">Machinery</th>
                                        <th width="20%">Total No Of Items</th>
                                        <th>Action</th>
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
                                        <td>
                                            <a href="{{ route('po.add', ['ship_id' => $order['ship_id'], 'po_order_id' => $order['id'] ?? 0]) }}">
                                                <span class="icon"><i class="fas fa-eye text-primary"></i></span>
                                            </a>&nbsp;
                                            <a href="#" class="deletePo" data-id="{{$order['id']}}" title="Delete"> <i class="fas fa-trash-alt text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>