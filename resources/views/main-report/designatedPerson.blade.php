<div class="container next">
    <div class="section-1-1">
        <h2> 5. Responsible Parties For IHM Maintance: </h2>
        <h4>Designated Person On Shore</h4>
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
                @if(@$superDpResult)
                @foreach($superDpResult as $value)
                <tr>
                  
                    <td>{{$loop->iteration}}</td>
                    <td>{{$value['name']}}</td>
                    <td>{{$value['position']}}</td>
                    <td>{{$value['sign_on_date']}}</td>
                    <td>{{$value['sign_off_date']}}</td>
                </tr>
                @endforeach
                @else
                  <tr>
                  
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endif
            </tbody>
        </table>

         <h4>Responsible Person On Shore</h4>
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
                @if(@$responsibleResult)
                @foreach($responsibleResult as $value)
                <tr>
                   
                    <td>{{$loop->iteration}}</td>
                    <td >{{$value['name']}}</td>
                    <td>
                        @if($value['position'] == 'incharge')
                        Overall-incharge (Captain)
                        @else
                        Responsible Person
                        @endif
                       
                    </td>
                    <td>{{$value['sign_on_date']}}</td>
                    <td>{{$value['sign_off_date']}}</td>
                </tr>
                @endforeach
                @else
                <tr>
                  
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endif
            </tbody>
        </table>
        
    </div>
</div>