<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LaraCMS</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,600" rel="stylesheet" type="text/css">

    <style type="text/css">
    	body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 400;
            height: 100vh;
            margin: 0;
            font-size: 15px;
    	}
    	body p {
    		line-height: 25px;
    	}
    	body img {
    		width: 100%;
    		margin-bottom: 20px;
    	}
    	a, a:hover, a:focus, a:visited,
    	article a, article a:hover, article a:focus, article a:visited {
    		text-decoration: none;
    		color: inherit;
    	} 
    	.tags {
    		float: left;
    		padding: 0px;
    		margin: 5px 5px 5px 5px; 		
    	}
    	.tags a {
    		padding: 8px;
    		text-decoration: none;
    		color: #fff;
    		font-size: 15px;
    		display: inline-block;
    	}
    	#blogContent {
   			margin: 20px 0 30px 0;
    	}
    	footer.blog-footer {
			padding: 40px 0;
			color: #999;
			text-align: center;
			background-color: #f9f9f9;
			border-top: 1px solid #e5e5e5;
    	}
    	.category-list {
    		margin-top: 15px;
    	}
    	.category-list li {
    		margin-bottom: 10px;
    	}
    	.category-list li .badge {
    		background:#5bc0de;
    	}
    </style>
</head>
<body>
	<div class="container">
		<a href="{{ url('/') }}"><h1>Blog Title</h1></a>

		<p class="text-muted">Your blog description goes here.</p>

		<hr>
		<div id="blogContent">
			@yield('content')			
		</div>
	</div>
	<footer class="blog-footer">
		<p class="text-center">
			&copy; LaraCMS
		</p>
	</footer>
</body>
</html>