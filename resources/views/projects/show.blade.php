<html>
<head>
    <title>Pest Task</title>
</head>
<body>
<h1>BirdBoard PRODUCT SHOW</h1>
<ul>

    <li>{{$project->title}}</li>
    <li>{{$project->description}}</li>
    <li>{{$project->notes}}</li>
</ul>
@foreach($project->tasks as $task)
    <div class="task">
        <h3>{{$task->body}}</h3>
    </div>
@endforeach
</body>
</html>
