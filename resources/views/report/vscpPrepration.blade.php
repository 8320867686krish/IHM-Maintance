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
    }

    .section-1-1 th,
    .section-1-1 td {
        font-size: 12pt;
        /* Exact font size for TD elements */
        padding: 8px 10px;
        vertical-align: top;
    }

    .section-1-1 .img-cell img {
        width: 150px;
        height: 150px;
        object-fit: contain;
    }

    .section-1-1 .img-cell span {
        color: #888;
        font-style: italic;
    }

    .section-1-1 table.next {
        page-break-before: always;
        page-break-inside: avoid;
        display: block;
    }
</style>


<div class="section-1-1">
    <h4>List Of Checks For {{ $name }}</h4>

    @foreach($checks as $check)
    <table class="next">
        <tbody>
            <tr>
                <td width="20%"><strong>Material</strong></td>
                <td width="30%">{{ $check->hazmat->name ?? '' }}</td>
                <td width="20%"><strong>Sample No</strong></td>
                <td width="30%">{{ $check->check->name }}</td>
            </tr>
            <tr>
                <td><strong>Type</strong></td>
                <td>{{ $check->check->type }}</td>
                <td><strong>IHM Table</strong></td>
                <td>{{ $check->ihm_part_table }}</td>
            </tr>
            <tr>
                <td><strong>Application of Paint</strong></td>
                <td>{{ $check->application_of_paint }}</td>
                <td><strong>Location</strong></td>
                <td>{{ $check->location }}</td>
            </tr>
            <tr>
                <td><strong>Parts Where Used</strong></td>
                <td>{{ $check->parts_where_used }}</td>
                <td><strong>Quantity</strong></td>
                <td>{{ $check->qty }}</td>
            </tr>
            <tr>
                <td><strong>Unit</strong></td>
                <td>{{ $check->unit }}</td>
                <td><strong>Hazmat Type</strong></td>
                <td>{{ $check->hazmat_type }}</td>
            </tr>

            <tr>
                <td colspan="2"><strong>Remarks</strong></td>
                <td colspan="2">{{ $check->remarks }}</td>
            </tr>
            <tr>
                <td colspan="2" width="50%"><strong>Close Image:</strong></td>
                <td colspan="2" width="50%"><strong>Away Image:</strong></td>
            </tr>
            <tr>
                <td colspan="2" width="50%">
                    @if($check->check->close_image)
                    <img src="{{ $check->check->close_image }}" alt="Close Image">
                    @else
                    <span>No image available</span>
                    @endif
                </td>
                <td colspan="2" width="50%">
                    @if($check->check->away_image)
                    <img src="{{ $check->check->away_image }}" alt="Away Image">
                    @else
                    <span>No image available</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @endforeach
</div>