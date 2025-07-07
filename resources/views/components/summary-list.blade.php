@foreach($summary as $value)
        <tr class="new-summary" data-id="{{$value['id']}}}">
            <td>{{$loop->iteration}}</td>
            <td>{{$value['title']}}</td>
            <td>{{$value['version']}}</td>

            <td>{{$value['uploaded_by']}}</td>
            <td>{{$value['date']}}</td>
            <td><a href="{{$value['document']}}">{{ $value->getAttributes()['document'] }}</a></td>
            <td>
            <a href="{{$value['document']}}" title="download"  download target="_blank" class="mr-2">
                    <span class="icon"><i class="fas fa-download  text-primary"></i></span>
                </a>
                <a href="#" title="Edit" class="editSummary mr-2" data-summary="{{$value}}" data-doc="{{ $value->getAttributes()['document'] }}">
                    <span class="icon"><i class="fas fa-edit text-primary"></i></span>
                </a>
                <a href="{{url('summary/remove/'.$value->id)}}" class="summarybtn" data-id="{{$value->id}}" title="Delete"> <i class="fas fa-trash-alt text-danger"></i>
                </a>
            </td>
        </tr>
        @endforeach
