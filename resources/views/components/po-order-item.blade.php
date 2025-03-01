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
        <a href="#" title="Delete" class="deletePo" data-id="{{$order['id']}}"> <i class="fas fa-trash-alt text-danger"></i>
        </a>

    </td>
    @endcan
</tr>
@endforeach