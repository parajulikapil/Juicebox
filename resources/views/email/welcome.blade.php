<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{config('app.name')}}</title>
    <style>
        .wrapper {
            display: flex;
            justify-content: center
        }
        .user_name {
            font-weight: bold
        }
    </style>
</head>

<body>    
    <div class="wrapper">  
        <div>
            <span class="user_name">Hello, {{$user->name}}</span>
            <p>Thank you for Signing Up</p>        
        </div>              
    </div>   
</body>

</html>