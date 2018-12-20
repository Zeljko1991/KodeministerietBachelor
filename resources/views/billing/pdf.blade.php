<head>
    <meta charset="utf-8">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css'>
</head>

<body>

    @foreach ($SubCases as $SubCase)
        <p>{{$SubCase->title}}</p>
    @endforeach
</body>
