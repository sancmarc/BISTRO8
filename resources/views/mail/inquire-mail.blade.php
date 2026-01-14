<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bistro 8</title>
</head>

<body>
    <h1>Bistro 8 Italian Restaurant</h1>
    <p>Hello {{$name}}!</p>
    <p>Inquire &sol;<br>
    {{$inquire}}
    </p>
    <br>
    Thanks and Regards,<br>
    {{ config('app.name') }}
</body>

</html>