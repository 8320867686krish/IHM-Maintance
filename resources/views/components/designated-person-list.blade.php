
@if($designatePerson->isEmpty() || !$designatePerson->contains('position', $type))
    <tr>
        <td colspan="7" class="text-center">No Recored Found</td>
    </tr>
@else
@php $i = $start; @endphp

@foreach($designatePerson as $value)
@if($value['position'] == $type)
<tr>
    <td>{{ $i++ }}</td>

    <td>{{$value->name}}</td>
    <td>{{$value->rank}}</td>
    @if($type != 'SuperDp')
    <td>{{$value->passport_number}}</td>
    @endif
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