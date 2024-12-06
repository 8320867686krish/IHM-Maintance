@if (isset($checks) && $checks->count() > 0)
@php $count = 1; @endphp
    @foreach ($checks as $check)
        @php $hazmatsCount = count($check->hazmats); @endphp
        @if ($hazmatsCount == 0)
            <tr id="checkListTr_{{ $check->id }}">
                <td>{{ $count }}</td>
                <td>{{ $check->name }}</td>
                <td>{{ $check->type }}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                @can('ships.edit')
                    <td class="text-center">
                    <a title="Edit" href="javascript:;" id="editCheckbtn" data-id="{{$check->id}}" data-dotId="dot_{{ $loop->iteration }}"  data-check="{{$check}}" data-all="1"><i class="fas fa-edit text-primary" style="font-size: 1rem"></i></a>

                   
                    
                    </td>
                @endcan
            </tr>
            @php $count++; @endphp
        @endif
        @foreach ($check->hazmats as $index => $hazmat)
        <tr 
        id="checkListTr_{{ $check->id }}" 
        @if($check->markAsChange == 1) 
            style="background-color: #f7ff005e; color: #000000" 
        @endif
        @if($hazmat->isStrike == 1) 
            style="text-decoration: line-through;color:red" 
        @endif
    >
            <td>{{ $count }}</td>
                <td>{{ $check->name }}</td>
                <td>{{ $check->type }}</td>
                <td>{{ $hazmat->hazmat_type }}</td>
                <td>{{ $hazmat->location }} </td>
                <td>{{ $hazmat->application_of_paint }} <br> {{ $hazmat->name_of_paint }} </td>
                <td>{{ @$hazmat->hazmat->name ?? ""}}</td>
                <td>{{ $hazmat->ihm_part_table }}</td>
                <td>{{ $hazmat->qty }}</td>
                <td>{{ $hazmat->unit }}</td>
                <td>
                    @if(strlen($hazmat['remarks']) > 35)
                    {{ \Illuminate\Support\Str::limit($hazmat['remarks'], 50) }}
                    <a title="view" href="javascript:;" id="viewRemarks" data-remarks="{{$hazmat->remarks}}" style="color:blue">..more</a>
                    @else
                    {{ $hazmat['remarks'] }}
                    @endif
                </td>

                @can('ships.edit')
                    <td class="text-center">
                    <a title="Edit" href="javascript:;" id="editCheckbtn" data-dotId="dot_{{ $loop->iteration }}" data-id="{{$check->id}}}" data-check="{{$check}}"  data-all="1"><i class="fas fa-edit text-primary" style="font-size: 1rem"></i></a>

                        
                    </td>
                @endcan
            </tr>
            @php $count++; @endphp
        @endforeach
    @endforeach
@endif
