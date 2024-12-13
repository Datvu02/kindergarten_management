<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['subject'] ?? '' }}</title>
</head>
<body>
    <h1>{{ $data['title'] ?? 'Notice of roll call' }}</h1>
    <p>{{ $data['body'] ?? 'You did not check in yesterday!!' }}</p>
</body>
</html>
