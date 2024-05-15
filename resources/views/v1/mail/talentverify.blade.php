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
        color: #011B1F;
        font-family: Satoshi;
        font-size: 22px;
        font-style: normal;
        font-weight: 700;
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
        margin: 0 auto 10px auto;
        text-align: center;
    }
 </style>

 </head>
 <body>
    <div class="logo">
        <img src="https://backend-api.myspurr.net/public/logo/logo.png" alt="">
    </div>
    <div class="main">
        <h3>Verify your email address</h3>

        <p class="trial">
            Welcome to MySpurr! Click on the following link to verify your email address
        </p>
        <div style="margin: 3em 0;">
            <a href="{{ $otp }}" class="button">VERIFY EMAIL ADDRESS</a>
        </div>
        <p>
            If you didn’t request this email or if you think something is wrong, feel free to
            contact our support team at hello@myspurr.net. We’re available to help! <br><br>

            <a href="https://www.instagram.com/usemyspurr/">Instagram</a> <a href="https://web.facebook.com/usemyspurr">Facebook</a> <a href="https://www.linkedin.com/company/usemyspurr/ ">LinkedIn</a> <a href="https://twitter.com/usemyspurr">X (formerly twitter)</a>
        </p>
    </div>

</body>
</html>
