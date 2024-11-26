<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="accrodion-regular">
        <div id="accordion3">
            <div class="card">
                <div class="card-header" id="headingSeven">
                    <h5 class="mb-0">
                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseSeven"
                            aria-expanded="true" aria-controls="collapseSeven">
                            <span class="fas fa-angle-down mr-3"></span>Assign Team
                        </button>
                    </h5>
                </div>
                <div id="collapseSeven" class="collapse show" aria-labelledby="headingSeven" data-parent="#accordion3">
                    <div class="card-body">
                        <form method="post" novalidate id="assignProjectForm">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="ship_id" value="{{ $ship->id ?? '' }}"
                                    id="ship_id">
                                    <input type="hidden" name="hazmat_companies_id" value="{{ $ship->hazmat_companies_id  ?? '' }}"
                                    id="hazmat_companies_id">
                                <div class="form-group col-12 mb-3">
                                    <label for="project_no">Managers <span class="text-danger">*</span></label>
                                    <select class="selectpicker show-tick form-control form-control-lg" name="maneger_id[]"
                                        id="manager_id" multiple data-live-search="true" data-actions-box="true"
                                        onchange="removeInvalidClass(this)">
                                        @if ($managers->count() > 0)
                                            @foreach ($managers as $manager)
                                            @if (in_array($manager->id, $users))
                                            <option value="{{ $manager->id }}" selected>
                                                        {{ $manager->name }}
                                                    </option>
                                                    @else
                                                    <option value="{{ $manager->id }}">
                                                        {{ $manager->name }}
                                                    </option>
                                                @endif
                                              
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback error" id="user_idError"></div>
                                </div>
                                <div class="form-group col-12 mb-3">
                                    <label for="project_no">Experts <span class="text-danger">*</span></label>
                                    <select class="selectpicker show-tick form-control form-control-lg" name="expert_id[]"
                                        id="expert_id" multiple data-live-search="true" data-actions-box="true"
                                        {{ $readonly }} onchange="removeInvalidClass(this)">
                                        @if ($experts->count() > 0)
                                            @foreach ($experts as $expert)
                                            @if (in_array($expert->id, $users))
                                            <option value="{{ $expert->id }}" selected>
                                                        {{ $expert->name }}
                                                    </option>
                                                    @else
                                                    <option value="{{ $expert->id }}">
                                                        {{ $expert->name }}
                                                    </option>
                                              @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback error" id="user_idError"></div>
                                </div>
                               
                                @can('ships.edit')
                                    <div class="col-12 mb-4">
                                        <div class="form-group">
                                            <button class="btn btn-primary float-right" type="submit">Save</button>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>

         
        </div>
    </div>
</div>

@push('js')
    <script>
       
        function handleFormSubmission(e, url) {
            e.preventDefault();

            let form = $(this); // Get the form element
            let submitButton = form.find(':submit');
            let originalText = submitButton.html();

            // Disable the submit button and change its text
            submitButton.text('Wait...');
            submitButton.prop('disabled', true);

            let formData = new FormData(form[0]); // Create FormData object from the form

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: function(msg) {
                    // $(".sucessSurveylMsg").show();
                    if (msg.isStatus) {
                        successMsg("Save Successfully!!");
                    } else {
                        errorMsg("An unexpected error occurred. Please try again later.");
                    }
                },
                error: function(err) {
                    if (err.responseJSON && err.responseJSON.errors) {
                        let errors = err.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $('#' + field + 'Error').text(messages[0]).show();
                            $('[name="' + field + '"]').addClass('is-invalid');
                        });
                    } else {
                        errorMsg("An unexpected error occurred. Please try again later.");
                    }
                },
                complete: function() {
                    // Re-enable the submit button and restore its original text
                    submitButton.text(originalText);
                    submitButton.prop('disabled', false);
                }
            });
        }

       
        $('#assignProjectForm').submit(function(e) {
            handleFormSubmission.call(this, e, "{{ route('ships.assign') }}");
        });

      

        $('#onBoardSurveyForm').submit(function(e) {
            handleFormSubmission.call(this, e, "{{ url('detail/assignProject') }}");
        });

       

     
    </script>
@endpush
