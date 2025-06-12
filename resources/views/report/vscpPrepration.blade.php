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
        <thead>
            <tr>
                <th style="width:10%">Check Name</th>
                <th style="width:10%">Check Type</th>
                <th style="width:30%">Close Image</th>
                <th style="width:30%">Away Image</th>
            </tr>

        </thead>
        <tbody>

            @foreach($checks as $check)
            <tr>
                <td>{{$check->name}}</td>
                <td>{{ $check->type }}</td>
                <td>
                    @if($check->close_image)
                    <img src="{{ $check->close_imag }}" width="130px" height="130px" />
                    @else
                    &nbsp;
                    @endif
                </td>
                <td>
                    @if($check->away_image)
                    <img src="{{ $check->away_image }}" width="130px" height="130px" />
                    @else
                    &nbsp;
                    @endif

                </td>

            </tr>

            @endforeach
        </tbody>
    </table>
</div>