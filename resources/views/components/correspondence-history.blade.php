<div>

    <table class="table table-striped table-bordered first">
        <thead>
            <tr>
                <th>SR NO.</th>
                <th>Subject</th>
                <th>Ship Name</th>
                <th>Client Name</th>
                @if($currentUserRoleLevel == 1)
                    <th>Hazmat Company</th>
                @endif
                <th>Attachment</th>
                <th>Content</th>
            </tr>
        </thead>
        <tbody>
            @foreach($correspondence as $value)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$value->subject}}</td>
                <td>{{$value->shipDetail->ship_name}}</td>
                <td>{{$value->clientDetail->name}}</td>
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
        </tbody>
    </table>
</div>