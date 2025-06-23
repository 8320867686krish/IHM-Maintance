


<div class="section-1-1">

    @foreach($sdocresults as $index=>$record)
    @if($index !== 0)
    <div style="page-break-before: always; padding-top: 40px;">
        @else
        <div style="padding-top: 40px;">
            @endif
            <table>
                <tbody>
                    <tr>


                        <td><strong>Hazmat </strong></td>
                        <td>{{ $record->makeModel->hazmat->name }}</td>

                        <td><strong>Equipment</strong></td>
                        <td>{{ $record->makeModel->equipment ?? '' }}</td>



                    </tr>
                    <tr>
                        <td><strong>Model</strong></td>
                        <td>{{ $record->makeModel->model ?? '' }}</td>

                        <td><strong>Make</strong></td>
                        <td>{{ $record->makeModel->make ?? '' }}</td>

                    </tr>
                    <tr>
                        <td><strong>Part</strong></td>
                        <td>{{ $record->makeModel->part ?? '' }}</td>

                        <td><strong>Manufacturer</strong></td>
                        <td>{{ $record->makeModel->manufacturer ?? '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"><strong>Other Information: </strong>{{ $record->makeModel->other_information }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center;padding-top:10px;padding-bottom:10px;"><b>SDoC Information</b></td>
                    </tr>

                    <tr>
                        <td><strong>SDoC No</strong></td>
                        <td>{{ $record->makeModel->sdoc_no ?? '' }}</td>

                        <td><strong>SDoC Date of Issue</strong></td>
                        <td>{{ $record->makeModel->sdoc_date ?? '' }}</td>
                    </tr>
                    <tr>


                        <td><strong> Issuer's Name</strong></td>
                        <td>{{ $record->makeModel->issuer_name ?? '' }}</td>

                        <td><strong>SDoC Objects</strong></td>
                        <td>{{ $record->makeModel->sdoc_objects ?? '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center;padding-top:10px;padding-bottom:10px;"><b>Supplier Information</b></td>
                    </tr>
                    <tr>


                        <td><strong> Company Name</strong></td>
                        <td>{{ $record->makeModel->coumpany_name ?? '' }}</td>

                        <td><strong>Division Name</strong></td>
                        <td>{{ $record->makeModel->division_name ?? '' }}</td>
                    </tr>
                    <tr>


                        <td><strong>Address</strong></td>
                        <td>{{ $record->makeModel->address ?? '' }}</td>

                        <td><strong>Contact Person</strong></td>
                        <td>{{ $record->makeModel->contact_person ?? '' }}</td>
                    </tr>

                    <tr>


                        <td><strong>Telephone Number</strong></td>
                        <td>{{ $record->makeModel->telephone_number ?? '' }}</td>

                        <td><strong>Fax Number</strong></td>
                        <td>{{ $record->makeModel->fax_number ?? '' }}</td>
                    </tr>

                    <tr>


                        <td><strong>E-mail address</strong></td>
                        <td>{{ $record->makeModel->email_address ?? '' }}</td>

                        <td><strong>SDoC ID-No</strong></td>
                        <td>{{ $record->makeModel->sdoc_id_no ?? '' }}</td>
                    </tr>

                    




                </tbody>
            </table>
        </div>
        @endforeach
    </div>
</div>