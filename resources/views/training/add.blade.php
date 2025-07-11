@extends('layouts.app')


@section('shiptitle','Training Management')

@section('content')
<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">

                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <h5 class="pageheader-title"> <a href="{{url('trainingsets')}}"><span class="icon"><i class="fas fa-arrow-left"></i></span> Back</a> <span class="ml-1">{{ $head_title ?? '' }} Training Management</span></h5>

                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">

            <div class="tab-regular">
                <ul class="nav nav-tabs " id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#questions" role="tab" aria-controls="home" aria-selected="false">Question</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="hazmat-company" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Hazmat Company</a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="questions" role="tabpanel" aria-labelledby="home-tab">
                        <form method="post" class="needs-validation" novalidate id="trainingForm" action="{{ route('trainingsets.save') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ @$training->id ?? '' }}">
                            <input type="hidden" name="deleted_questions_id" value="" id="deleted_questions_id">

                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="row align-items-center">
                                        <label for="name" class="col-md-2">Sets Name <span class="text-danger">*</span></label>

                                        <div class="col-md-5">
                                            <input type="text" class="col-md- form-control form-control-lg @error('name') is-invalid @enderror"
                                                id="name" value="{{ old('name', $training->name ?? '') }}" name="name"
                                                placeholder="Set Name..." autocomplete="off"
                                                onchange="removeInvalidClass(this)">
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="questionContainer">
                                @if(@$training->questions)
                                @foreach($training->questions as $quesvalue)
                                <div class="row new-question-row mb-3">
                                    <!-- Remove Button -->
                                    <div class="form-group col-12 text-right">
                                        <i class="fas fa-trash-alt text-danger mt-3 remove-item-btn" data-removequestion="{{$quesvalue['id']}}" style="font-size: 1.5rem; cursor: pointer;"></i>
                                    </div>

                                    <!-- Question Row -->
                                    <div class="form-group col-12">
                                        <div class="row align-items-center">
                                            <label class="col-md-2">Q - {{$loop->iteration}}</label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control form-control-lg"
                                                    name="questions[{{$quesvalue['id']}}][question_name]"
                                                    autocomplete="off" placeholder="Enter Question" value="{{$quesvalue['question_name']}}" id="questions_{{$quesvalue['id']}}_question_name">
                                                <div id="questions_{{$quesvalue['id']}}_question_nameError" class="invalid-feedback error"></div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Answer Type Selection -->
                                    <div class="form-group col-12">
                                        <div class="row align-items-center">
                                            <label class="col-md-2">Answer Type</label>
                                            <div class="col-md-5">
                                                <select class="form-control form-control-lg answer-type-select"
                                                    name="questions[{{$quesvalue['id']}}][answer_type]" id="questions[{{$quesvalue['id']}}][answer_type]"
                                                    data-item-id="{{$quesvalue['id']}}">
                                                    <option value="text" {{ $quesvalue['answer_type'] == 'text' ? 'selected' : '' }}>Text</option>
                                                    <option value="file" {{ $quesvalue['answer_type'] == 'file' ? 'selected' : '' }}>File</option>
                                                </select>
                                                <div class="invalid-feedback error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text Options -->

                                    <div class="options-container col-12 mb-3" id="options-{{$quesvalue['id']}}">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <div class="row align-items-center">
                                                    <label class="col-md-2">Option A</label>

                                                    <div class="col-md-5">

                                                        <input type="{{$quesvalue['answer_type']}}" class="form-control form-control-lg"
                                                            name="questions[{{$quesvalue['id']}}][option_a]" id="questions_{{$quesvalue['id']}}_option_a"
                                                            autocomplete="off" placeholder="Option A" value="{{$quesvalue['option_a']}}">
                                                        <div id="questions_{{$quesvalue['id']}}_option_aError" class="invalid-feedback error"></div>
                                                    </div>
                                                    @if($quesvalue['answer_type'] == 'file')
                                                    <div class="col-md-2">
                                                        <img src="{{asset('uploads/trainingRecored/'.$quesvalue['option_a'])}}" class="thumbnail" style="width:100px;">
                                                        <input type="hidden" name="questions[{{$quesvalue['id']}}][option_a_existing]" value="{{ $quesvalue['option_a'] }}">

                                                    </div>

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <div class="row align-items-center">
                                                    <label class="col-md-2">Option B</label>

                                                    <div class="col-md-5">
                                                        <input type="{{$quesvalue['answer_type']}}" class="form-control form-control-lg"
                                                            name="questions[{{$quesvalue['id']}}][option_b]" id="questions_{{$quesvalue['id']}}_option_b"
                                                            autocomplete="off" placeholder="Option B" value="{{$quesvalue['option_b']}}">
                                                        <div id="questions_{{$quesvalue['id']}}_option_bError" class="invalid-feedback error"></div>
                                                    </div>
                                                    @if($quesvalue['answer_type'] == 'file')
                                                    <div class="col-md-2">
                                                        <img src="{{asset('uploads/trainingRecored/'.$quesvalue['option_b'])}}" class="thumbnail" style="width:100px;">
                                                        <input type="hidden" name="questions[{{$quesvalue['id']}}][option_b_existing]" value="{{ $quesvalue['option_b'] }}">
                                                    </div>

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <div class="row align-items-center">
                                                    <label class="col-md-2">Option C</label>

                                                    <div class="col-md-5">
                                                        <input type="{{$quesvalue['answer_type']}}" class="form-control form-control-lg"
                                                            name="questions[{{$quesvalue['id']}}][option_c]" id="questions_{{$quesvalue['id']}}_option_c"
                                                            autocomplete="off" placeholder="Option C" value="{{$quesvalue['option_c']}}">
                                                        <div id="questions_{{$quesvalue['id']}}_option_cError" class="invalid-feedback error"></div>
                                                    </div>
                                                    @if($quesvalue['answer_type'] == 'file')
                                                    <div class="col-md-2">
                                                        <img src="{{asset('uploads/trainingRecored/'.$quesvalue['option_c'])}}" class="thumbnail" style="width:100px;">
                                                        <input type="hidden" name="questions[{{$quesvalue['id']}}][option_c_existing]" value="{{ $quesvalue['option_c'] }}">
                                                    </div>

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <div class="row align-items-center">
                                                    <label class="col-md-2">Option D</label>

                                                    <div class="col-md-5">
                                                        <input type="{{$quesvalue['answer_type']}}" class="form-control form-control-lg"
                                                            name="questions[{{$quesvalue['id']}}][option_d]" id="questions_{{$quesvalue['id']}}_option_d"
                                                            autocomplete="off" placeholder="Option D" value="{{$quesvalue['option_d']}}">
                                                        <div id="questions_{{$quesvalue['id']}}_option_dError" class="invalid-feedback error"></div>
                                                    </div>
                                                    @if($quesvalue['answer_type'] == 'file')
                                                    <div class="col-md-3">
                                                        <img src="{{asset('uploads/trainingRecored/'.$quesvalue['option_d'])}}" style="width:100px;" class="thumbnail">
                                                        <input type="hidden" name="questions[{{$quesvalue['id']}}][option_d_existing]" value="{{ $quesvalue['option_d'] }}">
                                                    </div>

                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group col-12" id="correctAnswerContainer{{$quesvalue['id']}}">
                                        <div class="row align-items-center">
                                            <label class="col-md-2">Correct Answer</label>
                                            <div class="col-md-5">
                                                @php
                                                $options = ['A', 'B', 'C', 'D'];
                                                @endphp

                                                <select name="questions[{{$quesvalue['id']}}][correct_answer]" class="form-control form-control-lg">
                                                    <option value="">Choose Answer</option>
                                                    @foreach ($options as $option)
                                                    <option value="{{ $option }}" {{ $quesvalue['correct_answer'] == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                              
                                                <div id="questions_{{$quesvalue['id']}}_correct_answerError" class="invalid-feedback error"></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="col-12 mb-4 row text-right">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="button" id="addQuestion"><i class="fas fa-plus"></i> Question</button>
                                </div>
                            </div>
                            <div class="col-12 mb-4">

                                <div class="form-group">

                                    <button class="btn btn-primary float-right mb-1" type="button" id="trainingFormBtn">Save</button>

                                </div>
                            </div>



                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th>SR NO</th>
                                    <th>Sets Name</th>
                                    <th>Company Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(@$training && count($training->assignsethzmatCompany)> 0)
                                @foreach($training->assignsethzmatCompany as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$training['name']}}</td>
                                    <td>{{$value->hazmatCompaniesName->name}}</td>
                                    <td><a href="#" title="Delete" class="deletAssignHazmat" data-id="{{$value->hazmatCompaniesName->id}}"> <i class="fas fa-trash-alt text-danger"></i>
                                        </a></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">No records found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
<script>
    var iteamQuestion = "{{ isset($training->questions) ? count($training->questions) : 0 }}";
</script>
<script src="{{ asset('assets/js/training.js') }}"></script>

@endpush