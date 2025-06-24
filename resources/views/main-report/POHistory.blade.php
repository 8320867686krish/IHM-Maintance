<div class="container next">
    <div class="section-1-1">
        <h2>9. PO Order History</h2>
        <div style="padding-top:20px;padding-bottom:20px;">
            <table>
                <thead>
                    <tr>

                        <th>Relevant Count</th>
                        <th>Non Relevant Count</th>

                    </tr>
                </thead>
                <tbody>

                    <tr>

                        <td>{{@$counts['Relevant'] ?? 0}}</td>
                        <td>{{@$counts['Non relevant'] ?? 0}}</td>

                    </tr>

                </tbody>
            </table>
        </div>


    </div>
</div>