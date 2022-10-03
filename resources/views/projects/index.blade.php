<html>
<head>
    <title>Pest Task</title>
</head>
<body>
<h1> Pest Task</h1>
<ul>
    @forelse($projects as $project)
        <li>
            <a href="{{$project->path()}}">{{$project->title}}</a>
        </li>
    @empty
        <li> No projects yet.</li>
    @endforelse
</ul>
</body>
</html>
