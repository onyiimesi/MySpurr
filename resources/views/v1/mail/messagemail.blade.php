<!DOCTYPE html>
 <html lang=”en-US”>
 <head>
    <title></title>
 <meta charset="utf-8">
 <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">

 <style>
    body{
        padding: 50px 100px;
        font-family: 'Satoshi', sans-serif;
    }
    .trial{
        margin: 0 auto 10px auto;
        text-align: center;
    }
    p{
        color: #011B1F;
        font-family: Satoshi;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
    }
    h3{
        color: #007582;
        font-family: Satoshi;
        font-size: 25px;
        font-style: normal;
        font-weight: 400;
        line-height: 69.237px;
    }
    .charge{
        color: #011B1F;
        font-family: Satoshi;
        font-size: 25px;
        font-style: normal;
        font-weight: 700;
        line-height: 69.237px;
    }
    .button{
        border: 0;
        border-radius: 35px;
        background: #43D0DF;
        padding: 15px 25px;
        margin: 10px 0;
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
    }
    .button:hover{
        cursor: pointer;
    }
    a{
        color: #000 !important;
    }
    a:hover{
        cursor: pointer;
    }
    .main{
        width: 650px;
        height: 100%;
        background: #fff;
        box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        padding: 20px;
        border-radius: 5px;
    }
    .logo{
        width: 100%;
        height: 100%;
        margin: 0 auto;
        text-align: center;
    }
 </style>

 </head>
 <body>
    <div class="logo">
        <img src="https://backend-api.myspurr.net/public/logo/logo.png" alt="">
    </div>
    <div class="main">
        <h3 style="text-align: center; padding: 0; margin: 0;">1 new message awaits your response</h3>

        <div class="trial">
            @php
                $image = $data->sender->image !== null ? $data->sender->image : "https://backend-api.myspurr.net/public/assets/userplaceholder.jpg";
            @endphp
            <img src="{{ $image }}" width="80" height="80" style="border-radius: 100%;" alt="">
        </div>

        <div style="text-align: center;">
            <p style="font-size: 24px; font-weight: 600;">{{ $data->sender->first_name }} {{ $data->sender->last_name }}</p>
        </div>

        <div style="text-align: center;">
            @php
                $url = config('services.baseurl') . '/messages';
            @endphp
            <a href="{{ url($url) }}" class="button">View Message</a>
        </div>
    </div>

</body>
</html>
