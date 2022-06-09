@extends('layouts.app')

@section('content')
    <div class="d-flex" id="wrapper">
        @include('adminpanel.adminSidebar')
        <div class="container">
            @if($question)
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{route('questions.update', $question->id)}}">
                    @csrf
                    @method('put')
                    <div class="panel panel-default">
                        <h2 align="center">Edit Question</h2>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <select class="form-control" name="topic_id">
                                        @foreach($topics as $topic)
                                            <option value="{{$topic->id}}" {{($topic->id == $question->topic_id) ? 'selected' : ''}}>{{$topic->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    
                                    <label for="question" class="control-label">Question text</label>
                                    <textarea class="form-control" required name="question" id="question" rows="5">{{$question->question_text}}</textarea>
                                    
                                    <br>
                                    <label for="image" class="control-label">Question image in base64 format</label>
                                    <textarea name="image" id="image" rows="5" class="form-control question_list">{{$question->image}}</textarea>
                                    
                                    <br>
                                    <label for="front" class="control-label">Code of Example.java file</label>
                                    <textarea name="front" id="front" rows="5" class="form-control question_list">{{$question->front_code}}</textarea>
                                    <label> <input type="checkbox" name="show_front" {{$question->show_front_code ? "checked" : ""}} > Show to user</label>
                                    
                                    <br>
                                    <label for="test" class="control-label">Code of ExampleTest.java file</label>
                                    <textarea name="test" id="test" rows="5" class="form-control question_list">{{$question->test_code}}</textarea>
                                    <label> <input type="checkbox" name="show_test" {{$question->show_test_code ? "checked" : ""}} > Show to user</label>
                                    
                                    <br>
                                    <label for="config" class="control-label">Code of config pom.xml file</label>
                                    <textarea name="config" id="config" rows="5" class="form-control question_list">{{$question->config_code}}</textarea>
                                    <label> <input type="checkbox" name="show_config" {{$question->show_config_code ? "checked" : ""}} > Show to user</label>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Update">
                </form>
            @else
                <h1>No Question</h1>
            @endif
        </div>
    </div>
@endsection