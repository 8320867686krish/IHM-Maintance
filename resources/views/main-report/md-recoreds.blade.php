
<div class="container next">
    <div class="section-1-1">
        <h2> 8. Records of MD</h2>
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
                    <td>{{ $mdno->makeModel->md_date ?? '' }}</td>
                    <td>
                        @if(@$mdno->makeModel->document1)
                        <a href="{{$mdno->makeModel->document1['path']}}" target="_blank">{{$mdno->makeModel->md_no}}</a>
                        @else
                        {{$mdno->makeModel->md_no ?? ''}}
                        @endif
                    </td>
                    <td>{{$mdno->makeModel->coumpany_name ?? ''}}</td>
                    <td>{{$mdno->makeModel->equipment}},{{$mdno->makeModel->model}},{{$mdno->makeModel->model}}</td>
                    @if($mdno->makeModel->hazmat->name == 'Not Contained')
                    <td>{{$mdno->makeModel->hazmat->name}}</td>
                    @else
                    <td>    {{$mdno->makeModel->hazmat->name}},{{$mdno->hazmat_type}}</td>
                    @endif
                    <td>{{$mdno->makeModel->md_qty}}</td>
                    <td>{{$mdno->makeModel->md_unit}}</td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>

    </div>
</div>