<div class="container next">
    <div class="section-1-1">
        <h3> 2 Record of Inventory of Hazardous Material On-board</h3>
        <h5>2.1. Particulars of the Ship:</h5>
        <table>
            <tr>
                <td colspan="2" align="center">
                    <b><p class="setFont">Ship Particulars Details</p></b>
                </td>
            </tr>
            <tr>
                <td width="30%">
                    <p class="sufont">Name of Ship
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['ship_name'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">IMO Number</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['imo_number'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Call Sign</p>
                </td>
                <td>
                    <p class="sufont"> {{ $projectDetail['call_sign'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Type of ship</p>
                </td>
                <td>
                    <p class="sufont"> {{ $projectDetail['ship_type'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Port of Registry Kunching</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['port_of_registry'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Vessel Class</p>
                </td>
                <td>
                    <p class="sufont"> {{ $projectDetail['vessel_class'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">IHM Certifying Class</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['ihm_class'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Flag of ship</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['flag_of_ship'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Date of delivery</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['delivery_date'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Building Yard Details</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['building_details'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Dimensions (L x B x D)</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['x_breadth_depth'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Gross Tonnage (GT)</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['gross_tonnage'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Vessel Previous Name</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['vessel_previous_name'] }}</p>
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
                    <p class="sufont"> {{ $projectDetail['client']->owner_name }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Ship Owner Email</p>
                </td>
                <td>
                    <p class="sufont"> {{ $projectDetail['client']->owner_email }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Ship Owner Phone</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['client']->owner_phone }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Ship Owner Address</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['client']->owner_address }}</p>
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
                    <p class="sufont">{{ $projectDetail['client']->manager_name }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Ship Manager Email</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['client']->manager_email }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Ship Manager Phone</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['client']->manager_phone }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sufont">Ship Manager Address</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['client']->manager_address }}</p>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center"><b>
                        <p class="setfont">Survey Details</p>
                    </b></td>
            </tr>
           
            <tr>
                <td>
                    <p class="sufont">Survey Location Name</p>
                </td>
                <td>
                    <p class="sufont">{{ $projectDetail['survey_location'] }}</p>
                </td>
            </tr>
         
           

         
         
        </table>
        <p>
        This inventory was developed in accordance with the IMO Guidelines for the Development of the Inventory of Hazardous Materials.
        This IHM has been developed to cover additional requirements of the EU Ship Recycling Regulation (EU) 1257/2013.
        </p>

        <h5>2.2 Initially Prepared By:</h5>
        <table>
            <tbody>
                <tr>
                    <td><b>Name</b></td>
                    <td>SOS INDIA</td>
                </tr>

                <tr>
                    <td><b>Initials</b></td>
                    <td>SOS</td>
                </tr>

                <tr>
                    <td><b>Company</b></td>
                    <td>SOS INDIA PRIVATE LIMITED</td>
                </tr>

                <tr>
                    <td><b>Address</b></td>
                    <td>GROUND FLOOR,OFFICE NO-46,AGARWAL TRADE CENTRE,PLOT NO62,SECTOR-11,CBD BELAPUR ,NAVI MUMBAI</td>
                </tr>

                <tr>
                    <td><b>Position</b></td>
                    <td>IHM SERVICE SUPPLIER</td>
                </tr>

                <tr>
                    <td><b>Date</b></td>
                    <td>18.04.2021</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
