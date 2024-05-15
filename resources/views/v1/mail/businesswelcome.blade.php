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
                Dear {{ $name->business_name }},
           </p>
           <h3>Welcome to MySpurr for Businesses!</h3>
           <p>
            We're delighted to have you join MySpurr, we specialize in simplifying the creative talent acquisition process, connecting you with exceptional professional talents.
           </p>
           <p>
            At MySpurr, we understand that finding the right talent is pivotal to your success. Our mission is to make this journey easier and more effective for your organization.
           </p>
           <p>
            Here's how MySpurr can empower your talent search: <br>

            1. <strong>Access to Top Talent</strong>: Gain access to a diverse pool of skilled professionals and creative talents. <br><br>

            2. <strong>Streamlined Hiring</strong>: Our platform streamlines the hiring process, from posting jobs to reviewing applications, and ultimately selecting the ideal candidates for your team. <br><br>

            3. <strong>Effortless Communication</strong>: Communicate seamlessly with potential hires through our messaging system, making it easier to evaluate their fit for your organization. <br><br>

            4. <strong>Secure Payments</strong>: We facilitate secure payment processes to ensure that you and your talents can focus on your projects without worrying about financial logistics. <br><br>

            5. <strong>Tailored Solutions</strong>: Our team is here to assist you every step of the way. We offer tailored solutions to meet your unique talent acquisition needs. <br><br>

           </p>
           <p class="trial">
                Ready to start finding the perfect talent for your business?
           </p>
           <div>
               <a href="https://app.myspurr.net/login" class="button">LOG IN TO YOUR ACCOUNT</a>
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
