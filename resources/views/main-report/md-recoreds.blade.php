<div class="container next">
    <div class="section-1-1">
        <h3> 6. Records of MD</h3>
        <table>
            <thead>
                <tr>
                    <th>SR NO</th>
                    <th>Issue Date</th>
                    <th>MD-ID-No</th>
                    <th>Supplier Information</th>
                    <th>Product Informatio</th>
                    <th>Contained Material Informatio</th>
                </tr>
            </thead>
            <tbody>
                @if(count($mdnoresults) == 0)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>

                </tr>
                @else
                @foreach($mdnoresults as $mdno)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$mdno->md_date}}</td>
                    <td>{{$mdno->md_no}}</td>
                    <td>{{$mdno->coumpany_name}}</td>
                    <td>&nbsp;</td>
                    <td>{{$mdno->hazmat_names}}</td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>

    </div>
</div>