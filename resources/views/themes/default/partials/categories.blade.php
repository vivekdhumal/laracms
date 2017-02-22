<h3>Categories</h3>

<ul class="list-unstyled category-list">
	@foreach($categories as $category)
	<li>
		<a href="{{ url('/category/'.$category->slug) }}">{{ $category->name }}
		{!! (count($category->articles) > 0) ? '<span class="badge">'.count($category->articles).'</span>' : '' !!}
		</a>
	</li>
	@endforeach
</ul>