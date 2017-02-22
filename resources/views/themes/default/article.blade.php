@extends('themes.default.layout')

@section('content')
<div class="row">
	<div class="col-md-8">
		<article>
			<h2>{{ $article->title }}</h2>

			<p class="text-muted">Posted on {{ date('F d, Y', strtotime($article->created_at)) }}</p>

			@if(!is_null($article->featured_image))
				<img src="{{ asset('storage/featured_images/'.$article->featured_image) }}">
			@endif

			{!! $article->content !!}

			@if(count($article->tags))
				<hr>
				@foreach($article->tags as $tag)
				<span class="label label-info tags"><a href="{{ url('/tag/'.$tag->tag->slug) }}">#{{ $tag->tag->name }}</a></span>
				@endforeach
			@endif


		</article>
	</div>

	<div class="col-md-3 col-sm-offset-1">
		@include('themes.default.partials.sidebar')
	</div>
</div>
@endsection