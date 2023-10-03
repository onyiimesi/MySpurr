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
       a:hover{
           cursor: pointer;
       }
    </style>

    </head>
    <body>
       <div>
           <div class="logo">
               <img src="https://myspurr.azurewebsites.net/logo/logo.png" alt="">
           </div>
           <h3>Verify your email address</h3>

           <p class="trial">
               Welcome to MySpurr! Click on the following link to verify your email address
           </p>
           <div>
               <a href="{{ $otp }}"><button>VERIFY EMAIL ADDRESS</button></a>
           </div>
           <p>
               If you didn’t request this email or if you think something is wrong, feel free to
               contact our support team at hello@myspurr.net. We’re available to help! <br><br>

               <a href="https://www.instagram.com/usemyspurr/">Instagram</a> <a href="https://web.facebook.com/usemyspurr">Facebook</a> <a href="https://www.linkedin.com/company/usemyspurr/ ">LinkedIn</a> <a href="https://twitter.com/usemyspurr">X (formerly twitter)</a>
           </p>

       </div>

   </body>
   </html>
