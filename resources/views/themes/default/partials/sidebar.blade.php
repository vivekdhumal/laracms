<br>
<form action="{{ url('/') }}">
	<input type="text" class="form-control" name="search" placeholder="Search" value="{{ (isset($_GET['search'])) ? $_GET['search'] : '' }}">
</form>
@include('themes.default.partials.categories')
@include('themes.default.partials.tags')