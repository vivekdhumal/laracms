<h3>Tags</h3>

<div>
	@foreach($tags as $tag)
	<span class="label label-info tags"><a href="{{ url('/tag/'.$tag->slug) }}">#{{ $tag->name }}</a></span>
	@endforeach
</div>