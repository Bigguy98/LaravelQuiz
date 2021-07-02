@extends('layouts.app')

@section('content')

    <div class="d-flex" id="wrapper">
        @include('adminpanel.adminSidebar')
        <div class="container">
            <div class="page-container">
                <div class="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="page-content">
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <h3 class="page-title">All Results</h3>
                                    <select class="filter form-control">
                                        <option value="" @if(!$selected) selected @endif >All</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->email}}" @if(isset($selected) && $selected == $user->email) selected @endif >{{$user->name}} ({{$user->email}})</option>
                                        @endforeach
                                    </select>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-striped datatable table-white">
                                                <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Quiz/Interview</th>
                                                    <th>Passed</th>
                                                    <th>Date</th>
                                                    <th style="min-width:100px;">Result</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($allResults as $result)
                                                    <tr>
                                                        <td>{{$result->user->name}} ({{$result->user->email}})</td>
                                                        <td>{{$result->topic->title}}</td>
                                                        <td>@if(!empty($result->started_at)) {{pretty_date($result->started_at,$result->created_at)}} @else n/a @endif</td>
                                                        <td>{{$result->created_at}}</td>
                                                        @if($result->topic->type == "quiz")
                                                        <td>
                                                            <div class="progress">
                                                            <div class="progress-bar progress-bar-{{prgressClass($result->correct_answers,$result->questions_count)}}" role="progressbar" aria-valuenow="{{percentage($result->correct_answers,$result->questions_count)}}" aria-valuemin="0" aria-valuemax="100" style="width:{{percentage($result->correct_answers,$result->questions_count)}}%">
                                                            </div>
                                                            <span class="progress-completed">{{percentage($result->correct_answers,$result->questions_count)}}%</span>
                                                            </div>
                                                        </td>
                                                        @else
                                                        <td>Passed</td>
                                                        @endif
                                                        <td>
                                                            <a href="{{route('results.show', $result->id)}}"
                                                               class="btn btn-xs btn-primary">View</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    </div>
    <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->



    </div>
    </div>
    </div>

    <script type="text/javascript">
        $('.filter').change(function(){
            email = $('.filter option:selected').val();
            if(email != ''){
                param = "?email="+email;
            }else{
                param = '';
            }
            window.location.replace("{{url()->current()}}" + param);
        });
    </script>
@endsection