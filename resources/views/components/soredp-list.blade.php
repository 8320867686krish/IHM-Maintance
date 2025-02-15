@foreach($dpsore as $value)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$value['designatedPersonDetail']['name']}}</td>

    <td>{{$value['designatedPersonDetail']['rank']}}</td>
    <td>{{$value['designatedPersonDetail']['sign_on_date']}}</td>
    <td>{{$value['designatedPersonDetail']['sign_off_date']}}</td>
    <td>

        <a href="#" class="adminShoreDp" data-designated="{{$value}}"
            rel="noopener noreferrer" title="Edit" class="text-center">
            <i class="fas fa-edit text-primary" style="font-size: 1rem"></i>
        </a>
    </td>

</tr>
@endforeach