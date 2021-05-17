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
                <div class="col-md-8">
                    <div class="question-wrapper">
                        <h2>{{$topic->title}}</h2>
                    </div>
                    <form action="{{route('results.store')}}" method="post">
                        @csrf
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
                                    @foreach($question->options as $option)
                                        <div class="option">
                                            <label class="checkbox-main">{{$option->option}}
                                              <input type="checkbox" name="option[{{$question->id}}][{{$option->id}}]" value="{{$option->correct}}">
                                              <span class="checkmark"></span>
                                            </label>

                                        </div>
                                    @endforeach
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
    <script type="text/javascript" >
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