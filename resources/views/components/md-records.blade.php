@foreach($mdnoresults as $value)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$value['md_date']}}</td>
    <td>{{$value['md_no']}}</td>
    <td>{{$value['coumpany_name']}}</td>
    <td>&nbsp;</td>
    <td>{{$value['hazmat_names']}}</td>



</tr>
@endforeach