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
		</article>
	</div>

	<div class="col-md-3 col-sm-offset-1"><br>
		<form>
			<input type="text" class="form-control" name="search" placeholder="Search">
		</form>
		@include('themes.default.partials.categories')
		@include('themes.default.partials.tags')
	</div>
</div>
@endsection