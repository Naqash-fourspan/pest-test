<html>
<head>
    <title>Pest Task</title>
</head>
<body>
<h1> Pest Task</h1>
<ul>
    @foreach($projects as $project)
        <li>{{$project->title}}</li>
    @endforeach
</ul>
</body>
</html>
