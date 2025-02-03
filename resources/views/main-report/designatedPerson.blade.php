<div class="container next">
    <div class="section-1-1">
        <h3> 2.3. Designated person(s) responsible for the Inventory: </h3>
        <table>
            <thead>
                <tr>
                    <th>SR No</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Stat/Sign On Date</th>
                    <th>End/Sign Off Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mergedData as $value)
                <tr>
                    @if($value['position'] == 'SuperDp')
                    <?php $color = 'style=color:red; '?>
                    @else
                    <?php $color = ''?>
                  @endif
                    <td {{@$color}}>{{$loop->iteration}}</td>
                    <td  {{@$color}}>{{$value['name']}}</td>
                    <td  {{@$color}}>{{$value['position']}}</td>
                    <td  {{@$color}}>{{$value['sign_on_date']}}</td>
                    <td  {{@$color}}>{{$value['sign_off_date']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>