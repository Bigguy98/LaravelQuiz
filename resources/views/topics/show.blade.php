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
                                        {!!nl2br($question->question_text)!!}
                                    </span>
                                    @if(!empty($question->image))
                                        <img src="{{$question->image}}" alt="" class="img img-responsive img-fluid img-quiz">
                                    @endif
                                    @if(!empty($question->front_code) && $question->show_front_code)
                                        <textarea rows = 10 class="option class editable front_code">{!! $question->front_code !!}</textarea>
                                    @endif
                                    @if(!empty($question->test_code) && $question->show_test_code)
                                        <textarea rows = 10 class="option class editable test_code">{!! $question->test_code !!}</textarea>
                                    @endif
                                    @if(!empty($question->config_code) && $question->show_config_code)
                                        <textarea rows = 10 class="option class editable config_code">{!! $question->config_code !!}</textarea>
                                    @endif
                                    @if(!empty($question->front_code) && $question->show_front_code || !empty($question->test_code) && $question->show_test_code || !empty($question->config_code) && $question->show_config_code)
                                        <div class="flex">
                                            <button type="button" data-id="{{$question->id}}" class="btn btn-success run">Run the code</button>
                                            <div class="alert hidden alert-success{{$question->id}} alert-success">Build success</div>
                                            <div class="alert hidden alert-danger{{$question->id}} alert-danger">Build failure</div>
                                        </div>
                                        <div class="result-wrapper">
                                            <div class="result h43 result{{$question->id}} hidden"></div>
                                            <button type="button" class="btn hide-result hide-result{{$question->id}} hidden btn-primary" data-id="{{$question->id}}">-</button>
                                            <button type="button" class="btn show-result show-result{{$question->id}} hidden btn-primary" data-id="{{$question->id}}">+</button>
                                        </div>
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
                                    <textarea class="custom custom{{$question->id}} form-control @if(!empty($question->front_code)) hidden @endif" name="option[{{$question->id}}]" ></textarea>
                                    @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="button" value="Submit" class="btn btn-primary send mt-3">
                        <button type="button" data-toggle="modal" data-target="#exampleModal" class="final-popup hidden" data-backdrop="static" data-keyboard="false"></button>
                        <br><br>
                    </form>
                </div>
            </div>
        @else
            <h1>No Topic</h1>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Processing</h5>
            <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <br>
            <h6>Please do not close this window, tests of your code are currently running.</h6>
            <div class="lds-facebook"><div></div><div></div><div></div></div>
            <br>
          </div>
        </div>
      </div>
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
            front = false;
            test = false;
            config = false;
           
            if($(this).closest('.question-wrapper').find('.front_code').length !== 0){
                front = $(this).closest('.question-wrapper').find('.front_code').val();
            }
            if($(this).closest('.question-wrapper').find('.test_code').length !== 0){
                test = $(this).closest('.question-wrapper').find('.test_code').val();
            }
            if($(this).closest('.question-wrapper').find('.config_code').length !== 0){
                config = $(this).closest('.question-wrapper').find('.config_code').val();
            }
           
            id = $(this).attr('data-id');
            $('.result'+id).html("Executing...").removeClass('hidden');
            if($('.hide-result'+id).hasClass('hidden')){
                $('.show-result'+id).removeClass('hidden');
            }
            $('.alert-success'+id).addClass('hidden');
            $('.alert-danger'+id).addClass('hidden');
           
            $.ajax({
                method: "POST",
                url: "/run",
                data: { 'front': front, 'test': test, 'config': config, 'id': id }
            }).done(function( data ) {
                data = JSON.parse(data);
                $('.result'+data.id).html(data.text);
                $('.custom'+data.id).html(data.text);
                if(data.status){
                    $('.alert-success'+data.id).removeClass('hidden');
                }else{
                    $('.alert-danger'+data.id).removeClass('hidden');
                }
            });
        });

        clicked = false;
        $(document).on('click','.send',function(){
            send = true;
            $('.final-popup').click();
            $('.final-popup').remove();
            $( ".result" ).each(function( index ) {
                if($( this ).text() == '' || $( this ).text() == 'Executing...'){
                    send = false;
                }
            });
            if(send){
                setTimeout(function() {
                    $('form').submit();
                }, 1000);
            }else{
                $(this).attr('value','Executing all code ...');
                if(!clicked){
                    clicked = true;
                    $('.run').click();
                    setInterval(function(){
                        $('.send').click();
                    },500);
                }
            }
        });

        $(document).on('click','.show-result',function(){
            id = $(this).attr('data-id');
            $('.show-result'+id).addClass('hidden');
            $('.hide-result'+id).removeClass('hidden');
            $('.result'+id).removeClass('h43').addClass('h100');
        });

        $(document).on('click','.hide-result',function(){
            id = $(this).attr('data-id');
            $('.hide-result'+id).addClass('hidden');
            $('.show-result'+id).removeClass('hidden');
            $('.result'+id).removeClass('h100').addClass('h43');
        });
    </script>
@endsection