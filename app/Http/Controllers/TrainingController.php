<?php

namespace App\Http\Controllers;

use App\Http\Requests\assignTraining;
use App\Http\Requests\TrainingRequest;
use App\Models\AssignTarainingSets;
use App\Models\Exam;
use App\Models\hazmatCompany;
use App\Models\QuestionSets;
use App\Models\Training;
use App\Models\TrainingSets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    //
    public function index(Request $requet)
    {
        try {
            $role_id = Auth::user()->roles->first()->level;
            $user =  Auth::user();
            $training = TrainingSets::get();
            $hazmatCompany = hazmatCompany::get();



            return view('training.list', ['training' => $training,'hazmatCompany'=>$hazmatCompany]);
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }
    public function add(Request $request)
    {
        return view('training.add');
    }
    public function editTraining($id)
    {
        $training = TrainingSets::with(['questions','assignsethzmatCompany.hazmatCompaniesName'])->find($id);
        return view('training.add', compact('training'));
    }
    public function trainingSave(Request $request)
    {
        $post = $request->input();
        $training = TrainingSets::updateOrCreate(
            ['id' => $post['id']], // The condition to check (match by 'id')
            ['name' => $post['name']] // The fields to update or create
        );
        if (@$post['deleted_questions_id']) {
            $deletedIds = explode(',', $post['deleted_questions_id']);

            foreach ($deletedIds as $value) {
                QuestionSets::where('id', $value)->delete();
            }
        }
        if (@$post['questions']) {
            $imagePath = 'uploads/trainingRecored/';

            foreach ($post['questions'] as $key => $value) {
                if ($value['answer_type'] == 'file') {
                    if ($request->hasFile("questions.$key.option_a")) {
                        $value['option_a'] = $request->file("questions.$key.option_a");
                    }
                    if ($request->hasFile("questions.$key.option_b")) {
                        $value['option_b'] = $request->file("questions.$key.option_b");
                    }
                    if ($request->hasFile("questions.$key.option_c")) {
                        $value['option_c'] = $request->file("questions.$key.option_c");
                    }
                    if ($request->hasFile("questions.$key.option_d")) {
                        $value['option_d'] = $request->file("questions.$key.option_d");
                    }
                }
                $value['training_sets_id'] = $training->id;
                QuestionSets::updateOrCreate(['id' => $key], $value);
            }
        }
        return response()->json(['isStatus' => true, 'message' => 'Questions save successfully!!']);
    }

    public function assigntraining(TrainingRequest $request){
        $post = $request->input();
        if(@$post['training_sets_id']){
            $explode = explode(',',$post['training_sets_id']);
            foreach($explode as $value){
                $fetchData = AssignTarainingSets::where('training_sets_id',$value)->where('hazmat_companies_id',$post['hazmat_companies_id'])->first();
                $data_add['training_sets_id'] = $value;
                $data_add['hazmat_companies_id'] = $post['hazmat_companies_id'];
                if($fetchData){
                    AssignTarainingSets::where('id',$fetchData['id'])->update($data_add);

                }else{
                    AssignTarainingSets::create($data_add);

                }
            }
        }
        return response()->json(['isStatus' => true, 'message' => 'Assign successfully!!']);

    }
    public function training(Request $request){
        $hazmat_companies_id= Auth::user()->hazmat_companies_id;
        $user = Auth::user();
        $ship_id = $user->shipClient->id;
        $training_sets_id = AssignTarainingSets::where('hazmat_companies_id', $hazmat_companies_id)
        ->inRandomOrder()
        ->limit(2)
        ->pluck('training_sets_id')
        ->toArray();
        shuffle($training_sets_id);

        $questionSets = QuestionSets::whereIn('training_sets_id',$training_sets_id )->get();
        $quizData = $questionSets->map(function ($question) {
            return [
                'question' => $question->question_name,
                'answer_type' => $question->answer_type,
                'options' => [
                    $question->option_a,
                    $question->option_b,
                    $question->option_c,
                    $question->option_d,
                ],
                'correct' => match ($question->correct_answer) {
                    'A' => 0,
                    'B' => 1,
                    'C' => 2,
                    'D' => 3,
                    default => null, // Handle unexpected values
                },
            ];
        });
        return view('training.exam',['quizData'=>$quizData]);
    }
    public function saveResult(Request $request){
     $post = $request->input();
     $user = Auth::user();
     $inputData['ship_id'] = $user->shipClient->id;
     $inputData['ship_staff_id'] = $user->id;
     $inputData['correct_ans'] = $post['correct_ans'];
     $inputData['wrong_ans'] = $post['wrong_ans'];
     $inputData['total_ans'] = $post['total_ans'];
     Exam::create($inputData);
     return response()->json(['isStatus' => true, 'message' => 'submit successfully!!']);

    }
}
