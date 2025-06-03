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
    @if($currentUserRoleLevel == 2)
        <td>
            @if($value['isRead'] == 1)
            <span>-</span>
            @else
              <label class="switch float-right">
                <input class="switch-input" type="checkbox" data-corrospondanceId="{{$value['id']}}" {{ $value['isRead']  ? 'checked' : '' }}>
                <span class="switch-label" data-on="" data-off=""></span>
                <span class="switch-handle"></span>
            </label>
            @endif
          
        </td>
    @endif
</tr>
@endforeach