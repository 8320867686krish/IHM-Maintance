@foreach($majorrepair as $value)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$value->name}}</td>
    <td>{{$value->date}}</td>
    <td>{{$value->location_name}}</td>
    <td>{{$value->document_uploaded_by}}</td>
    <td>
        @can('majorrepair.edit')
        <a href="#" rel="noopener noreferrer" data-major="{{$value}}" title="Edit" class="text-center majorrepairEdit">
            <i class="fas fa-edit text-primary" style="font-size: 1rem"></i>
        </a>
        @endcan
        @can('majorrepair.remove')
        
        <a href="{{route('majorrepair.remove', ['id' => $value->id])}}" class="ml-2 major-delete">
            <i class="fas fa-trash-alt text-danger" style="font-size: 1rem;"></i>
        </a>
        @endcan
        @if(@$value['document'])
        <a href="{{asset('uploads/majorrepair/'.$value['document'])}}" class="ml-2" target="_blank">
            <i class="fas fa-download text-primary" style="font-size: 1rem;"></i>
        </a>
        @endif
    </td>
</tr>
@endforeach