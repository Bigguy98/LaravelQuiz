@extends('layouts.app')

@section('content')
    <p id="countdown">Calculation</p>
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
                                    @if(!empty($question->front_code) && $question->show_front_code)
                                        <textarea rows = 10 class="option class editable front_code">{!! $question->front_code !!}</textarea>
                                        <div class="front_result hidden"></div>
                                    @endif
                                    @if(!empty($question->test_code) && $question->show_test_code)
                                        <textarea rows = 10 class="option class editable test_code">{!! $question->test_code !!}</textarea>
                                        <div class="test_result hidden"></div>
                                    @endif
                                    @if(!empty($question->config_code) && $question->show_config_code)
                                        <textarea rows = 10 class="option class editable config_code">{!! $question->config_code !!}</textarea>
                                        <div class="config_result hidden"></div>
                                    @endif
                                    @if(!empty($question->front_code) && $question->show_front_code || !empty($question->test_code) && $question->show_test_code || !empty($question->config_code) && $question->show_config_code)
                                        <button type="button" data-id="{{$question->id}}" class="btn btn-success run">Run the code</button>
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
                                    <textarea class="custom form-control @if(!empty($question->front_code)) hidden @endif" name="option[{{$question->id}}]" ></textarea>
                                    @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="button" value="Submit" class="btn btn-primary send mt-3">
                        <br><br>
                    </form>
                </div>
            </div>
        @else
            <h1>No Topic</h1>
        @endif
    </div>
    <script>
       function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.text(minutes + ":" + seconds);

                if (--timer < 0) {
                    timer = duration;
                }
            }, 1000);
        }

        jQuery(function ($) {
            var duration = 30 * {{count($topic->questions)}} + 120;
            var display = $('#countdown');
            startTimer(duration, display);
        });

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

        $(document).on('click','.run', function(){
            code = $(this).prev().html();
            id = $(this).attr('data-id');
            result = $(this).next();
            result.html("Executing...");
            result.removeClass('hidden');
            custom = $(this).parent().find('.custom');
            $.ajax({
                method: "POST",
                url: "/run",
                data: { 'code': code, 'id': id }
            }).done(function( data ) {
                result.html(data);
                custom.html(data);
            });
        });

        $(document).on('mouseenter','.send',function(){
            send = true;
            $( ".result" ).each(function( index ) {
                if($( this ).text() == ''){
                    send = false;
                }
            });
            if(send){
                $(this).attr('type', 'submit'); 
            }else{
                alert('Warning! You need to run the code in all forms by clicking the "Run the code" button.');
            }
        });
    </script>
@endsection