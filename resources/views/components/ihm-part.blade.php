@php $title = '';
$label = 'Name of';

if ($type === 'i-1') {
$label .= 'paint';
$title .= 'I-1 Paints and coating systems';
}
else if ($type === 'i-2') {
$label .= 'equipment and machinery';
$title .= 'I-2 Equipment and machinery';
}
else {
$label .= 'structural element';
$title .= 'I-3 Strucure and hull';
}
@endphp

<div class="table-responsive">
<h4>{{$title}} containing materials listed in table A and table B of appendix 1 of these guidelines</h4>

<table class="table table-striped table-bordered first dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
    <thead>
        <tr>
            <th>No</th>
            @if($type == 'i-1')
            <th>Application of paint</th>
            @endif
            <th>{{ $label }}</th>
            <th>Location</th>
            <th>Materials(classification in appendix 1)</th>
            @if($type == 'i-2' || $type == 'i-3')
            <th>Parts where used</th>
            @endif
            <th colspan="2">Approximate Quantity</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach($checkHazmatIHMPart as $value)
        @if($value['ihm_part_table'] == $type)
        <tr>

            <td>{{$value['id']}}</td>
            @if($type == 'i-1')
            <td>{{$value['application_of_paint']}}</td>
            @endif
            <td>{{$value['name_of_paint']}}</td>
            <td>{{$value['location']}}</td>
            <td>{{$value->hazmat->name}}</td>
            @if($type == 'i-2' || $type == 'i-3')
            <td>
            {{$value->parts_where_used}}
            </td>
            @endif
            <td>
            {{$value->qty}}
            </td>
            <td>
            {{$value->unit}}
            </td>
            <td>{{$value['remarks']}}</td>

        </tr>
        @endif
        @endforeach
    </tbody>
</table>
</div>