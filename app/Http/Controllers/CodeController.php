<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CodeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Runs the code user sent from the quiz.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function run(Request $request){
        
        $question = Question::where('id',$request->id)->first();
        $user = Auth::user();

        $front = $question->show_front_code ? $request->front : $question->front_code;
        $test = $question->show_test_code ? $request->test : $question->test_code;
        $config = $question->show_config_code ? $request->config : $question->config_code;

        preg_match_all('/class (.*) {/msU', $front, $fronts);
        if(isset($fronts[1][0]) && !empty($fronts[1][0])){
            $front_name = trim($fronts[1][0]);
        }else{
            echo "Problem reading main java file syntax";
            exit();
        }

        preg_match_all('/class (.*) {/msU', $test, $tests);
        if(isset($tests[1][0]) && !empty($tests[1][0])){
            $test_name = trim($tests[1][0]);
        }else{
            echo "Problem reading tests java file syntax";
            exit();
        }

        preg_match_all('/<scope>(.*)<\/scope>/msU', $config, $configs);
        if(isset($configs[1][0]) && !empty($configs[1][0])){
            $config_name = trim($configs[1][0]);
        }else{
            echo "Problem reading config file syntax.";
            exit();
        }

        shell_exec('cd '.storage_path().'/code/'.$user->id.'/'.$request->id.'/ && rm -r *');

        Storage::disk('storage')->put('code/'.$user->id.'/'.$request->id.'/src/main/java/'.$front_name.'.java', html_entity_decode($front));
        Storage::disk('storage')->put('code/'.$user->id.'/'.$request->id.'/src/test/java/'.$test_name.'.java', html_entity_decode($test));
        Storage::disk('storage')->put('code/'.$user->id.'/'.$request->id.'/pom.xml', html_entity_decode($config));
        
        echo nl2br(shell_exec('cd '.storage_path().'/code/'.$user->id.'/'.$request->id.'/ && mvn '.$config_name));
    }
}
