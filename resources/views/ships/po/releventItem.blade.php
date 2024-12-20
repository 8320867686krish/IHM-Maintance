@extends('layouts.app')
@section('shiptitle','Po Records')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
@endsection
@section('content')
@include('ships.po.modals.sendMail')

<div class="container-fluid dashboard-content">
	<div class="row">

		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header"> <a href="{{url($backurl)}}"><span class="icon"><i class="fas fa-arrow-left"></i></span> Back</a> <span class="ml-1">{{ $head_title ?? '' }} PO</span></h5>
				<form method="post" action="{{route('poItems.hazmat')}}" class="needs-validation" novalidate
					id="checkHazmatAddForm" enctype="multipart/form-data">
					@csrf
					<div class="card-body">
						<input type="hidden" name="deleted_id" id="deleted_id" value="">

						<input type="hidden" name="ship_id" id="ship_id" value="{{$poItem->ship_id}}">
						<input type="hidden" name="po_order_item_id" id="po_order_item_id" value="{{@$poItem->id}}">
						<input type="hidden" name="po_order_id" id="po_order_id" value="{{@$poItem->po_order_id}}">
						<input type="hidden" name="po_no" id="po_no" value="{{@$poItem->poOrder->po_no}}">

						<div class="row">
							<div class="col-6 col-md-6 mb-2">
								<div class="form-group">
									<label for="equipment">Description</label>
									<input type="text" id="description" name="description" class="form-control" value="{{$poItem->description}}">
								</div>
							</div>

							<div class="col-6 col-md-6 mb-2">
								<div class="form-group">
									<label for="equipment">IMPA No.(if available)</label>
									<input type="text" id="impa_no" name="impa_no" class="form-control" value="{{$poItem->impa_no}}">
								</div>
							</div>

							<div class="col-6 col-md-6 mb-2">
								<div class="form-group">
									<label for="equipment">Part No</label>
									<input type="text" id="part_no" name="part_no" class="form-control" value="{{$poItem->part_no}}">
								</div>
							</div>
							<div class="col-6 col-md-6 mb-2">
								<div class="form-group">
									<label for="Qty">Qty</label>
									<input type="text" id="qty" name="qty"
										class="form-control" value="{{$poItem->qty}}">
								</div>
							</div>

							<div class="col-12 col-md-6 mb-2">
								<div class="form-group">
									<label for="unit">Unit</label>
									<input type="text" id="unit" name="unit" class="form-control" value="{{$poItem->unit}}">
								</div>
							</div>

							<div class="col-12 col-md-6 mb-2">
								<div class="form-group">
									<label for="type_category">Type</label>
									<select class="form-control form-control-lg" name="type_category">
										<option value="Relevant">Relevant</option>
										<option value="Non relevant">Non relevant</option>
									</select>
								</div>
							</div>

							<div class="col-12 col-md-6 mb-2">
								<div class="form-group">
									<label for="suspected_hazmat">Suspected Hazmat</label>
									<select class="form-control selectpicker" id="suspected_hazmat"
										name="suspected_hazmat[]" multiple>
										<option value="">Select Hazmat</option>
										@if (isset($hazmats))
										@foreach ($hazmats as $key => $value)
										<optgroup label="{{ strtoupper($key) }}">
											@foreach ($value as $hazmat)
											<option value="{{ $hazmat->id }}" data-table='{{$hazmat->table_type}}'>
												{{ $hazmat->name }}
											</option>
											@endforeach
										</optgroup>
										@endforeach
										@endif
									</select>
								</div>
							</div>
						</div>
						<div class="accrodion-regular">
							<div id="accordion">
								<div class="col-12 col-md-12"
									style="background: #efeff6;border: 1px solid #efeff6;">
									<div class="pt-4">
										<h5 class="text-center mb-4" style="color:#757691">Document Analysis Results
										</h5>

										<div class="mb-4 col-12" id="showTableTypeDiv">
											@if(@$poItem->poOrderItemsHazmets)
											@foreach($poItem->poOrderItemsHazmets as $value)
											@php
											$hazmetTable = explode('-', $value['hazmat']['table_type'])[0]
											@endphp
											<input type="hidden" name="hazmats[{{$value['hazmat_id']}}][id]" id="id{{$value['hazmat_id']}}" value="{{@$value->id}}">
											<div class="card" id="main{{$value['hazmat_id']}}">
												<div class="card-header" id="heading{{$value['hazmat_id']}}">
													<h5 class="mb-0">
														<button class="btn btn-link collapsed  d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapse{{$value['hazmat_id']}}" aria-expanded="false" type="button" aria-controls="collapse{{$value['hazmat_id']}}">
															{{$value['hazmat']['name']}}
															<span class="fas fa-angle-down mr-3"></span>

														</button>
													</h5>
												</div>
												<div id="collapse{{$value['hazmat_id']}}" class="collapse" aria-labelledby="heading{{$value['hazmat_id']}}" data-parent="#accordion" style="">
													<div class="card-body">
														<div class="col-12 col-md-12 col-lg-12 cloneTableTypeDiv mb-2 " id="cloneTableTypeDiv{{$value['hazmat_id']}}">
															<div class="row">
																<div class="col-4 table_typecol mb-2">
																	<div class="form-group">
																		<select class="form-control table_type tableType{{$value['hazmat_id']}}" id="table_type_{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][hazmat_type]" data-findTable="{{ explode('-', $value['hazmat']['table_type'])[0] }}" data-divValue="{{$value['hazmat_id']}}">
																			<option value="Contained" {{ $value->hazmat_type == 'Contained' ? 'selected' : '' }}>Contained
																			</option>
																			<option value="Not Contained" {{ $value->hazmat_type == 'Not Contained' ? 'selected' : '' }}>
																				Not Contained</option>
																			<option value="PCHM" {{ $value->hazmat_type == 'PCHM' ? 'selected' : '' }}>
																				PCHM</option>
																			<option value="Unknown" {{ $value->hazmat_type == 'Unknown' ? 'selected' : '' }}>
																				Unknown</option>
																		</select>
																	</div>
																</div>


																<div class="col-4 equipment mb-2" id="equipment{{$value['hazmat_id']}}">
																	<div class="form-group">
																		<select class="form-control  equipmentSelectTag" id="equipmentselect_{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][hazmet_equipment]" data-id="{{$value['hazmat_id']}}" data-findtable="{{$hazmetTable}}" data-divvalue="{{$value['hazmat_id']}}">
																			<option value="">Select Equipment
																			</option>
																			@foreach($value->hazmat->equipment as $equipment)
																			<option value="{{$equipment['equipment']}}" @if($equipment['equipment']==$value['hazmet_equipment']) selected @endif>
																				{{$equipment['equipment']}}
																			</option>
																			@endforeach

																		</select>
																	</div>

																</div>

																<div class="col-4 manufacturer mb-2" id="manufacturer{{$value['hazmat_id']}}">
																	<div class="form-group">
																		<select class="form-control  manufacturerselect" id="manufacturerselect_{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][hazmet_manufacturer]" data-id="{{$value['hazmat_id']}}" data-findtable="{{$hazmetTable}}" data-divvalue="{{$value['hazmat_id']}}">
																			<option value="">Select Manufacturer
																			</option>
																			@foreach($value->hazmat->equipment as $equipment)
																			<option value="{{$equipment['manufacturer']}}" @if($equipment['manufacturer']==$value['hazmet_manufacturer']) selected @endif>{{$equipment['manufacturer']}}</option>
																			@endforeach
																		</select>
																	</div>

																</div>

																<div class="col-4 modelMakePart mb-1" id="modelMakePart{{$value['hazmat_id']}}">
																	<div class="form-group">
																		<select class="form-control  modelMakePartSelect" data-id="{{$value['hazmat_id']}}" id="modelMakePartselect_{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][modelMakePart]" data-findtable="{{$hazmetTable}}" data-divvalue="{{$value['hazmat_id']}}">
																			<option value="">Select Model Make and Part
																			</option>
																			@foreach($value->hazmat->equipment as $equipment)
																			<option value="{{$equipment->id}}" @if($equipment['id']==$value['modelMakePart']) selected @endif>{{$equipment->model}}-{{$equipment->make}}-{{$equipment->part}}</option>
																			@endforeach
																		</select>
																	</div>

																</div>

																<div class=" col-4  documentLoad1 mb-1" id="documentLoad1_{{$value['hazmat_id']}}">
																	<div class="form-group">
																		@if(@$value['doc1'])
																		<a>{{ $value['doc1'] }}</a>

																		@endif
																	</div>
																</div>

																<div class=" col-4  documentLoad2 mb-1" id="documentLoad2_{{$value['hazmat_id']}}">
																	<div class="form-group">
																		@if(@$value['doc2'])
																		<input type="hidden" name="hazmats[${hazmetId}][doc2]" value="{{$value['sdoc_no']}}"><a>{{ $value['doc2'] }}</a>

																		@endif
																	</div>
																</div>
															</div>
															@if($value->hazmat_type === 'Contained' || $value->hazmat_type === 'PCHM')
															@if($hazmetTable == 'A')
															<div class="row   notification{{$value['hazmat_id']}}">
																<div class="col-11">
																	<div class="form-group">
																		<div class="alert alert-danger" role="alert">Its not allowed on Board.!</div>

																	</div>
																</div>
																<div class="col-1">
																	<div class="form-group"><button class="btn btn-primary float-right mb-1 sendmail" type="button" data-id="{{$value['hazmat_id']}}">Send Email</button></div>
																</div>
															</div>
															@endif
															<div class="col-12 col-md-12 col-lg-12  mb-2  onboard{{$value['hazmat_id']}}">
																<h5>Item arrived on board?</h5>
																<label class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="isArrived{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isArrived]" value='yes' class="custom-control-input isArrivedChoice" data-tab="{{$hazmetTable}}" data-isArrived="{{$value['hazmat_id']}}" {{ $value->isArrived == 'yes' ? 'checked' : '' }}><span class="custom-control-label">Yes</span>
																</label>
																<label class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="isArrived{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isArrived]" value="no" class="custom-control-input isArrivedChoice" data-tab="{{ $hazmetTable }}" data-isArrived="{{$value['hazmat_id']}}" {{ $value->isArrived == 'no' ? 'checked' : '' }}><span class="custom-control-label">No</span>
																</label>

															</div>
															@if( $value->isArrived == 'yes')
															<div class="row col-12 col-md-12 col-lg-12 mb-2 arrivedItemDetails{{$value['hazmat_id']}}">
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][arrived_location]" id="arrived_location{{$value['hazmat_id']}}" class="form-control" placeHolder="Location" value="{{$value['arrived_location']}}">
																	</div>
																</div>
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="date" name="hazmats[{{$value['hazmat_id']}}][arrived_date]" id="arrived_date{{$value['hazmat_id']}}" class="form-control" placeHolder="Date" value="{{$value['arrived_date']}}">
																	</div>
																</div>

															</div>
															@endif
															@if( $hazmetTable == 'A')
															<div class="col-12 col-md-12 col-lg-12  mb-2  returnItem{{$value['hazmat_id']}}">
																<h5>return of item initiated ?</h5>
																<label class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="isReturn_yes{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isReturn]" value="yes" class="custom-control-input isReturnChoice" data-isReturn="{{$value['hazmat_id']}}" {{ $value->isReturn === 'yes' ? 'checked' : ''}}><span class="custom-control-label">Yes</span>
																</label>
																<label class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="isReturn_no{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isReturn]" value="no" class="custom-control-input isReturnChoice" data-isReturn="{{$value['hazmat_id']}}" {{ $value->isReturn === 'no' ? 'checked' : ''}}><span class="custom-control-label">No</span>
																</label>

															</div>
															@endif
															@if( $value->isReturn == 'yes')
															<div class="row col-12 mb-2 returnItemDetails{{$value['hazmat_id']}}">
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][location]" id="location{{$value['hazmat_id']}}" class="form-control" placeholder="Location" value="{{$value['location']}}">
																	</div>
																</div>
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="date" name="hazmats[{{$value['hazmat_id']}}][date]" id="date{{$value['hazmat_id']}}" class="form-control" placeholder="Date" value="{{$value['date']}}">
																	</div>
																</div>
															</div>
															@else
															@if($value['isArrived'] == 'yes' && $hazmetTable == 'A')
															<div class="col-12 col-md-12 col-lg-12  mb-2  itemInstall{{$value['hazmat_id']}}">

																<h5>Is Installed?</h5>
																<label class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="isInstalled_yes{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isInstalled]" value="yes" class="custom-control-input isInstalledChoice" data-isInstalled="{{$value['hazmat_id']}}" {{ $value->isInstalled === 'yes' ? 'checked' : ''}}>
																	<span class="custom-control-label">Yes</span>
																</label>
																<label class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="isInstalled_no{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isInstalled]" value="no" class="custom-control-input isInstalledChoice" data-isInstalled="{{$value['hazmat_id']}}" {{ $value->isInstalled === 'no' ? 'checked' : ''}}>
																	<span class="custom-control-label">No</span>
																</label>
															</div>

															@endif
															@endif

															@if($value->isArrived == 'yes')
															@php
															$isShow = false;
															if ($hazmetTable == 'A' && $value->isInstalled == 'yes') {
															$isShow = true;
															}else if($hazmetTable == 'B' && $value->isArrived == 'yes'){
															$isShow = true;
															}
															@endphp @if($isShow)
															<div class="col-12 col-md-12 col-lg-12  mb-2  ihmUpdated{{$value['hazmat_id']}}">
																<h5>IHM & IHM Maintenance update ?</h5>
																<label class="custom-control custom-checkbox">
																	<input type="checkbox" id="isIHMUpdated_yes{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isIHMUpdated]" value="yes" class="custom-control-input isIHMUpdatedChoice" data-isIHMUpdated="{{$value['hazmat_id']}}" {{ $value->isIHMUpdated === 'yes' ? 'checked' : ''}}><span class="custom-control-label">&nbsp;</span>
																</label>


															</div>
															@endif
															@else
															<div class=" col-12 col-md-12 col-lg-12 mb-2 noitemInstalled{{$value['hazmat_id']}}">
																<p>Waiting for return to initiate
																</p>


															</div>
															@endif
															@if($value->isIHMUpdated == 'yes' && $value->isArrived == 'yes')
															<div class="row col-12 mb-2 ihmItemDetails{{$value['hazmat_id']}}">
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_location]" id="location{{$value['hazmat_id']}}" class="form-control" placeholder="Location" value="{{$value->ihm_location}}">
																	</div>
																</div>
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_sublocation]" id="ihm_sublocation{{$value['hazmat_id']}}" class="form-control" placeholder="Sub Location" value="{{$value->ihm_sublocation}}">
																	</div>
																</div>
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_machinery_equipment]" id="ihm_machinery_equipment{{$value['hazmat_id']}}" class="form-control" placeholder="Machinery/Equipment" value="{{$value->ihm_machinery_equipment}}">
																	</div>
																</div>
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_parts]" id="ihm_parts{{$value['hazmat_id']}}" class="form-control" placeholder="Parts where used" value="{{$value->ihm_parts}}">
																	</div>
																</div>
																@if($hazmetTable == 'A')
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_qty]" id="ihm_qty{{$value['hazmat_id']}}" class="form-control" placeholder="Quantity" value="{{$value->ihm_qty}}">
																	</div>
																</div>
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_unit]" id="ihm_unit{{$value['hazmat_id']}}" class="form-control" placeholder="Unit" value="{{$value->ihm_machinery_equipment}}" value="{{$value->ihm_unit}}">
																	</div>
																</div>
																@else
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_previous_qty]" id="ihm_previous_qty{{$value['hazmat_id']}}" class="form-control" placeHolder="Previous Quantity" value="{{$value['ihm_previous_qty']}}">
																	</div>
																</div>

																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_previous_unit]" id="ihm_previous_unit{{$value['hazmat_id']}}" class="form-control" placeHolder="Unit" value="{{$value['ihm_previous_unit']}}">
																	</div>
																</div>
																<div class="col-3 mb-2">
																	<div class="form-group">
																		<input type="date" name="hazmats[{{$value['hazmat_id']}}][ihm_last_date]" id="ihm_last_date{{$value['hazmat_id']}}" class="form-control" placeHolder="Last Date" value="{{$value['ihm_last_date']}}">
																	</div>
																</div>
																<div class="col-3 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_qty]" id="ihm_qty{{$value['hazmat_id']}}" class="form-control" placeHolder="Next Quantity" value="{{$value['ihm_qty']}}">
																	</div>
																</div>

																<div class="col-3 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_unit]" id="ihm_unit{{$value['hazmat_id']}}" class="form-control" placeHolder="Unit" value="{{$value['ihm_unit']}}">
																	</div>
																</div>
																<div class="col-3 mb-2">
																	<div class="form-group">
																		<input type="date" name="hazmats[{{$value['hazmat_id']}}][ihm_date]" id="ihm_date{{$value['hazmat_id']}}" class="form-control" placeHolder="Next Date" value="{{$value['ihm_date']}}">
																	</div>
																</div>
																@endif
																<div class="col-12 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][ihm_remarks]" id="remarks{{$value['hazmat_id']}}" class="form-control" placeholder="Remarks" value="{{$value->ihm_remarks}}">
																	</div>
																</div>
															</div>

															@endif
															@if($value->isArrived == 'yes')
															@php $style="display:block" @endphp
															@else
															@php $style="display:none" @endphp

															@endif
															<div class="col-12 col-md-12 col-lg-12  mb-2  removeItem{{$value['hazmat_id']}}" style="{{$style}}">
																<h5>remove the item?</h5>
																<label class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="isRemove{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isRemove]" value="yes" class="custom-control-input isRemoveChoice" data-isRemove="{{$value['hazmat_id']}}" {{ $value->isRemove === 'yes' ? 'checked' : '' }}><span class="custom-control-label">Yes</span>
																</label>
																<label class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="isRemove{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isRemove]" value="no" class="custom-control-input isRemoveChoice" data-isRemove="{{$value['hazmat_id']}}" {{ $value->isRemove === 'no' ? 'checked' : '' }}><span class="custom-control-label">No</span>
																</label>

															</div>
															@if( $value->isRemove === 'yes')
															<div class="row  col-12 mb-2  removeItemDetails{{$value['hazmat_id']}}" style="{{$style}}">
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][service_supplier_name]" id="service_supplier_name{{$value['hazmat_id']}}" class="form-control" placeHolder="Service Supplier Name" value="{{$value['service_supplier_name']}}">
																	</div>
																</div>
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][service_supplier_address]" id="service_supplier_address{{$value['hazmat_id']}}" class="form-control" placeHolder="Service Supplier Address" value="{{$value['service_supplier_address']}}">
																	</div>
																</div>
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="date" name="hazmats[{{$value['hazmat_id']}}][removal_date]" id="removal_date{{$value['hazmat_id']}}" class="form-control" placeHolder="Removal Date" value="{{$value['removal_date']}}">
																	</div>
																</div>

																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][removal_location]" id="removal_location{{$value['hazmat_id']}}" class="form-control" placeHolder="Removal Location" value="{{$value['removal_location']}}">
																	</div>
																</div>

																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="file" name="hazmats[{{$value['hazmat_id']}}][attachment]" id="attachment{{$value['hazmat_id']}}" class="form-control" placeHolder="Attachment">
																	</div>
																</div>
																<div class="col-4 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][po_no]" id="po_no{{$value['hazmat_id']}}" class="form-control" placeHolder="PO No" value="{{$value['po_no']}}">
																	</div>
																</div>

																<div class="col-3 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][removal_quantity]" id="removal_quantity{{$value['hazmat_id']}}" class="form-control" placeHolder="Quantty" value="{{$value['removal_quantity']}}">
																	</div>
																</div>

																<div class="col-3 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][removal_unit]" id="removal_unit{{$value['hazmat_id']}}" class="form-control" placeHolder="Unit" value="{{$value['removal_unit']}}">
																	</div>
																</div>

																<div class="col-6 mb-2">
																	<div class="form-group">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][removal_remarks]" id="removal_remarks{{$value['hazmat_id']}}" class="form-control" placeHolder="Remarks" value="{{$value['removal_remarks']}}">
																	</div>
																</div>

															</div>
															@endif

															@endif
															@if($value->hazmat_type === 'Unknown')
															<div class="row  mb-2  recivedDoc{{$value['hazmat_id']}}">
																<div class="col-12 col-md-12 col-lg-12 ">
																	<h5>Recived Document?</h5>
																	<label class="custom-control custom-radio custom-control-inline">
																		<input type="radio" id="isRecivedDoc{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isRecivedDoc]" value='yes' class="custom-control-input isRecivedDocChoice" data-tab="{{$hazmetTable}}" data-isRecivedDoc="{{$value['hazmat_id']}}" {{ $value->isRecivedDoc == 'yes' ? 'checked' : '' }}><span class="custom-control-label">Yes</span>
																	</label>
																	<label class="custom-control custom-radio custom-control-inline">
																		<input type="radio" id="isRecivedDoc{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isRecivedDoc]" value="no" class="custom-control-input isRecivedDocChoice" data-tab="{{ $hazmetTable }}" data-isRecivedDoc="{{$value['hazmat_id']}}" {{ $value->isRecivedDoc == 'no' ? 'checked' : '' }}><span class="custom-control-label">No</span>
																	</label>
																</div>
															</div>
															<div class="row   mb-1   recivedDocumentDetail{{$value['hazmat_id']}}">
																<div class="col-8">
																	<div class="form-group mb-1">
																		<input type="text" name="hazmats[{{$value['hazmat_id']}}][recived_document_comment]" id="recived_document_comment{{$value['hazmat_id']}}" class="form-control" placeHolder="Remarks" value="{{$value['recived_document_comment']}}">
																	</div>
																</div>
																@if($value['isRecivedDoc'] == 'yes')
																<div class="col-4">
																	<div class="form-group mb-1">
																		<input type="date" name="hazmats[{{$value['hazmat_id']}}][recived_document_date]" id="recived_document_comment{{$value['hazmat_id']}}" class="form-control" placeHolder="Remarks" value="{{$value['recived_document_date']}}">
																	</div>
																</div>
																@endif
															</div>
															<div class="table-responsive mt-2 mb-4">
																<h6>Emil History</h6>
																<table class="table table-bordered">

																	<thead>
																		<tr>
																			<th>Start Date</th>
																			<th>Reminder Sent</th>
																			<th>Company Email</th>
																			<th>Supplier Email</th>
																			<th>Accounting Email</th>

																		</tr>

																	</thead>
																	<tbody>
																		@if(count($value->emailHistory) > 0)
																		@foreach($value->emailHistory as $history)
																		<tr>

																			<td>{{ \Carbon\Carbon::parse($history['start_date'])->format('d/m/y') }}</td>
																			<td>{{$history['is_sent_email'] == 0 ? 'Pending' : 'Sent'}}</td>
																			<td>{{$history['company_email']}}</td>
																			<td>{{$history['suppliear_email']}}</td>

																			<td>{{$history['accounting_email']}}</td>

																		</tr>
																		@endforeach
																		@else
																		<tr>
																			<td colspan="5" class="text-center">No Recored</td>
																		</tr>

																		@endif
																	</tbody>
																</table>
															</div>

															@endif

														</div>
													</div>
												</div>
											</div>


											@endforeach
											@endif


										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

					<hr />

					<div class="col-12">
						<div class="form-group">
							<button class="btn btn-primary float-right mb-1"
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
<script>
	var hazmatIdsvalue = @json($hazmatIds);
	var itemIndex = "{{ isset($poData->poOrderItems) ? count($poData->poOrderItems) : 0 }}";
	console.log(itemIndex);
	$(document).ready(function() {
		$('#checkHazmatAddForm #suspected_hazmat').selectpicker('val', hazmatIdsvalue);

	});
</script>
@endpush