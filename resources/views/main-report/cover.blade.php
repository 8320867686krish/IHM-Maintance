<div>
    <div style="text-align: center;margin-bottom:50px;">
        <h1 style="padding-top: 5px;">
            IHM Maintenance report of : {{$projectDetail['ship_name']}}
        </h1>
        <h4 style="padding-top: 1px;">IMO No: {{$projectDetail['imo_number']}}</h4>
        <h4 style="padding-top: 1px;">Report Number: {{$projectDetail['report_number']}}</h4>

        <p>Report Number: {{$projectDetail['report_number']}}</p>
        @if($till_today == 0)
        <h4 style="padding-top: 1px;">Report Duration From: {{$from_date}} To {{$to_date}}</h4>
        @else
        <h4 style="padding-top: 1px;">Report Duration Till: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</h4>
        @endif

    </div>
    <div style="margin-auto:0;text-align:center">
        <img src="{{  @$shipImagePath }}" alt="Your Image">
    </div>
    <div style="pading-top:310px;margin-top: 30px;">
        <h4>Reports Prepared with refrence from:</h4>
       {!! $configration['refrence_form'] !!}

    </div>
</div>