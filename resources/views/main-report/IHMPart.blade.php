<div class="container">
    
    <div class="section-1-1">
         <h3>3.1 Inventory of Hazardous Materials (IHM) Part-1 </h3>
        <h5 style="text-align: center;">
            Part-1
        </h5>

        <h4 style="text-align: center;">Hazardous materials contained in the ship's structure and equipment</h4>
        <h4> Paints and coating systems containing materials listed in table A and table B of appendix 1 of these guidelines</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Application of paint</th>
                    <th>Name of paint</th>
                    <th>Location</th>
                    <th>Materials(classification in appendix 1) </th>
                    <th>App.Qty</th>
                    <th>Unit</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if(count($filteredResults1) == 0)
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
                @foreach($filteredResults1 as $key=>$value)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $value->application_of_paint ?? '' }}</td>
                    <td>{{ $value->name_of_paint ?? '' }}</td>
                    <td>{{ $value->location ?? '' }}</td>
                    <td>{{ $value->hazmat->name ?? '' }}</td>
                    <td>{{ $value->qty }}</td>
                    <td>{{ $value->unit }}</td>
                    <td>Check No:{{ $value->remarks }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>

<div class="container next">
    <div class="section-1-1">

        <h4>I-2 Equipment and machinery containing materials listed in table A and table B of appendix 1 of these guidelines </h4>
        <table>
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
                @if(count($filteredResults2) == 0)
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
                @foreach($filteredResults2 as $value)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $value->name_of_paint ?? '' }}</td>
                    <td>{{ $value->location ?? '' }}</td>
                    <td>{{ $value->hazmat->name ?? '' }}</td>
                    <td>{{ $value->parts_where_used ?? '' }}</td>

                    <td>{{ $value->qty }}</td>
                    <td>{{ $value->unit }}</td>
                    <td>Check No:; {{ $value->lab_remarks }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>


<div class="container next">
    <div class="section-1-1">
       
        <h4>I-3 Structure and hull containing materials listed in table A and table B of appendix 1 of these guidelines </h4>
        <table>
            <thead>
                <tr>
                    <th>SR No</th>
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
                @if(count($filteredResults3) == 0)
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
                @foreach($filteredResults3 as $value)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $value->application_of_paint ?? '' }}</td>
                    <td>{{ $value->name_of_paint ?? '' }}</td>
                    <td>{{ $value->location ?? '' }}</td>
                    <td>{{ $value->hazmat->name ?? '' }}</td>
                    <td>{{ $value->qty }}</td>
                    <td>{{ $value->unit }}</td>
                    <td>Check No:{{ $value->remarks }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>