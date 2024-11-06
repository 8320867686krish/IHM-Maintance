@extends('layouts.app')
@section('shiptitle','Po Records')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
@endsection
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header"> <a href=""><span class="icon"><i class="fas fa-arrow-left"></i></span> Back</a> <span class="ml-1">{{ $head_title ?? '' }} PO</span></h5>
                <form method="post" action="{{route('po.store')}}" class="needs-validation" novalidate
                    id="POForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="deleted_id" id="deleted_id" value="">

                        <input type="hidden" name="ship_id" id="ship_id" value="{{$poItem->ship_id}}">
                        <input type="hidden" name="po_id" id="po_id" value="{{@$poItem->id}}">
                        <div class="row">
                        <div class="col-6 col-md-6">
                               <div class="form-group mb-4">
                                   <label for="equipment">Part No"</label>
                                   <input type="text" id="part_no" name="part_no" class="form-control" value="{{$poItem->part_no}}">
                               </div>
                           </div>
                           <div class="col-6 col-md-6">
                               <div class="form-group mb-4">
                                   <label for="Qty">Qty</label>
                                   <input type="text" id="qty" name="qty"
                                       class="form-control" value="{{$poItem->qty}}">
                               </div>
                           </div>
                          
                           <div class="col-12 col-md-6">
                               <div class="form-group mb-4">
                                   <label for="unit">Unit</label>
                                   <input type="text" id="unit" name="unit" class="form-control" value="{{$poItem->unit}}">
                               </div>
                           </div>

                           <div class="col-12 col-md-6">
                               <div class="form-group mb-4">
                                   <label for="type_category">Type</label>
                                   <select class="form-control form-control-lg" name="type_category">
                                        <option value="Relevant">Relevant</option>
                                        <option value="Non relevant">Non relevant</option>
                                    </select>
                               </div>
                           </div>
                        </div>

                    </div>
                    <hr />
                  
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary float-right mb-3"
                                type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
@push('js')
<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

<script src="{{ asset('assets/js/poOrder.js') }}"></script>

@endpush