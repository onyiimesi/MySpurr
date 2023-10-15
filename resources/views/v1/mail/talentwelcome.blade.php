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
        }
        .charge{
            color: #011B1F;
            font-family: Satoshi;
            font-size: 25px;
            font-style: normal;
            font-weight: 700;
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
           <p>
                Dear {{ $name->first_name }} {{ $name->last_name }},
           </p>
           <h3>Welcome to MySpurr!</h3>
           <p>
            MySpurr was created with the sole purpose of nurturing and championing creative talents like you. We are thrilled that you've joined our vibrant community where creative aspirations flourish, and opportunities abound.
           </p>
           <p>
            Here's a glimpse of what MySpurr has to offer: <br>

            1. <strong>Showcase Your Portfolio</strong>: Put your best work on display for the world to see. Share your creativity and talents with a global audience. <br>

            2. <strong>Connect with Fellow Creatives</strong>: Forge valuable connections within our community of like-minded creative talents. Collaborate, learn, and grow together. <br>

            3. <strong>Seamless Invoicing</strong>: Effortlessly create and send invoices for your projects, ensuring you get compensated fairly and promptly. <br>

            4. <strong>Explore Creative Job Opportunities</strong>: Browse and apply for exciting job opportunities in the creative industry, tailored to your skills and interests. <br>

            5. <strong>Get Paid for Your Services</strong>: Receive payments securely and efficiently for your creative services, so you can focus on what you do best. <br>

            6. <strong>Access a World of Opportunities</strong>: MySpurr connects you with a growing list of global businesses actively seeking creative talents like you. <br>
           </p>
           <p class="trial">
             Ready to start your creative journey?
           </p>
           <div style="margin: 3em 0;">
               <a href="https://mango-glacier-097715310.3.azurestaticapps.net/login" class="button">UPDATE YOUR PROFILE</a>
           </div>
           <p>
                P.S. Lets connect on LinkedIn, I’d love you hear of your incredible journey with us
           </p>

           <div style="margin: 30px 0;">
                <a href="https://www.linkedin.com/in/akinyele-tobi/"><img src="https://myspurr.azurewebsites.net/logo/ceo.png" alt=""></a>
                <div>
                    <span>
                        <strong>Tobi Akinyele</strong>
                    </span>
                    <br>
                    <span>
                        CEO & Founder MySpurr
                    </span>
                </div>
           </div>

           <p>
                <a href="https://www.instagram.com/usemyspurr/">Instagram</a> <a href="https://web.facebook.com/usemyspurr">Facebook</a> <a href="https://www.linkedin.com/company/usemyspurr/ ">LinkedIn</a> <a href="https://twitter.com/usemyspurr">X (formerly twitter)</a>
           </p>
       </div>

   </body>
   </html>
