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
    }



    .section-1-1 th,
    .section-1-1 td {
        font-size: 18x;
        /* Exact font size for TD elements */
        vertical-align: top;
        color: #000;
    }

    .section-1-1 .img-cell {
        vertical-align: middle;
        text-align: center;
    }

    .section-1-1 .img-cell span {
        color: #888;
        font-style: italic;
    }
</style>


<div class="section-1-1">
  
    <h2 style="padding-top:20px;text-align:center">List Of Checks For {{ $name }}</h2>
    @foreach($checks as $check)
     @if($index !== 0)
        <div style="page-break-before: always; padding-top: 40px;">
    @else
        <div style="padding-top: 40px;">
    @endif
        <table>

            <tbody>
                <tr>


                    <td><strong>Check Point ID</strong></td>
                    <td>{{ $check->check->name }}</td>

                    <td><strong>Check Point Type</strong></td>
                    <td>{{ $check->check->type }}</td>



                </tr>
                <tr>
                    <td><strong>Hazma Statust</strong></td>
                    <td>{{ $check->hazmat_type ?? '' }}</td>

                    <td><strong>Hazmat</strong></td>
                    <td>{{ $check->hazmat->name ?? '' }}</td>

                </tr>
                <tr>
                    <td><strong>Hazmat Table</strong></td>
                    <td>{{ $check->hazmat->table_type }}</td>

                    <td><strong>Name Of Equipment & Machinery</strong></td>
                    <td>{{ $check->application_of_paint }}</td>
                </tr>
                <tr>

                    <td><strong>Location</strong></td>
                    <td>{{ $check->location }}</td>

                    <td><strong>Parts Where Used</strong></td>
                    <td>{{ $check->parts_where_used }}</td>
                </tr>
                <tr>

                    <td><strong>Quantity</strong></td>
                    <td>{{ $check->qty }}</td>

                    <td><strong>Unit</strong></td>
                    <td>{{ $check->unit }}</td>
                </tr>


                <tr>
                    <td colspan="4"><strong>Remarks: </strong>{{ $check->remarks }}</td>
                </tr>
                <tr>
                    <td colspan="2" width="50%"><strong>CheckPoint Image 1:</strong></td>
                    <td colspan="2" width="50%"><strong>CheckPoint Image 2:</strong></td>
                </tr>
                <tr>
                    <td colspan="2" width="50%" class="img-cell">
                        @if($check->check->close_image)
                        <img src="{{ $check->check->close_image }}"
                            alt="Close Image"
                            width="350" height="300"
                            style="display: block; margin: 0 auto;">
                        @else
                        <span>No image available</span>
                        @endif
                    </td>


                    <td colspan="2" width="50%" class="img-cell">
                        @if($check->check->away_image)
                        <img src="{{ $check->check->away_image }}"
                            alt="Close Image"
                            width="350" height="300"
                            style="display: block; margin: 0 auto;">
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