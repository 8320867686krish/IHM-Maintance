<div class="container next">
    <div class="section-1-1">
        <h3> 5.OnBoard Crew Briefing</h3>
        <table>
            <thead>
                <tr>
                  
                    <th>SR NO</th>
                    <th>Number Of Attendance</th>
                    <th>Briefing Date</th>
                    <th>Briefing By</th>
                </tr>
            </thead>
            <tbody>
                @if(count($crewBrifing) == 0)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                   
                </tr>
                @else
                @foreach($crewBrifing as $historyValue)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$historyValue->number_of_attendance}}</td>
    <td>{{$historyValue->brifing_date}}</td>
    <td>{{$historyValue->DesignatedPersonDetail->name}}</td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>

    </div>
</div>