@php $title = '';
$label = 'Name of ';

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
$filteredData = collect($checkHazmatIHMPart)->filter(function ($item) use ($type) {
return $item['ihm_table_type'] == $type;
});
@endphp

<div class="table-responsive mt-2">
    <h4>{{$title}} containing materials listed in table A and table B of appendix 1 of these guidelines</h4>

    <table class="table table-bordered mb-4 mt-4" style="width:100%">
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
                <th>App.Qty</th>
                <th>Unit</th>

                <th>Remarks</th>
            </tr>

        </thead>
        <tbody>
            @if($filteredData->isNotEmpty())
            @foreach($filteredData as $value)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$value['ihm_machinery_equipment']}}</td>
               
                <td>{{$value['ihm_location'] ?? '--'}}</td>
                <td>{{$value->hazmat->name}}</td>
                @if($type == 'i-2' || $type == 'i-3')
                <td>{{$value->ihm_parts}}</td>
                @endif
                <td>{{$value->ihm_qty}}</td>
                <td>{{$value->ihm_unit}}</td>
                <td>
                    @if(strlen($value['ihm_remarks']) > 35)
                    {{ \Illuminate\Support\Str::limit($value['ihm_remarks'], 50) }}
                    <a title="view" href="javascript:;" id="viewRemarks" data-remarks="{{$value['ihm_remarks']}}" style="color:blue">..more</a>
                    @else
                    {{ $value['ihm_remarks'] }}
                    @endif
                </td>
            </tr>
            @endforeach
            @else
            <td colspan="8" class="text-center">No Records Available</td>
            @endif
        </tbody>
    </table>
</div>