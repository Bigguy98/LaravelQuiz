@extends('layouts.app')

@section('content')
    <div class="container">
        @if($topic)
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-md-8 py-8">
                    <div class="question-wrapper">
                        <h2>{{$topic->title}}</h2>
                    </div>
                    <form action="{{route('results.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="started_at" value="{{date('Y-m-d H:i:s')}}">
                        <div>
                            <input type="hidden" name="topic_id" value="{{$topic->id}}">
                            @foreach($topic->questions as $question )
                                <div class="question-wrapper">
                                    <span class="question">
                                        {{$question->question_text}}
                                    </span>
                                    @if(!empty($question->image))
                                        <img src="{{$question->image}}" alt="" class="img img-responsive img-fluid img-quiz">
                                    @endif
                                    <input type="hidden" name="question_id[]" value="{{$question->id}}">
                                    <div class="options @if(isset($question->options[9]['option']) && $question->options[9]['option'] == '10' || isset($question->options[4]['option']) && $question->options[4]['option'] == 'Expert') options-inline @endif @if(isset($question->options[0]['option']) && ($question->options[0]['option'] == '<10' || $question->options[0]['option'] == 'Junior Standard')) single @endif">
                                    @forelse($question->options as $option)
                                        <div class="option">
                                            <label class="checkbox-main" id="option-for-{{$question->id}}">{{$option->option}}
                                              <input type="checkbox" name="option[{{$question->id}}][{{$option->id}}]" value="{{$option->correct}}">
                                              <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    @empty
                                     <textarea class="form-control" name="option[{{$question->id}}]" ></textarea>
                                    @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{route('results.show', $topic->id)}}"><input type="submit" value="Submit" class="btn btn-primary mt-3"></a><br>
                    </form>
                </div>
            </div>
        @else
            <h1>No Topic</h1>
        @endif
    </div>
    <script>
        $('.options-inline .checkbox-main, .single .checkbox-main').on('click',function(){
            $('.options-inline .checkbox-main#'+$(this).prop('id')+', .single .checkbox-main#'+$(this).prop('id')).not(this).find('input').prop('checked', false);  
        });

        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(71948281, "init", {
            childIframe:true,
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true,
            trackHash:true
        });
    </script>
@endsection