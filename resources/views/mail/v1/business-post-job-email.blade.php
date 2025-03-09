<!DOCTYPE html>
 <html lang="en-US">
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
            Now that your business account is set up, it’s time to start hiring! Posting job openings on MySpurr is simple and efficient.
        </p>

        <p><strong>Step-by-Step Guide:</strong></p>

        <ul>
            <li>Access Your Dashboard: Log in and click “Post a Job” to open a dedicated form for your listing.</li>
            <li>Fill in Job Details: Enter essential information such as job title, location, job type (full-time, part-time, or contract), description, responsibilities, required skills, benefits, salary range, and experience/qualification.</li>
            <li>Review & Post: Carefully review your job post before clicking “Post.”</li>
        </ul>

        <p><strong>Tips to Stand Out:</strong></p>
        <ul>
            <li>Craft a clear, attention-grabbing title.</li>
            <li>Highlight your company culture and unique benefits.</li>
            <li>Be concise yet informative to attract the right candidates.</li>
        </ul>

        <p>
            Watch this video to learn more: <br />
            <a href="https://www.youtube.com/watch?v=5VmAXKyQ1NQ">https://www.youtube.com/watch?v=5VmAXKyQ1NQ</a>
        </p>
        <p>
            Happy hiring,<br>
            The MySpurr Team
        </p>
    </div>
</body>
</html>
