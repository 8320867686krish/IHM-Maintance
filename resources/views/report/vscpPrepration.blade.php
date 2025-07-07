<style>
    .section-1-1 {
        font-family: Arial, sans-serif;
    }

    .section-1-1 h4 {
        margin-bottom: 20px;
        margin-top: 20px;
        text-align: center;
        font-size: 18px;
    }

    .section-1-1 table {
        width: 100%;
        margin-bottom: 40px;
        border-collapse: collapse;
        margin-top: 20px;
        table-layout: fixed; /* Ensures equal column widths */
    }

    .section-1-1 th,
    .section-1-1 td {
        font-size: 18px;
        vertical-align: top;
        color: #000;
        padding: 8px;
    }

    .section-1-1 .img-cell {
        vertical-align: middle;
        text-align: center;
    }

    .section-1-1 .img-cell img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    .section-1-1 .img-cell span {
        color: #888;
        font-style: italic;
    }
</style>


<div class="section-1-1">

    <h4 style="padding-top:20px;text-align:center">List Of Checks For {{ $name }}</h4>
    @foreach($checks as $index=>$check)
    @if($index !== 0)
    <div style="page-break-before: always; padding-top: 40px;">
        @else
        <div style="padding-top: 40px;">
            @endif
            <table>
                <tbody>
                    <tr>


                        <td width="20%"><strong>Check Point ID</strong></td>
                        <td width="30%">{{ $check->check->name }}</td>

                        <td width="20%"><strong>Check Point Type</strong></td>
                        <td  width="30%">{{ $check->check->type }}</td>



                    </tr>
                    <tr>
                        <td width="20%"><strong>Hazmat Status</strong></td>
                        <td width="30%">{{ $check->hazmat_type ?? '' }}</td>

                        <td width="20%"><strong>Hazmat</strong></td>
                        <td width="30%">{{ $check->hazmat->name ?? '' }}</td>

                    </tr>
                    <tr>
                        <td width="20%"><strong>Hazmat Table</strong></td>
                        <td width="30%">{{ $check->hazmat->table_type }}</td>

                        <td width="20%"><strong>Name Of Equipment & Machinery</strong></td>
                        <td width="30%">{{ $check->name_of_paint }}</td>
                    </tr>
                    <tr>

                        <td width="20%"><strong>Location</strong></td>
                        <td width="30%">{{ $check->location }}</td>

                        <td width="20%"><strong>Parts Where Used</strong></td>
                        <td width="30%">{{ $check->parts_where_used }}</td>
                    </tr>
                    <tr>

                        <td width="20%"><strong>Quantity</strong></td>
                        <td width="30%">{{ $check->qty }}</td>

                        <td  width="20%"><strong>Unit</strong></td>
                        <td width="30%">{{ $check->unit }}</td>
                    </tr>


                    <tr>
                        <td colspan="4"><strong>Remarks: </strong>{{ $check->remarks }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" width="50%"><strong>CheckPoint Image 1:</strong></td>
                        <td colspan="2" width="50%"><strong>CheckPoint Image 2:</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="img-cell" width="50%">
                            @if($check->check->close_image)
                            <img src="{{ $check->check->close_image }}" alt="Close Image" height="300px" width="350px">
                            @else
                            <span>No image available</span>
                            @endif
                        </td>
                        <td colspan="2" class="img-cell" width="50%">
                            @if($check->check->away_image)
                            <img src="{{ $check->check->away_image }}" alt="Away Image" height="300px" width="350px">
                            @else
                            <span>No image available</span>
                            @endif
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        @endforeach
    </div>
</div>