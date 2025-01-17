@foreach($trainingRecoreds as $value)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$value->name}}</td>
    <td>{{ $value->position == 'incharge' ? 'Overall-incharge (Captain)' : 'Responsible Person' }}</td>

    <td>{{$value->rank}}</td>
    <td>{{$value->passport_number}}</td>
    <td>{{$value->sign_on_date}}</td>
    <td>{{$value->sign_off_date}}</td>


</tr>
@endforeach