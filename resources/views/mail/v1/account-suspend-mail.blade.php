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
        font-family: 'Satoshi', sans-serif;
        font-size: 20px;
        font-style: normal;
        font-weight: 500;
    }
    p{
        color: #011B1F;
        font-family: 'Satoshi', sans-serif;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
    }
    h3{
        color: #007582;
        font-family: 'Satoshi', sans-serif;
        font-size: 25px;
        font-style: normal;
        font-weight: 400;
        line-height: 69.237px;
    }
    .charge{
        color: #011B1F;
        font-family: 'Satoshi', sans-serif;
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
        <h3>Dear {{ $user->first_name }} {{ $user->last_name }}</h3>
        <p>
            We regret to inform you that your MySpurr profile has been temporarily suspended due to continued violations of our platform’s policies, despite our previous warning.
        </p>
        <p>
            The suspension is effective immediately. Our community thrives on professionalism and respect, and we are committed to maintaining a positive environment for all users.
        </p>
        <p>
            Please review our <a href="https://www.myspurr.net/terms-and-conditions">terms of use</a> for a detailed explanation of our rules. Should you wish to discuss this matter further, you may contact us within the next 14 days to request a review.
        </p>
        <p>
            Thank you for your understanding.
        </p>
        <p>
            Sincerely,
        </p>
        <p>
            The MySpurr Team
        </p>
    </div>
</body>
</html>
