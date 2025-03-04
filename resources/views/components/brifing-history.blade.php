@foreach($brifingHistory as $historyValue)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$historyValue->number_of_attendance}}</td>
    <td>{{$historyValue->brifing_date}}</td>
    <td>{{$historyValue->DesignatedPersonDetail->name}}</td>
    <td>
        @if($historyValue->brifing_document)
        <a href="{{ asset('uploads/brifing_document/' . $historyValue['brifing_document']) }}" title="Download" download>
            <i class="fas fa-download text-primary" style="font-size: 1rem"></i>
        </a>
        @endif
    </td>
    <td>
        <a href="javascript:void(0);" class="editBrif" data-brief='{{$historyValue}}' title="Edit">
            <i class="fas fa-edit text-primary" style="font-size: 1rem"></i>
        </a>
        &nbsp;
        <a href="{{ url('briefing/download/' . $historyValue['id']) }}" title="Download">
            <i class="fas fa-download text-primary" style="font-size: 1rem"></i>
        </a>
        &nbsp;
        <a href="javascript:void(0);" class="uploadBrief" data-briefId='{{$historyValue->id}}' title="Upload">
            <i class="fas fa-upload text-primary" style="font-size: 1rem"></i>
        </a>
        <input type="file" name="brifing_document" class="fileInput" id="fileInput_{{$historyValue->id}}" data-briefid='{{$historyValue->id}}' style="display: none;" />

    </td>

</tr>
@endforeach