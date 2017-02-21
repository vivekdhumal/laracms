<h3>Categories</h3>

<ul class="list-unstyled">
	@foreach($categories as $category)
	<li><a href="{{ url('/category/'.$category->slug) }}">{{ $category->name }}</a></li>
	@endforeach
</ul>