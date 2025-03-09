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
        <h3>Hi {{ $business->first_name }}</h3>
        <p>
            Welcome to MySpurr! We’re excited to have you on board as you start connecting with Africa’s top creative talents. In this email, we’ll guide you step-by-step on how to create and set up your business account.
        </p>

        <p><strong>Getting Started:</strong></p>

        <ul>
            <li>Registration: Visit our landing page and select "Business" from the sign-up options. Fill out the registration form with your company name, industry, email, website, social media links, and contact number.</li>
            <li>Verification: Once registered, you'll receive a confirmation email. Simply click the verification link to activate your account.</li>
            <li>Company Profile: Head over to your dashboard and complete your company profile. Add your logo, a compelling overview of your brand, and details about your services. A polished profile is key to attracting top talent.</li>
        </ul>

        <p>
            Watch this video to get started: <br />
            <a href="https://www.youtube.com/watch?v=kjj5m4NFCVk">https://www.youtube.com/watch?v=kjj5m4NFCVk</a>
        </p>
        <p>
            Need help? We’re always here for you! <br>
            Reach out anytime at <a href="hello@myspurr.net">hello@myspurr.net</a>. Excited to see you thrive,
        </p>
        <p>
            Best, <br>
            Michael from MySpurr
        </p>
    </div>
</body>
</html>
