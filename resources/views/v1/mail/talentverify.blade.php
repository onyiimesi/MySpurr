<DOCTYPE html>
 <html lang=”en-US”>
 <head>
 <meta charset=”utf-8">
 <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">

 <style>
    body{
        background: #F9F9F9;
        padding: 50px 100px;
    }
    h1{
        color: #007582;
        font-family: Satoshi;
        font-size: 40px;
        font-style: normal;
        font-weight: 400;
        line-height: 74.647px;
    }
    .trial{
        color: #011B1F;
        font-family: Satoshi;
        font-size: 22px;
        font-style: normal;
        font-weight: 700;
        line-height: 52.078px;
    }
    p{
        color: #011B1F;
        font-family: Satoshi;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 37.471px;
    }
    h3{
        color: #011B1F;
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
    button{
        border: 0;
        border-radius: 20px;
        background: #43D0DF;
        color: #222;
        padding: 10px 20px;
        margin: 10px 0;
    }
    button:hover{
        cursor: pointer;
    }
 </style>

 </head>
 <body>
    <div>
        <div class="logo">
            <img src="https://myspurr.azurewebsites.net/logo/logo.svg" width="240px" height="52px" alt="">
        </div>
        <h1>Welcome to My Spurr!</h1>

        <p class="trial">
            Your 30 day free trial has started.
        </p>
        <p>
            MySpurr was created for creative talents, we're passionate about supporting talents like you by finding the perfect match for your skills and interests and providing the tools you need to succeed.
        </p>
        <h3>Ready to <span class="charge">super charge your creative career?</span></h3>
        <p>
            You can showcase your portfolio, connect directly with creative talents like yourself, create and send invoices, apply for jobs in the creative industry, receive payments for your services and access a growing list of global businesses always on the look out for creative talents.
        </p>
        <div>
            <a href="{{ $otp }}"><button>Confirm my email</button></a>
        </div>
        <p>
            Thanks again for trying out MySpurr!
        </p>
        <p>
            We can’t wait to help you build a successful creative career. <br>
            P.S. Lets connect on LinkedIn, I’d love you hear of your incredible journey with us
        </p>

        <p>
            Tobi Akinyele <br>
            CEO & Founder MySpurr
        </p>
    </div>

</body>
</html>
