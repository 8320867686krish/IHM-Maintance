@if($designatePerson->isEmpty() || !$designatePerson->contains('position', $type))
    <tr>
        <td colspan="7" class="text-center">No Recored Found</td>
    </tr>
@else
@foreach($designatePerson as $value)
@if($value['position'] == $type)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$value->name}}</td>
    <td>{{$value->rank}}</td>
    <td>{{$value->passport_number}}</td>
    <td>{{$value->sign_on_date}}</td>
    <td>{{$value->sign_off_date}}</td>
    <td>
        <a href="#" class="editdesignatedPerson" data-designated="{{$value}}"
            rel="noopener noreferrer" title="Edit" class="text-center">
            <i class="fas fa-edit text-primary" style="font-size: 1rem"></i>
        </a>
    </td>
</tr>
@endif
@endforeach
@endif