<div>
    <div style="text-align: center;">
        <h1 style="padding-top: 10px; font-weight: bold;">MD & SDOC Records</h1>
        <div>
            <img src="{{$shipImagePath}}" alt="Your Imagess">
        </div>
        <h4 style="padding-top: 1px;">Report No: {{$projectDetail['report_number']}}</h4>
        <h4 style="padding-top: 1px;">SHIP NAME- {{$projectDetail['ship_name']}}</h4>
        <h4 style="padding-top: 1px;">IMO No: {{$projectDetail['imo_number']}}</h4>
         @if($till_today == 0)
        <h4 style="padding-top: 1px;">Report Duration From: {{$from_date}} To {{$to_date}}</h4>
        @else
        <h4 style="padding-top: 1px;">Report Duration Till: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</h4>
        @endif
    </div> 

   
</div>