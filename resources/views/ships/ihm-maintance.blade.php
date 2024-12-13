<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="section-block">
        <h5 class="section-title">IHM Maintenance</h5>
    </div>



    <div class="accrodion-regular">
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="poRecordsHeading">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#po-records" aria-expanded="false" aria-controls="po-records">
                            PO Records
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="po-records" class="collapse show" aria-labelledby="headinginitial1" data-parent="#accordion">
                    <div class="card-body mb-4 mt-2">
                        @include('ships.po.poItems')
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="OnbaordTraining">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#onbaord-training" aria-expanded="false" aria-controls="onbaord-training">
                            Onbaord Training Records
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="onbaord-training" class="collapse" aria-labelledby="OnbaordTraining" data-parent="#accordion">
                    <div class="card-body mb-4">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th width="15%">SR NO</th>
                                    <th>Training Date</th>
                                    <th width="10%">Training Duration</th>
                                    <th width="20%">Number of People Attended</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>2024-01-05</td>
                                    <td>2 hours</td>
                                    <td>15</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2024-02-12</td>
                                    <td>3 hours</td>
                                    <td>10</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2024-03-18</td>
                                    <td>1.5 hours</td>
                                    <td>20</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>2024-04-10</td>
                                    <td>4 hours</td>
                                    <td>25</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>2024-05-22</td>
                                    <td>3.5 hours</td>
                                    <td>18</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>2024-06-15</td>
                                    <td>2.5 hours</td>
                                    <td>12</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>2024-07-07</td>
                                    <td>3 hours</td>
                                    <td>14</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>2024-08-30</td>
                                    <td>2 hours</td>
                                    <td>19</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>2024-09-11</td>
                                    <td>4 hours</td>
                                    <td>22</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>2024-10-01</td>
                                    <td>1 hour</td>
                                    <td>16</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingma3">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsema3" aria-expanded="false" aria-controls="collapsema3">
                            MD & SDoc
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsema3" class="collapse" aria-labelledby="headingma3" data-parent="#accordion">
                    <div class="card-body mb-4">
                        MD & SDoc data goes here.
                    </div>
                </div>
            </div>



            <div class="card">
                <div class="card-header" id="headingma4">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsema4" aria-expanded="false" aria-controls="collapsema4">
                            Major Repair / Retrofit / Dry Doc / Conversion
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsema4" class="collapse" aria-labelledby="headingma4" data-parent="#accordion">
                    <div class="card-body">
                        Major Repair / Retrofit / Dry Doc / Conversion data goes here.
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="headingma5">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsema5" aria-expanded="false" aria-controls="collapsema5">
                            Report Center
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsema5" class="collapse" aria-labelledby="headingma5" data-parent="#accordion">
                    <div class="card-body">
                        Report Center data goes here.
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@push('js')
<script>
    document.getElementById('excel_file').addEventListener('change', function() {
        document.getElementById('uploadForm').submit();
    });
</script>
@endpush