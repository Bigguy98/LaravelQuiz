<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResultRequest;
use App\Question;
use App\Result;
use App\User;
use App\UserOption;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultsController extends Controller
{

    public function __construct() {
        $this->middleware('admin')->except(['store', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if(isset($request->email)){
            $user = User::where('email',$request->email)->first();
            if($user){
                $allResults = Result::where('user_id', $user->id)->orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
                $selected = $request->email;
            }else{
                abort(404);
            }
        }else{
            $allResults = Result::orderBy('user_id', 'desc')->orderBy('created_at', 'desc')->get();
            $selected = null;
        }
        $users = User::where('role','user')->has('results')->orderBy('id','DESC')->get();

        return view('results.index', ['allResults' => $allResults, 'selected' => $selected, 'users' => $users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResultRequest $request)
    {
        //
        $score = 0;
        $questions = $request->input('option');

        if ($questions) {
            foreach ($questions as $key => $value) {
                $question = Question::find($key);
                $userCorrectAnswers = 0;
                if(is_array($value)){
                    foreach ($value as $answerKey => $answerValue) {
                        if ($answerValue == 1) {
                            $userCorrectAnswers++;
                        } else {
                            $userCorrectAnswers--;
                        }
                    }
                }
                if ($question->correctOptionsCount() == $userCorrectAnswers) {
                    $score++;
                }
            }
            $result = new Result();
            $result->user_id = Auth::user()->id;
            $result->topic_id = $request->input('topic_id');
            $result->correct_answers = $score;
            $result->questions_count = count($request->input('question_id'));
            $result->started_at = $request->started_at;
            $result->save();

            foreach ($questions as $key => $value) {
                if(is_array($value)){
                    foreach ($value as $answerKey => $answerValue) {
                        $userOption = new UserOption();
                        $result->user_id = Auth::user()->id;
                        $userOption->result_id = $result->id;
                        $userOption->question_id = $key;
                        $userOption->topic_id = $request->input('topic_id');
                        $userOption->option_id = $answerKey;
                        $userOption->save();
                    }
                }else{
                    $userOption = new UserOption();
                    $result->user_id = Auth::user()->id;
                    $userOption->result_id = $result->id;
                    $userOption->question_id = $key;
                    $userOption->topic_id = $request->input('topic_id');
                    $userOption->custom = $value;
                    $userOption->save();
                }
            }

            return redirect(route('results.show', $result->id));
        } else {
            return redirect()->back();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $result = Result::find($id);

        return view('results.show', ['result' => $result]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
