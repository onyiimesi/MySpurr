<DOCTYPE html>
 <html lang=”en-US”>
 <head>
 <meta charset=”utf-8">
 <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">

 <style>
    body{
        padding: 50px 100px;
        font-family: 'Satoshi', sans-serif;
    }
    .trial{
        color: #011B1F;
        font-family: Satoshi;
        font-size: 20px;
        font-style: normal;
        font-weight: 500;
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
        <img src="https://myspurr.azurewebsites.net/logo/logo.png" alt="">
    </div>
    <div class="main">
        <h3>Hi {{ $user->first_name }}</h3>

        <p class="trial">
            To complete your action, please use the following code for verification:
        </p>
        <div style="font-size: 20px; font-weight: 600;">
            OTP Token: {{ $user->otp }}
        </div>
        <p>
            The code expires in 5 minutes.
        </p>
        <p>If you did not initiate this change, please let us know.</p>
        <p>For account safety reasons, please do not forward this email to anyone.</p>
        <p>
            Warm Regards, <br>
            The MySpurr team.
        </p>
    </div>

</body>
</html>
