@foreach($summary as $value)
        <tr class="new-summary" data-id="{{$value['id']}}}">
            <td>{{$value['id']}}</td>
            <td>{{$value['title']}}</td>
            <td>{{$value['version']}}</td>

            <td>{{$value['uploaded_by']}}</td>
            <td>{{$value['date']}}</td>
            <td><a href="{{$value['document']}}">{{ $value->getAttributes()['document'] }}</a></td>
            <td>
                <a href="#" class="editSummary" data-summary="{{$value}}" data-doc="{{ $value->getAttributes()['document'] }}">
                    <span class="icon"><i class="fas fa-eye text-primary"></i></span>
                </a>
                <a href="{{url('summary/remove/'.$value->id)}}" class="summarybtn" data-id="{{$value->id}}" title="Delete"> <i class="fas fa-trash-alt text-danger"></i>
                </a>
            </td>
        </tr>
        @endforeach
