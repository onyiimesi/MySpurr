<DOCTYPE html>
    <html lang=”en-US”>
    <head>
    <meta charset=”utf-8">
    <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">

    <style>
       body{
           background: #fff;
           padding: 50px 100px;
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
       button{
           border: 0;
           border-radius: 35px;
           background: #43D0DF;
           color: #000;
           padding: 15px 25px;
           margin: 10px 0;
           font-weight: 500;
           font-size: 13px;
       }
       button:hover{
           cursor: pointer;
       }
       .main{
            background: #fff;
            box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
        }
    </style>

    </head>
    <body>
       <div class="main">
           <div class="logo">
               <img src="https://myspurr.azurewebsites.net/logo/logo.svg" width="240px" height="52px" alt="">
           </div>
           <h3>Verify your email address</h3>

           <p class="trial">
               Copy the code below to verify
           </p>
           <div>
               <h3>{{ $otp->otp }}</h3>
           </div>
           <p>
               If you didn’t request this email or if you think something is wrong, feel free to
               contact our support team at hello@myspurr.net. We’re available to help! <br><br>

               <a href="">Instagram</a> <a href="">Facebook</a> <a href="">LinkedIn</a> <a href="">X (formerly twitter)</a>
           </p>

       </div>

   </body>
   </html>
