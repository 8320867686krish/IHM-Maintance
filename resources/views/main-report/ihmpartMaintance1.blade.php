<div class="container">
    <div class="section-1-1">
        <div style="margin-top: 40%; text-align: center;">
            <h2>{{$sectionText}}</h2>
            <div style="padding-top:10px">
                <p>Ship Name: {{$projectDetail['ship_name']}}</p>
                <p>IMO No: {{$projectDetail['imo_number']}}</p>

                <p>Report Number: {{$projectDetail['report_number']}}</p>
                @if($till_today == 0)
                <p>Report Duration From: {{$from_date}} To {{$to_date}}</p>
                @else
                <p>Report Duration Till: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

                @endif

            </div>
        </div>
    </div>
</div>