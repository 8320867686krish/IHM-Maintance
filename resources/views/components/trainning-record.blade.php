@foreach($trainingRecoreds as $value)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$value->name}}</td>
    <td>{{ $value->position == 'incharge' ? 'Overall-incharge (Captain)' : 'Responsible Person' }}</td>

    <td>{{$value->rank}}</td>
    <td>{{$value->passport_number}}</td>
    <td>{{$value->sign_on_date ?? ''}}</td>
    <td>{{$value->sign_off_date ?? ''}}</td>
    @can('ships.edit')
    <td>
        
        <a href="#" class="admineditdesignatedPerson" data-designated="{{$value}}"
            rel="noopener noreferrer" title="Edit" class="text-center">
            <i class="fas fa-edit text-primary" style="font-size: 1rem"></i>
        </a>
    </td>
    @endcan
</tr>
@endforeach