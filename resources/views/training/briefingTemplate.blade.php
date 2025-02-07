<html>
    <body>
        <h3 style="text-align: center;font-weight:bold">Briefing Recoreds </h3>
        <div style="margin: 0 auto;width:90%">
            <p><b>Briefing Date</b> : {{ $briefing['brifing_date']}}</p>
            <p><b>Briefing By</b> : {{  $briefing->DesignatedPersonDetail->name}}</p>
        </div>
        <table border="1" cellspacing="0" cellpadding="15" style="margin: 0 auto;width:90%">
            <thead>
                <tr>
                    <th width="8%">SR NO.</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= $briefing['number_of_attendance']; $i++)
                    <tr>
                        <td style="text-align: center;">{{ $i }}</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </body>
</html>
