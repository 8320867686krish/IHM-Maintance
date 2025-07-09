<div class="container">
    <div class="section-1-1">
        <div style="padding-top: 20px;">
            <p>Addendum to IHM due to maintenance, changes in the structure & equipment of the ship
                Hazardous materials contained in the ship’s structure and equipment</p>
            <h5> Part I-1 – Paints and coating systems containing materials listed in table A and table B of appendix 1 of the IMO guidelines </h5>
            <table style="page-break-inside:avoid">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Application of paint</th>
                        <th>Location</th>
                        <th>Materials(classification in appendix 1) </th>
                        <th>App.Qty</th>
                        <th>Unit</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($filteredResultsAddendum1) == 0)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @else
                    @foreach($filteredResultsAddendum1 as $key=>$value)
                    <tr>
                        <td>{{ $loop->iteration}}</td>
                        <td>{{ $value->ihm_machinery_equipment ?? '' }}</td>
                        <td>{{ $value->ihm_location ?? '' }}</td>
                        <td>{{ $value->hazmat->name ?? '' }}</td>
                        <td>{{ $value->ihm_qty }}</td>
                        <td>{{ $value->unit }}</td>
                        @php
                        $table_type = substr($value->hazmat->table_type ?? '', 0, 1)  
                        @endphp
                        @if($table_type == 'A')
                        <td>As A{{ $value->remarks }}</td>
                        @else
                        <td>On {{$value->ihm_last_date}} {{$value->ihm_previous_qty}}{{$value->ihm_previous_unit}},As Of {{$value->ihm_date}}  {{$value->ihm_date}} {{$value->ihm_qty}}{{$value->ihm_unit}},{{ $value->remarks }}</td>
                        @endif
                        
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>


        <div style="padding-top: 20px;">

            <h5> Part I-2 – Equipment and machinery containing materials listed in table A and table B of appendix 1 of the IMO guidelines </h5>
            <table style="page-break-inside:avoid">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name of equipment and machinery</th>
                        <th>Location</th>
                        <th>Materials (classification in appendix 1)</th>
                        <th>Parts where used</th>
                        <th>App.Qty</th>
                        <th>Unit</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($filteredResultsAddendum2) == 0)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @else
                    @foreach($filteredResultsAddendum2 as $value)
                    <tr>
                        <td>{{ $loop->iteration}}</td>
                        <td>{{ $value->ihm_machinery_equipment ?? '' }}</td>
                        <td>{{ $value->ihm_location ?? '' }}</td>
                        <td>{{ $value->hazmat->name ?? '' }}</td>
                        <td>{{ $value->ihm_parts ?? '' }}</td>

                        <td>{{ $value->ihm_qty }}</td>
                        <td>{{ $value->unit }}</td>
                        @php
                        $table_type = substr($value->hazmat->table_type ?? '', 0, 1)  
                        @endphp
                        @if($table_type == 'A')
                        <td>As A{{ $value->remarks }}</td>
                        @else
                        <td>On {{$value->ihm_last_date}} {{$value->ihm_previous_qty}}{{$value->ihm_previous_unit}},As Of {{$value->ihm_date}}  {{$value->ihm_date}} {{$value->ihm_qty}}{{$value->ihm_unit}},{{ $value->remarks }}</td>
                        @endif
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

        </div>

        <div style="padding-top: 20px;">


            <h5> Part I-3 – Structure and hull containing materials listed in table A and table B of appendix 1 of the IMO guidelines </h5>
            <table style="page-break-inside:avoid">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name of structural element</th>
                        <th>Location</th>
                        <th>Materials(classification in appendix 1) </th>
                        <th>Parts where used</th>
                        <th>App.Qty</th>
                        <th>Unit</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($filteredResultsAddendum3) == 0)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @else
                    @foreach($filteredResultsAddendum3 as $value)
                    <tr>
                        <td>{{ $loop->iteration}}</td>
                        <td>{{ $value->ihm_machinery_equipment ?? '' }}</td>
                        <td>{{ $value->ihm_location ?? '' }}</td>
                        <td>{{ $value->hazmat->name ?? '' }}</td>
                        <td>{{ $value->ihm_parts ?? '' }}</td>
                        <td>{{ $value->ihm_qty }}</td>
                        <td>{{ $value->unit }}</td>
                        @php
                        $table_type = substr($value->hazmat->table_type ?? '', 0, 1)  
                        @endphp
                        @if($table_type == 'A')
                        <td>As A{{ $value->remarks }}</td>
                        @else
                        <td>On {{$value->ihm_last_date}} {{$value->ihm_previous_qty}}{{$value->ihm_previous_unit}},As Of {{$value->ihm_date}}  {{$value->ihm_date}} {{$value->ihm_qty}}{{$value->ihm_unit}},{{ $value->remarks }}</td>
                        @endif
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

        </div>
    </div>