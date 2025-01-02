@extends('layouts.app')


@section('shiptitle','Training Management')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    body {
    background-color: #f0f2f5;
}

.quiz-container {
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
    max-width: 600px;
    width: 100%;
    margin: auto;
}

.quiz-header {
    text-align: center;
    margin-bottom: 30px;
}

.question {
    font-size: 1.2rem;
    margin-bottom: 20px;
}

.options {
    display: grid;
    gap: 10px;
}

.option {
    background-color: #f8f9fa;
    border: 2px solid #dee2e6;
    border-radius: 10px;
    padding: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.option:hover {
    background-color: #e9ecef;
}

.option.selected {
    background-color: #cfe2ff;
    border-color: #0d6efd;
}

.option.correct {
    background-color: #d4edda;
    border-color: #28a745;
}



.quiz-footer {
    padding-top: 30px;
    padding-bottom: 30px;
}



.progress {
    height: 10px;
    margin-bottom: 20px;
}

.results {
    text-align: center;
}

.result-icon {
    font-size: 4rem;
    margin-bottom: 20px;
}

.score {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 20px;
}
</style>
@section('content')
<div class="container mt-5">
    <div class="quiz-container mt-5" id="quiz">
        <div class="quiz-header">
            <h2>Exam</h2>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
        <div id="question-container">
            <p class="question" id="question"></p>
            <div class="options" id="options"></div>
        </div>
        <div class="quiz-footer">
            
            <button class="btn btn-primary float-right" id="next-btn">Next</button>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    var iteamQuestion = "{{ isset($training->questions) ? count($training->questions) : 0 }}";
    const quizData = @json($quizData);
console.log(quizData);

let currentQuestion = 0;
let score = 0;
let wrong = 0;


const questionEl = document.getElementById('question');
const optionsEl = document.getElementById('options');
const nextBtn = document.getElementById('next-btn');
const progressBar = document.querySelector('.progress-bar');
const quizContainer = document.getElementById('quiz');

function loadQuestion() {
    const question = quizData[currentQuestion];
    questionEl.textContent = question.question;
    optionsEl.innerHTML = '';
    // Assuming `question.options` contains the options array and `optionsEl` is the parent container.
question.options.forEach((option, index) => {
    // Create the label element with the necessary classes
    const label = document.createElement('label');
    label.classList.add('custom-control', 'custom-radio', 'custom-control-inline');

    // Create the input element
    const input = document.createElement('input');
    input.type = 'radio';
    input.name = 'option';
    input.id = `option-${index}`;
    input.value = index;
    input.classList.add('custom-control-input');

    // Create the span element for the label text
    const span = document.createElement('span');
    span.classList.add('custom-control-label');
    span.textContent = option;

    // Append input and span to the label
    label.appendChild(input);
    label.appendChild(span);

    // Append the label to the container
    optionsEl.appendChild(label);
});

    // question.options.forEach((option, index) => {
    //     console.log(index);
    //     const div = document.createElement('div');
    //     div.classList.add('form-check');

    //     const input = document.createElement('input');
    //     input.type = 'radio';
    //     input.name = 'option';
    //     input.id = `option-${index}`;
    //     input.value = index;
    //     input.classList.add('form-check-input');

    //     const label = document.createElement('label');
    //     label.textContent = option;
    //     label.htmlFor = `option-${index}`;
    //     label.classList.add('form-check-label');

    //     div.appendChild(input);
    //     div.appendChild(label);
    //     optionsEl.appendChild(div);
    // });
    nextBtn.style.display = 'none';
    updateProgress();
}


function selectOption() {
    const selectedOption = document.querySelector('input[name="option"]:checked');
    if (selectedOption) {
        nextBtn.style.display = 'block';
    } else {
        nextBtn.style.display = 'none';
    }
}

// Add event listener for changes in radio selection
optionsEl.addEventListener('change', selectOption);


function checkAnswer() {
    const selectedOption = document.querySelector('input[name="option"]:checked');
    if (!selectedOption) return;

    const selectedAnswer = parseInt(selectedOption.value, 10);
    const question = quizData[currentQuestion];

    if (selectedAnswer === question.correct) {
        score++;
        selectedOption.parentElement.classList.add('correct'); // Highlight as correct
    } else {
        wrong++;
        selectedOption.parentElement.classList.add('correct'); // Highlight as incorrect
        optionsEl.children[question.correct].classList.add('correct'); // Highlight the correct answer
    }
    console.log(score,"::",wrong);
    // Disable all options
    Array.from(optionsEl.children).forEach(div => {
        div.querySelector('input').disabled = true;
    });
}

function updateProgress() {
    const progress = ((currentQuestion + 1) / quizData.length) * 100;
    progressBar.style.width = `${progress}%`;
    progressBar.setAttribute('aria-valuenow', progress);
}
function saveResult(){
    var quizFormData = {
        'total_ans':quizData.length,
        'correct_ans' : score,
        'wrong_ans' : wrong,
        '_token':$('meta[name="csrf-token"]').attr('content')
    }
    $.ajax({
        type: 'POST',
        url: "{{url('save/result')}}",
        data: quizFormData,
        success: function (response) {
            console.log(response);
            if (response.isStatus) {
                
                successMsg(response.message);
                let form = document.getElementById('addPartManualForm');
                $("#documentshow").html();
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#partmanuelModel").modal('hide');
                
                $(".partmanullist").html(response.html);
                
                
            } else {
                $.each(response.message, function (field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
            }
        },
        error: function (xhr, status, error) {
            $submitButton.html(originalText);
            $submitButton.prop('disabled', false);
        }
    });
}
function showResults() {
    quizContainer.innerHTML = `
                <div class="results">
                    <div class="result-icon">
                        <i class="fas ${score > quizData.length / 2 ? 'fa-trophy text-success' : 'fa-times-circle text-danger'}"></i>
                    </div>
                    <div class="score">Your score: ${score}/${quizData.length}</div>
                    <p>${score > quizData.length / 2 ? 'Great job!' : 'Better luck next time!'}</p>
                    <button class="btn btn-primary" onclick="location.reload()">Restart Quiz</button>
                </div>
            `;
}

nextBtn.addEventListener('click', () => {
    checkAnswer();
    currentQuestion++;
    if (currentQuestion < quizData.length) {
        loadQuestion();
    } else {
        saveResult();
        showResults();
    }
});

loadQuestion();
</script>
<script src="{{ asset('assets/js/training.js') }}"></script>

@endpush