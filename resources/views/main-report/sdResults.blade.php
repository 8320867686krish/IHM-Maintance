<div class="container next">
    <div class="section-1-1">
        <h3>Record of Collected Supplier’s Declaration of Conformity </h3>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Issue Date</th>
                    <th>SDoC No.</th>
                    <th>Issuer’s Namer</th>
                    <th>Object(s) of Declaration</th>
                    <th>Supplier’s Declaration of Conformity</th>
                </tr>
            </thead>
            <tbody>
                @if(count($sdresults) == 0)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @else
                @foreach($sdresults as $history)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$history->sdoc_date}}</td>
                    <td>{{ $history->sdoc_no}}</td>

                    <td>{{$history->issuer_name}}</td>
                    <td>{{$history->sdoc_objects}}</td>
                    <td>{{$history->coumpany_name}}</td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>

    </div>
</div>