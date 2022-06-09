@extends('layouts.app')

@section('content')

    <div class="d-flex" id="wrapper">
        <div class="container">
            @if($result)
                @if(auth()->user()->role == 'admin')
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <table class="table table-bordered table-striped table-white">
                            <tr>
                                <th>Quiz/Interview</th>
                                <td>{{$result->topic->title}}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>{{$result->user->name}} ({{$result->user->email}})</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{$result->created_at}}</td>
                            </tr>
                            <tr>
                                <th>Pass time</th>
                                <td>@if(!empty($result->started_at)) {{pretty_date($result->started_at,$result->created_at)}} @else n/a @endif</td>
                            </tr>
                            <tr>
                                <th>Result</th>
                                @if($result->topic->type == "quiz")
                                <td>{{$result->correct_answers}}/{{$result->questions_count}}</td>
                                @else
                                <td>Passed</td>
                                @endif
                            </tr>
                        </table>
                        <table class="table table-bordered table-striped table-white">
                            <?php $n = 0 ?>
                            @foreach($result->topic->questions as $question)
                                <?php $n++ ?>
                                <tr class="test-option-false">
                                    <th style="width: 10%">Question #{{$n}}</th>
                                    <th>{{$question->question_text}}</th>
                                </tr>
                                <tr>
                                    <td>Options</td>
                                    <td>
                                        <ul>
                                            @foreach($result->options as $user_option)
                                                @if($user_option->question_id == $question->id)
                                                    {!! colorize($user_option->custom) !!}
                                                @endif
                                            @endforeach
                                            @foreach($question->options as $option)
                                                @if($option->correct == 1)
                                                    @php $answer = ""; $class = "red"; @endphp
                                                    @foreach($result->options as $user_option)
                                                        @if($user_option->option_id == $option->id)
                                                            @php $answer = "<b>(your answer)</b>"; $class = "green"; @endphp 
                                                        @endif
                                                    @endforeach
                                                    <li style="font-weight: bold;" class="{{$class}}">
                                                        {{$option->option}} <b>(correct answer)</b> {!!$answer;!!}
                                                    </li>
                                                @else
                                                    @php $class = ""; $answer = ""; @endphp
                                                    @foreach($result->options as $user_option)
                                                        @if($user_option->option_id == $option->id)
                                                            @php $class = $result->topic->type == "quiz" ? "red" : "green"; $answer = "<b>(your answer)</b>"; @endphp
                                                        @endif
                                                    @endforeach
                                                    <li class="{{$class}}">
                                                        {!!$option->option!!} {!!$answer!!}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @else
                    <h1>Quiz done. Thank you!</h1>
                @endif
            @else
                <h1>No Result</h1>
            @endif
        </div>
    </div>
@endsection


