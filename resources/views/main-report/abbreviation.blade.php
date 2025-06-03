<div class="container">
    <div class="section-1-1">
        <h3> 1. Abbreviation </h3>
        <h5>Names and abbreviations used in this report.</h5>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Hazardous Material</th>
                    <th>Abbreviation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hazmats as $value)
                <tr>
                    <td>{{$value['table_type']}}</td>
                    <td>{{$value['name']}}</td>
                    <td>{{$value['short_name']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:30px;">
        <table>
            <thead>
                <tr>
                    <th width="40%">Document Analysis Result</th>
                    <th width="20%">Abbreviation</th>
                    <th width="30%">Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Not Contained</td>
                    <td>No</td>
                    <td>Analysed object has been <br/>found to not contain hazardous material</td>
                </tr>

                <tr>
                    <td>Below Threshold</td>
                    <td>BT</td>
                    <td>Analysed object contains hazardous material in quantity below threshold</td>
                </tr>

                <tr>
                    <td>Potentially Containing Hazardous Materials</td>
                    <td>PCHM</td>
                    <td>Analysed object doesn’t prove that it contains or not contains hazardous material</td>
                </tr>


                <tr>
                    <td>Contained</td>
                    <td>Yes</td>
                    <td>Analysed object contains hazardous material.</td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>