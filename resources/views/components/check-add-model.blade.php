<input type="hidden" name="check_deleted_id" id="check_deleted_id" value="">

@foreach ($checkhazmat as $value)
@php $title = '';
$label = 'Name of';

if ($value['ihm_part_table'] === 'i-1') {
$label .= 'paint';
$title .= 'I-1 Paints and coating systems';
}
else if ($value['ihm_part_table'] === 'i-2') {
$label .= 'equipment and machinery';
$title .= 'I-2 Equipment and machinery';
}
else {
$label .= 'structural element';
$title .= 'I-3 Strucure and hull';
}
@endphp

<div class="col-12 col-md-12 col-lg-12 card cloneCheck" id="cloneCheck{{$value['id']}}">
    <div class="col-12 col-md-12 col-lg-12 mt-2 text-right">

        <a href="javascript:;" class="deleteCheckItem" data-itemId="{{$value['id']}}" title="Delete"><i class="fas fa-trash-alt text-danger" style="font-size: 1rem"></i></a>

    </div>

    <div class="row card-body">
        <div class="col-12 mt-2 ihm_part">
            <div class="form-group">
                <label>IHM Table</label>
                <select class="form-control ihm_part_table" name="check_hazmats[{{$value['id']}}][ihm_part_table]" data-check="{{$value['id']}}" id="ihm_part{{$value['id']}}">
                    <option value="">Select IHM</option>
                    <option value="i-1" {{ $value['ihm_part_table'] === 'i-1' ? 'selected' : '' }}>i-1</option>
                    <option value="i-2" {{ $value['ihm_part_table'] === 'i-2' ? 'selected' : '' }}>i-2</option>
                    <option value="i-3" {{ $value['ihm_part_table'] === 'i-3' ? 'selected' : '' }}>i-3</option>

                </select>
            </div>
        </div>
    </div>

    <div class="row card-body" id="itemsData{{$value['id']}}">
        <div class="col-12 mb-2">
            <h4>{{$title}} containing materials listed in table A and table B of appendix 1 of these guidelines
            </h4>
        </div>
        @if ($value['ihm_part_table'] === 'i-1')
        <div class="col-4 mb-2">
            <div class="form-group">
                <label>Application of paint</label>
                <input type="text" name="check_hazmats[{{$value['id']}}][application_of_paint]" id="application_of_paint[{{$value['id']}}]" class="form-control" value="{{$value['application_of_paint']}}">
            </div>
        </div>
        @endif
        <div class="col-4 mb-2">
            <div class="form-group">
                <label>{{$label}}</label>
                <input type="text" name="check_hazmats[{{$value['id']}}][name_of_paint]" id="name_of_paint[{{$value['id']}}]" class="form-control" value="{{$value['name_of_paint']}}">
            </div>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="check_hazmats[{{$value['id']}}][location]" id="location[{{$value['id']}}]" class="form-control" value="{{$value['location']}}">
            </div>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label>Materials(classification in appendix 1)</label>
                <select name="check_hazmats[{{$value['id']}}][hazmat_id]" id="hazmat_id[{{$value['id']}}]" class="form-control">`;
                    @foreach($hazmats as $hazmat)
                    <option value="{{$hazmat['id']}}" {{ $hazmat['id'] === $value['hazmat_id'] ? 'selected' : '' }}>{{$hazmat['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($value['ihm_part_table'] === 'i-2' || $value['ihm_part_table'] === 'i-3')

        <div class="col-4 mb-2">
            <div class="form-group">
                <label>Parts where used</label>
                <input type="text" name="check_hazmats[{{$value['id']}}][parts_where_used]" id="parts_where_used[{{$value['id']}}]" class="form-control" value="{{$value['parts_where_used']}}">
            </div>
        </div>
        @endif

        <div class="col-4 mb-2">
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="check_hazmats[{{$value['id']}}][qty]" id="qty[{{$value['id']}}]" class="form-control" value="{{$value['qty']}}">
            </div>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="check_hazmats[{{$value['id']}}][unit]" id="unit[{{$value['id']}}]" class="form-control" value="{{$value['unit']}}">
            </div>
        </div>
        <div class="col-9 mb-2">
            <div class="form-group">
                <label>Remarks</label>
                <input type="text" name="check_hazmats[{{$value['id']}}][remarks]" id="remarks[{{$value['id']}}]" class="form-control" value="{{$value['remarks']}}">
            </div>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label>Type</label>
                <select name="check_hazmats[{{$value['id']}}][hazmat_type]" id="hazmat_type[${id}]" class="form-control">
                    <option value="">Select Type</option>
                    <option value="Contained" {{ $value['hazmat_type'] === 'Contained' ? 'selected' : '' }}>Contained</option>
                    <option value="PCHM" {{ $value['hazmat_type'] === 'PCHM' ? 'selected' : '' }}>PCHM</option>
                </select>
            </div>
        </div>


    </div>
  
    <div class="row card-body strikethroughDiv" id="strikethroughDiv{{$value['id']}}">
        <div class="col-3 mb-2">
            <label class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" value="1" name="check_hazmats[{{$value['id']}}][isStrike]" id="strike[{{$value['id']}}]" data-id="{{$value['id']}}" value=1 class="custom-control-input strike" {{ $value->isStrike == 1 ? 'checked' : ''}}><span class="custom-control-label">Strike through </span>
            </label>

        </div>
    </div>
    @if($value['isStrike'] == 1)
    <div class="row card-body strikethroughDivIteam" id="strikethroughDivIteam{{$value['id']}}">
        <div class="col-12 mb-2">
            <div class="form-group">
                <label>Remarks</label>
                <textarea name="check_hazmats[{{$value['id']}}][strike_remarks]" id="strike[{{$value['id']}}]" class="form-control">{{$value['strike_remarks']}}</textarea>
            </div>
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label>Document</label>
                <input type="file" name="check_hazmats[{{$value['id']}}][strike_document]" id="strike_document[{{$value['id']}}]" class="form-control">
                @if($value['strike_document'])
                <a href="{{$value['strike_document']}}" target="_blank" style="color:blue">{{basename($value['strike_document'])}}</a>
                @endif
            </div>
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="check_hazmats[{{$value['id']}}][strike_date]" id="strike_date[{{$value['id']}}]" class="form-control" value="{{$value['strike_date']}}">
            </div>
        </div>
    </div>
    @endif

</div>
</div>
@endforeach