@extends('layouts.app')

@section('content')
    <div class="d-flex" id="wrapper">
        @if(Auth::user())
            @if(Auth::user()->role == 'admin')
                @include('adminpanel.adminSidebar')
            @endif
        @endif
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-4">
                    <h3 class="page-title">Quiz:</h3>
                    @foreach($topics as $topic)
                        <div class="card">
                            <div class="card-body mb-2">
                                <h5 class="card-title">{!!$topic->title!!}</h5>
                                <a href="{{route('topics.show', $topic->id)}}" class="inline_block btn btn-primary">Start Quiz</a>
                                @if(Auth::user())
                                    @if(Auth::user()->role == 'admin')
                                        <a href="{{route('topics.edit', $topic->id)}}"
                                           class="inline_block btn btn-warning">Edit</a>
                                        <form class="inline_block" action="{{route('topics.destroy', $topic->id)}}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-xs btn-danger" type="submit">Delete</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-6 mt-4">
                    <h3 class="page-title">Interviews:</h3>
                    @foreach($interviews as $topic)
                        <div class="card">
                            <div class="card-body mb-2">
                                <h5 class="card-title">{!!$topic->title!!}</h5>
                                <a href="{{route('topics.show', $topic->id)}}" class="inline_block btn btn-primary">Start Interview</a>
                                @if(Auth::user())
                                    @if(Auth::user()->role == 'admin')
                                        <a href="{{route('topics.edit', $topic->id)}}"
                                           class="inline_block btn btn-warning">Edit</a>
                                        <form class="inline_block" action="{{route('topics.destroy', $topic->id)}}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-xs btn-danger" type="submit">Delete</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
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