@extends('layouts.app')


@section('shiptitle','User Management')

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
                        <h5 class="pageheader-title"> <a href="{{url('training')}}"><span class="icon"><i class="fas fa-arrow-left"></i></span> Back</a> <span class="ml-1">{{ $head_title ?? '' }} Training Management</span></h5>

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
                    <form method="post" class="needs-validation" novalidate id="trainingForm" action="{{ url('training/save') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ @$training->id ?? '' }}">
                        <input type="hidden" name="deleted_questions_id" value="" id="deleted_questions_id">

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Sets Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" value="{{ old('name', $training->name ?? '') }}" name="name"
                                        placeholder="Set Name..." autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="nameError"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">

                                    <button class="btn btn-primary float-right" type="button" id="addQuestion"><i class="fas fa-plus"></i> Add Question</button>
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
                                        <div class="col-md-10">
                                            <input type="text" class="form-control form-control-lg"
                                                name="questions[{{$quesvalue['id']}}][question_name]"
                                                autocomplete="off" placeholder="Enter Question" value="{{$quesvalue['question_name']}}">
                                            <div class="invalid-feedback error"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Answer Type Selection -->
                                <div class="form-group col-12">
                                    <div class="row align-items-center">
                                        <label class="col-md-2">Answer Type</label>
                                        <div class="col-md-10">
                                            <select class="form-control form-control-lg answer-type-select"
                                                name="questions[{{$quesvalue['id']}}][answer_type]"
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
                                                @if($quesvalue['answer_type'] == 'file')
                                                <div class="col-md-3">
                                                    <img src="{{asset('uploads/trainingRecored/'.$quesvalue['option_a'])}}" class="thumbnail">
                                                </div>

                                                @endif
                                                <div class="col-md-7">

                                                    <input type="{{$quesvalue['answer_type']}}" class="form-control form-control-lg"
                                                        name="questions[{{$quesvalue['id']}}][option_a]"
                                                        autocomplete="off" placeholder="Option A" value="{{$quesvalue['option_a']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row align-items-center">
                                                <label class="col-md-2">Option B</label>
                                                @if($quesvalue['answer_type'] == 'file')
                                                <div class="col-md-3">
                                                    <img src="{{asset('uploads/trainingRecored/'.$quesvalue['option_b'])}}" class="thumbnail">
                                                </div>

                                                @endif
                                                <div class="col-md-7">
                                                    <input type="{{$quesvalue['answer_type']}}" class="form-control form-control-lg"
                                                        name="questions[{{$quesvalue['id']}}][option_b]"
                                                        autocomplete="off" placeholder="Option B" value="{{$quesvalue['option_b']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row align-items-center">
                                                <label class="col-md-2">Option C</label>
                                                @if($quesvalue['answer_type'] == 'file')
                                                <div class="col-md-3">
                                                    <img src="{{asset('uploads/trainingRecored/'.$quesvalue['option_c'])}}" class="thumbnail">
                                                </div>

                                                @endif
                                                <div class="col-md-7">
                                                    <input type="{{$quesvalue['answer_type']}}" class="form-control form-control-lg"
                                                        name="questions[{{$quesvalue['id']}}][option_c]"
                                                        autocomplete="off" placeholder="Option C" value="{{$quesvalue['option_c']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row align-items-center">
                                                <label class="col-md-2">Option D</label>
                                                @if($quesvalue['answer_type'] == 'file')
                                                <div class="col-md-3">
                                                    <img src="{{asset('uploads/trainingRecored/'.$quesvalue['option_d'])}}" class="thumbnail">
                                                </div>

                                                @endif
                                                <div class="col-md-7">
                                                    <input type="{{$quesvalue['answer_type']}}" class="form-control form-control-lg"
                                                        name="questions[{{$quesvalue['id']}}][option_d]"
                                                        autocomplete="off" placeholder="Option D" value="{{$quesvalue['option_d']}}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-12" id="correctAnswerContainer{{$quesvalue['id']}}">
                                    <div class="row align-items-center">
                                        <label class="col-md-2">Correct Answer</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control form-control-lg"
                                                name="questions[{{$quesvalue['id']}}][correct_answer]"
                                                autocomplete="off" placeholder="Correct Answer" value="{{$quesvalue['correct_answer']}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <button class="btn btn-primary float-right mb-1" type="submit">Save</button>
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
                        @if(@$training->assignsethzmatCompany)
                        @foreach($training->assignsethzmatCompany as $value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$training['name']}}</td>
                        </tr>
                        @endforeach
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