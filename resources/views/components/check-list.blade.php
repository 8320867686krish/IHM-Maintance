
@if (isset($checks) && $checks->count() > 0)
    @foreach ($checks as $dot)
        <li class="country-sales-content list-group-item">
            <span class="mr-2">
                <i class="flag-icon flag-icon-us" title="us" id="us"></i>
            </span>
            <span class>{{ $loop->iteration }}.{{ $dot->name }}</span>
            <div class="float-right">
                <a href="javascript:;" id="editCheckbtn"   data-id="{{$dot->id}}"  data-dotId="dot_{{ $loop->iteration }}" data-check="{{$dot}}" data-all="0"><i class="fas fa-edit text-primary" style="font-size: 1rem"></i></a>
                <a href="{{ route('check.delete', ['id' => $dot->id]) }}" class="deleteCheckbtn" data-id="{{ $dot->id }}" title="Delete"><i class="fas fa-trash-alt text-danger" style="font-size: 1rem"></i></a>
            </div>
        </li>
    @endforeach
@endif
