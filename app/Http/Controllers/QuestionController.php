<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Options;
use App\Question;
use App\Topic;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $questions = Question::all();

        return view('questions.index', ['questions'=>$questions]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        //
        $topicID = $request->input('topic');
        $questionText = $request->input('question');
        $optionArray = $request->input('options');
        $correctOptions = $request->input('correct');

        $question = new Question();
        $question->topic_id = $topicID;
        $question->question_text = $questionText;
        $question->save();

        $questionToAdd = Question::latest()->first();;
        $questionID = $questionToAdd->id;

        foreach ($optionArray as $index => $opt) {
            $option = new Options();
            $option->question_id = $questionID;
            $option->option = $opt;
            foreach ($correctOptions as $correctOption) {
                if($correctOption == $index+1) {
                    $option->correct = 1;
                }
            }

            $option->save();
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeInterview(Request $request)
    {

        //
        $topicID = $request->input('topic');
        $questionText = $request->input('question');
        $type = $request->input('type');

        $question = new Question();
        $question->topic_id = $topicID;
        $question->question_text = $questionText;
        $question->save();

        $questionToAdd = Question::latest()->first();;
        $questionID = $questionToAdd->id;

        if ($type != "custom") {

            if ($type == "rate5") {
                $optionArray = [
                    1 => 'Never heard',
                    2 => 'Heard something',
                    3 => 'Rarely use',
                    4 => 'Regularly use',
                    5 => 'Expert',
                ];
            }

            if ($type == "rate10") {
                $optionArray = [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                    9 => '9',
                    10 => '10',
                ];
            }

            if ($type == "options") {
                $optionArray = $request->input('options');
            }

            foreach ($optionArray as $index => $opt) {
                $option = new Options();
                $option->question_id = $questionID;
                $option->option = $opt;
                $option->save();
            }
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)

    {
        //

        $question = Question::find($id);

        return view('questions.show', ['question'=>$question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $question = Question::find($id);
        $topics = Topic::all();

        return view('questions.edit', ['question'=>$question, 'topics'=>$topics]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, $id)
    {
        //
        $topicID = $request->input('topic_id');
        $questionText = $request->input('question_text');

        $question = Question::find($id);
        $question->topic_id = $topicID;
        $question->question_text = $questionText;
        $question->save();


        return redirect(route('questions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $question = Question::find($id);
        $question->delete();

        return redirect(route('questions.index'));

    }
}
