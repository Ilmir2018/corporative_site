@extends(env('THEME') . '.layouts.site');

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('sidebar')
    {!! $leftBar !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection
