
        @foreach($partMenual as $index=>$value)
        <tr class="new-part-mnual" data-id="{{$value['id']}}}">
             <td>{{ $start + $index }}</td>
            <td>{{$value['title']}}</td>

            <td><a href="{{$value['document']}}" download target="_blank">{{ $value->getAttributes()['document'] }}</a></td>
            <td>
            
            <a href="{{$value['document']}}" title="download"  download target="_blank" class="mr-2">
                    <span class="icon"><i class="fas fa-download  text-primary"></i></span>
                </a>
                @can('ships.edit')
                <a href="#" title="edit" class="editPopup mr-2" data-part="{{$value}}" data-doc="{{ $value->getAttributes()['document'] }}">
                    <span class="icon"><i class="fas fa-edit  text-primary"></i></span>
                </a>
                @endcan
                @can('ships.remove')

                <a href="{{url('part/remove/'.$value->id)}}" class="deletepartMenualbtn" data-id="{{$value->id}}" title="Delete"> <i class="fas fa-trash-alt text-danger"></i>
                </a>
                @endcan

            </td>
        </tr>
        @endforeach


   