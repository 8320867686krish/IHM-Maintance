
<div class="container next">
    <div class="section-1-1">
        <h2> 7. Records of MD</h2>
        <table>
            <thead>
                <tr>
                    <th>SR NO</th>
                    <th>Issue Date</th>
                    <th>MD-ID-No</th>
                    <th>Supplier Information</th>
                    <th>Product Information</th>
                    <th>Contained Material Information</th>
                    <th>Quantity</th>
                    <th>Unit</th>
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
                    <td>{{$mdno->makeModel->md_date}}</td>
                    <td>{{$mdno->makeModel->md_no}}</td>
                    <td>{{$mdno->company_name}}</td>
                    <td>{{$mdno->makeModel->equipment}},{{$mdno->makeModel->model}},{{$mdno->makeModel->model}}</td>
                    <td>{{$mdno->makeModel->hazmat->name}}</td>
                    <td>{{$mdno->makeModel->md_qty}}</td>
                    <td>{{$mdno->makeModel->md_unit}}</td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>

    </div>
</div>