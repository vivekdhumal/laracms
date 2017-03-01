@extends('themes.'.config('blog.blog_theme', 'default').'.layout')

@section('content')
<div class="row" style="min-height: 500px;padding-top: 15%;">

	<h2 class="text-center">{{ trans('blog.404_error') }}</h2>
	<p class="text-center"><a href="{{ url('/') }}" class="btn btn-md btn-default">Go to home</a></p>

</div>
@endsection