<div class="container next">
    <div class="section-1-1">
        <h2> 5. Responsible Parties For IHM Maintance: </h2>
        <div style="padding-top:20px;padding-bottom:20px;">
            <h3>5.1 Designated Person On Shore Dp</h3>
            <table>
                <thead>
                    <tr>
                        <th>SR No</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Stat/Sign On Date</th>
                        <th>End/Sign Off Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($superDpResult) > 0)
                    @foreach($superDpResult as $value)
                    <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{$value['name']}}</td>
                        <td>{{$value['position']}}</td>
                        <td>{{$value['sign_on_date']}}</td>
                        <td>{{$value['sign_off_date']}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>

                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>


        <div style="padding-top:20px;padding-bottom:20px;">
            <h3>5.2 Responsible Person On Board</h3>
            <table>
                <thead>
                    <tr>
                        <th>SR No</th>
                        <th  width="25%">Name</th>
                        <th  width="25%">Designation</th>
                        <th>Stat/Sign On Date</th>
                        <th>End/Sign Off Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($responsibleResult) > 0)
                    @foreach($responsibleResult as $value)
                    <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{$value['name']}}</td>
                        <td>
                            @if($value['position'] == 'incharge')
                            Overall-incharge (Captain)
                            @else
                            Responsible Person
                            @endif

                        </td>
                        <td>{{$value['sign_on_date']}}</td>
                        <td>{{$value['sign_off_date']}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>

                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div style="padding-top:20px;padding-bottom:20px;">
            <h3>5.3 Hazmat Company Records</h3>
            <table>
                <thead>
                    <tr>
                        <th width="10%">SR No</th>
                         <th>Maintained By</th>
                        <th>Attachment Name</th>
                        <th>Date From</th>
                        <th>Date Till</th>
                       
                        <th>Attachment File</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($previousAttachment) > 0)
                    @foreach($previousAttachment as $value)
                    <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{$value['maintained_by']}}</td>
                        <td>{{$value['attachment_name']}}</td>
                        <td>{{@$value['date_from'] ?? ''}}</td>
                        <td>{{@$value['date_till'] ?? ''}}</td>
                        <td>
                            <a href="{{ asset('uploads/previousattachment/' . $value['attachment']) }}" target="_blank">
                                {{ $value['attachment'] }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>

                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>