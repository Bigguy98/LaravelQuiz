@extends('layouts.app')

@section('content')
    <div class="d-flex" id="wrapper">
        @include('adminpanel.adminSidebar')
        <div class="container">
            <h2 align="center">Create new Quiz</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <form action="{{route('topics.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Topic name">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="quiz" value="quiz" checked>
                        <label class="form-check-label" for="quiz">
                            Quiz
                        </label>
                    </div>
                    <div class="form-check"> 
                        <input class="form-check-input" type="radio" name="type" id="interview" value="interview">
                        <label class="form-check-label" for="interview">
                            Interview
                        </label>
                    </div>
                    <input type="submit" name="submit" id="submit" class="btn btn-success" value="Create Topic"/>
                </form>
            </div>

            <div class="form-group">
                <hr>
                <form action="{{route('questions.store')}}" method="post">
                    @csrf
                    <div class="table-responsive">
                        <h2 class="mt-2" align="center">Add question to quiz</h2>
                        <table class="table table-bordered" id="dynamic_field">
                            <div class="form-group">
                                <label for="">Select Topic</label>
                                <select name="topic" id="inputState" class="form-control">
                                    @foreach($topics as $topic)
                                        <option selected value="{{$topic->id}}">{{$topic->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <tr>
                                <td>
                                    <input type="text" name="question" placeholder="New question"
                                           class="form-control question_list" required
                                    />
                                <td>
                                    <input type="text" name="options[]" placeholder="New option"
                                           class="form-control options_list" required
                                    />
                                </td>
                                <td>
                                    <input type="checkbox"
                                           name="correct[]"
                                           value="1"
                                           placeholder="Correct"
                                           class="form-control"
                                    />
                                </td>
                                </td>
                                <td>
                                    <button type="button" name="addAnswer" id="addAnswer" class="btn btn-success mb-2">
                                        Add Answer
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <input type="submit" name="addQuestion" id="addQuestion" class="btn btn-success mb-2 mr-2" value="Add Question"/>
                    </div>
                </form>
            </div>

            <div class="form-group">
                <hr>
                <form action="{{route('questions.store-interview')}}" method="post">
                    @csrf
                    <div class="table-responsive">
                        <h2 class="mt-2" align="center">Add question to interview</h2>
                        <table class="table table-bordered" id="select_field">
                            <div class="form-group">
                                <label for="">Select Topic</label>
                                <select name="topic" id="inputState" class="form-control">
                                    @foreach($interviews as $topic)
                                        <option selected value="{{$topic->id}}">{{$topic->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <tr>
                                <td>
                                    <input type="text" name="question" placeholder="New question"
                                           class="form-control question_list" required
                                    />
                                </td>
                            </tr>
                                <tr>
                                <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="custom" value="custom" checked>
                                <label class="form-check-label" for="custom">
                                    Custom text answer field
                                </label>
                                <br>
                                <input class="form-check-input" type="radio" name="type" id="rate5" value="rate5">
                                <label class="form-check-label" for="rate5">
                                    Rate 1-5 answers (Do not know ... Expert')
                                </label>
                                <br>
                                <input class="form-check-input" type="radio" name="type" id="rate10" value="rate10">
                                <label class="form-check-label" for="rate10">
                                    Rate 1-10 answers (1,2...10)
                                </label>
                                <br>
                                <input class="form-check-input" type="radio" name="type" id="options" value="options">
                                <label class="form-check-label" for="options">
                                    Add options
                                </label>
                            </div>
                            </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="options[]" placeholder="New option"class="form-control options_list" />
                                </td>
                                <td>
                                    <button type="button" name="addOption" id="addOption" class="btn btn-success mb-2">
                                        Add Answer
                                    </button>
                                </td>
                        </table>
                        <input type="submit" name="addQuestion" id="addQuestion" class="btn btn-success mb-2 mr-2" value="Add Question"/>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            var n = 1;
            var b = 1;

            $('#addAnswer').click(function () {
                n++;
                $('#dynamic_field').append('' +
                    '<tr id="row' + n + '" class="dynamic-added">' +
                    '<td>' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="options[]" required placeholder="New option" class="form-control question_list" />' +
                    '</td>' +
                    '<td>' +
                    '<input type="checkbox" name="correct[]" value="' + n + '" class="form-control question_list" />' +
                    '</td>' +
                    '<td>' +
                    '<button type="button" name="remove" id="' + n + '" class="btn btn-danger btn_remove">X</button>' +
                    '</td>' +
                    '</tr>');
            });

            $('#addOption').click(function () {
                b++;
                $('#select_field').append('' +
                    '<tr id="row' + b + '-o" class="dynamic-added">' +
                    '<td>' +
                    '<input type="text" name="options[]" placeholder="New option" class="form-control question_list" />' +
                    '</td>' +
                    '<td>' +
                    '<button type="button" name="remove" id="' + b + '-o" class="btn btn-danger btn_remove">X</button>' +
                    '</td>' +
                    '</tr>');
            });

            $(document).on('click', '.btn_remove', function () {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

        });
    </script>
@endsection