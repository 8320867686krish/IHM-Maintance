@foreach($previousAttachment as $value)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$value->attachment_name}}</td>
    <td>{{$value->date_from}}</td>
    <td>{{$value->date_till}}</td>
    <td>{{$value->maintained_by}}</td>
    <td>
        @can('previousperson.previousihmmaintance')
        <a href="#" rel="noopener noreferrer" data-attachment={{$value}} title="Edit" class="text-center previousAttachmentEdit">
            <i class="fas fa-edit text-primary" style="font-size: 1rem"></i>
        </a>
        @endcan
        @can('previousihmmaintance.edit')

        <a href="{{route('majorrepair.remove', ['id' => $value->id])}}" class="ml-2 major-delete" title="Delete">
            <i class="fas fa-trash-alt text-danger" style="font-size: 1rem;"></i>
        </a>
        @endcan
        @if(@$value['attachment'])
        <a href="{{asset('uploads/previousattachment/'.$value['attachment'])}}" class="ml-2" target="_blank" title="Attachment">
            <i class="fas fa-download text-primary" style="font-size: 1rem;"></i>
        </a>
        @endif
    </td>
</tr>
@endforeach