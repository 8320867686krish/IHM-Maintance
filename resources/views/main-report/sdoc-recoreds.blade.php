<div class="container next">
    <div class="section-1-1">
        <h2> 8. Records of SDOC</h2>
        <table>
            <thead>
                <tr>
                    <th>SR NO</th>
                    <th>Issue Date</th>
                    <th>SDoC No.</th>

                    <th>Issuer’s Name</th>

                    <th>Object(s) of Declaration</th>
                    <th>Supplier’s Declaration of Conformity</th>
                </tr>
            </thead>
            <tbody>
                @if(count($sdocresults) == 0)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>

                </tr>
                @else
                @foreach($sdocresults as $sdoc)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$sdoc->makeModel->sdoc_date}}</td>
                     <td>
                        @if( $sdoc->makeModel->document2)
                        <a href="{{$sdoc->makeModel->document2['path']}}" target="_blank">{{$sdoc->makeModel->sdoc_no}}</a>
                        @else
                        {{$sdoc->makeModel->sdoc_no}}
                        @endif
                    </td>
                    <td>{{$sdoc->makeModel->issuer_name}}</td>
                    <td>{{$sdoc->makeModel->sdoc_objects}}</td>
                    <td>{{$sdoc->makeModel->coumpany_name}}</td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>

    </div>
</div>