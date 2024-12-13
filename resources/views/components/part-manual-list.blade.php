
        @foreach($partMenual as $value)
        <tr class="new-part-mnual" data-id="{{$value['id']}}}">
            <td>{{$value['id']}}</td>
            <td>{{$value['title']}}</td>
            <td>{{$value['version']}}</td>

            <td>{{$value['uploaded_by']}}</td>
            <td>{{$value['date']}}</td>
            <td><a href="{{$value['document']}}" download target="_blank">{{ $value->getAttributes()['document'] }}</a></td>
            <td>
            <a href="{{$value['document']}}" title="download"  download target="_blank" class="mr-2">
                    <span class="icon"><i class="fas fa-download  text-primary"></i></span>
                </a>
                <a href="#" title="edit" class="editPopup mr-2" data-part="{{$value}}" data-doc="{{ $value->getAttributes()['document'] }}">
                    <span class="icon"><i class="fas fa-edit  text-primary"></i></span>
                </a>
                <a href="{{url('part/remove/'.$value->id)}}" class="deletepartMenualbtn" data-id="{{$value->id}}" title="Delete"> <i class="fas fa-trash-alt text-danger"></i>
                </a>
            </td>
        </tr>
        @endforeach


   