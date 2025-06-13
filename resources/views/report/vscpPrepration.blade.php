<style>
    .section-1-1 table {
        border: 1px solid #000;
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .section-1-1 table td,
    th {
        border: 1px solid black;
        padding: 4px;
        text-align: left;
        font-size: 14px;
    }

    .next {
        page-break-before: always;
    }

    .section-1-1 tbody tr:nth-child(10n) {
        page-break-after: always;
    }
</style>
<div class="section-1-1">
    <h4>List Of Checks For {{$name}}</h4>
    <table>

        <tbody>

            @foreach($checks as $check)
            <tr>
                <td>Material</td>
                <td>{{ $check->hazmat->name ?? '' }}</td>
                <td>Sample No</td>
                <td>{{ $check->check->name}}</td>

            </tr>
            <tr>
                <td>Type</td>
                <td>{{ $check->check->type}}</td>
                <td>IHM Table</td>
                <td>{{ $check->ihm_part_table}}</td>

            </tr>
            <tr>
                <td>Application of paint</td>
                <td>{{ $check->application_of_paint}}</td>
                <td>Location</td>
                <td>{{ $check->location}}</td>

            </tr>

            <tr>
                <td>Materials(classification in appendix 1)</td>
                <td>{{ $check->parts_where_used}}</td>
                <td>Quantity</td>
                <td>{{ $check->qty}}</td>

            </tr>

            <tr>
                <td>Unit</td>
                <td>{{ $check->unit}}</td>
                <td>Hazmat Type</td>
                <td>{{ $check->hazmat_type}}</td>

            </tr>
            <tr colspan="2">
                <td>Remarks</td>
                <td>{{ $check->remarks}}</td>
            </tr>
            <tr>
                <td colspan="2">Close Image</td>
                <td colspan="2">Away Image</td>
            </tr>
             <tr>
                <td colspan="2">Close Image</td>
                <td colspan="2">Away Image</td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>