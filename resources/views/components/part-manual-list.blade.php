
        @foreach($partMenual as $value)
        <tr class="new-part-mnual" data-id="{{$value['id']}}}">
            <td>{{$value['id']}}</td>
            <td>{{$value['title']}}</td>
            <td>{{$value['version']}}</td>

            <td>{{$value['uploaded_by']}}</td>
            <td>{{$value['date']}}</td>
            <td><a href="{{$value['document']}}">{{ $value->getAttributes()['document'] }}</a></td>
            <td>
                <a href="#" class="editPopup" data-part="{{$value}}" data-doc="{{ $value->getAttributes()['document'] }}">
                    <span class="icon"><i class="fas fa-eye text-primary"></i></span>
                </a>
                <a href="{{url('part/remove/'.$value->id)}}" class="deletepartMenualbtn" data-id="{{$value->id}}" title="Delete"> <i class="fas fa-trash-alt text-danger"></i>
                </a>
            </td>
        </tr>
        @endforeach


   