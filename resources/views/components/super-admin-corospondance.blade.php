
            @foreach($admincorrespondence as $value)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$value->subject}}</td>
                @if($currentUserRoleLevel == 1)
                    <td>{{$value->hmatCompanyDetail->name}}</td>
                @endif
                <td>
                    <a href="{{ asset('uploads/corospondance_attachment/' . $value->attachment) }}" target="_blank">
                        {{ $value->attachment }}
                    </a>
                </td>
                <td>
                    @if(strlen($value['content']) > 35)
                    {!! \Illuminate\Support\Str::limit($value['content'], 50) !!}
                    <a title="view" href="javascript:;" id="viewRemarks" data-remarks="{!! $value['content'] !!}"
                        style="color:blue">..more</a>
                    @else
                    {!! $value['content'] !!}
                    @endif

                </td>
            </tr>
            @endforeach
       