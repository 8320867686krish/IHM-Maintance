<div class="container">
    <div class="section-1-1">
        <h2>1. Ship Particular </h2>
            <table>
                <tr>
                    <td colspan="2" align="center">
                        <b>
                            <p class="setFont">Ship Particulars Details</p>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="30%">
                        <p class="sufont">Name of Ship
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['ship_name'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">IMO Number</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['imo_number'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Call Sign</p>
                    </td>
                    <td>
                        <p class="sufont"> {{ $shipDetail['call_sign'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Type of ship</p>
                    </td>
                    <td>
                        <p class="sufont"> {{ $shipDetail['ship_type'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Port of Registry</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['port_of_registry'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Vessel Class</p>
                    </td>
                    <td>
                        <p class="sufont"> {{ $shipDetail['vessel_class'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">IHM Certifying Class</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['ihm_class'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Flag of ship</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['flag_of_ship'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Date of delivery</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['delivery_date'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Building Yard Details</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['building_details'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Dimensions (L x B x D)</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['x_breadth_depth'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Gross Tonnage (GT)</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['gross_tonnage'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Vessel Previous Name</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['vessel_previous_name'] }}</p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center"><b>
                            <p class="setfont">Ship Owner Details</p>
                        </b></td>

                </tr>
                <tr>
                    <td>
                        <p class="sufont">Ship Owner Name</p>
                    </td>
                    <td>
                        <p class="sufont"> {{ $shipDetail['ship_owner_name_initial'] }}</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p class="sufont">Ship Owner Address</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['ship_owner_address_initial'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><b>
                            <p class="setfont">Ship Manager Details</p>
                        </b></td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Ship Manager Name</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['manager_name_initial'] }}</p>
                    </td>
                </tr>


                <tr>
                    <td>
                        <p class="sufont">Ship Manager Address</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['manager_address_initial'] }}</p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center"><b>
                            <p class="setfont">Initial IHM Details</p>
                        </b></td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">IHM Report Date</p>
                    </td>
                     <td>
                        <p class="sufont">{{ $shipDetail['initial_ihm_date'] }}</p>
                    </td>
                </tr>
            <tr>
                    <td>
                        <p class="sufont">Prepared By</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['prepared_by'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Address</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['initial_address'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sufont">Approved By</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['approved_by'] }}</p>
                    </td>
                </tr>


                <tr>
                    <td>
                        <p class="sufont">Survey Location</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['survey_location'] }}</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p class="sufont">Survey Date</p>
                    </td>
                    <td>
                        <p class="sufont">{{ $shipDetail['survey_date'] }}</p>
                    </td>
                </tr>





            </table>
    </div>
</div>