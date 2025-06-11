<div class="container next">
    <div class="section-1-1">
        <h2> 6. OnBoard Training Records </h2>
        <table>
            <thead>
                <tr>
                    <th>SR NO</th>
                    <th>Designated Person</th>
                    <th>Date</th>
                    <th>Correct Answer</th>
                    <th>Wrong Answer</th>
                    <th>Total Questions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($exam) == 0)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @else
                @foreach($exam as $history)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$history->designated_name}}</td>
                    <td>{{ $history->created_at->format('d/m/Y') }}</td>

                    <td>{{$history->correct_ans}}</td>
                    <td>{{$history->wrong_ans}}</td>
                    <td>{{$history->total_ans}}</td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>

    </div>
</div>