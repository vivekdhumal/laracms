@extends('themes.default.layout')

@section('content')
<div class="row">
	<div class="col-md-8">
		@if(count($articles))
			@foreach($articles as $article)
				<article>
					<a href="{{ url('/article/'.$article->article->slug) }}">
						<h2>{{ $article->article->title }}</h2>

						<p class="text-muted">Posted on {{ date('F d, Y', strtotime($article->article->created_at)) }}</p>

						@if(!is_null($article->article->featured_image))
							<img src="{{ asset('storage/featured_images/'.$article->article->featured_image) }}">
						@endif

						<p>{{ $article->article->excerpt }}</p>
					</a>
					<hr>
				</article>
			@endforeach
		@else
			<div class="well">
				<h3 class="text-center">Oops, No Articles Available!</h3>
			</div>
		@endif
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