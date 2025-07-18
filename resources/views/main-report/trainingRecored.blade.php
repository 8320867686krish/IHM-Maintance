<div class="container next">
    <div class="section-1-1">
     <h2>7. Record of Periodic IHM Awareness Training</h2>
     <br/>

        <h3>7.1 Training Records </h3>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th width="25%">Designated Person</th>
                    <th width="25%">Designation</th>
                    <th>Date of Joining</th>
                    <th>Date of Training</th>

                </tr>
            </thead>
            <tbody>
                @if(count($exam) == 0)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>

                </tr>
                @else
                @foreach($exam as $history)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$history->designated_name}}</td>
                    <td>

                        @if($history['designatedPersonDetail']['position'] == 'incharge')
                        Overall-incharge (Captain)
                        @else
                        Responsible Person
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($history['designatedPersonDetail']['sign_on_date'])->format('d/m/Y') }}</td>
                    <td>{{ $history->created_at->format('d/m/Y') }}</td>


                </tr>
                @endforeach
                @endif

            </tbody>
        </table>


        <h3> 7.2 Briefing Records </h3>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Number Of Attendees</th>
                    <th>Briefing Date</th>
                    <th>Briefed By</th>
                    <th>Attachment</th>

                </tr>
            </thead>
            <tbody>
                @if(count($brifingHistory) == 0)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>

                </tr>
                @else
                @foreach($brifingHistory as $historyValue)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$historyValue->number_of_attendance}}</td>
                    <td>{{$historyValue->brifing_date}}</td>
                    <td>{{$historyValue['DesignatedPersonDetail']['name']}}</td>
                    @if($historyValue->brifing_document)
                    <td><a href="{{ asset('uploads/brifing_document/' . $historyValue['brifing_document']) }}" title="Download" download>
                        {{$historyValue['brifing_document']}}
                    </a></td>
                    @else
                    <td>-</td>
                    @endif

                </tr>
                @endforeach
                @endif

            </tbody>
        </table>

    </div>
</div>