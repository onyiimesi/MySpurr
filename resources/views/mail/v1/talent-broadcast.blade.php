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
        <h3>Hi {{ $talent->first_name }}</h3>
        <p>
            Here’s how to make the most of your experience on MySpurr, the platform where African talents like you connect with top local and global businesses:
        </p>
        <ol>
            <li>Complete Your Profile – A well-detailed profile increases your chances of getting hired.</li>
            <li>Upload Your Best Work – Showcase your skills with portfolio samples.</li>
            <li>Start Browsing Jobs – Opportunities in tech, marketing, and design are waiting for you.</li>
        </ol>
        <p>
            Watch this video to get started <br />
            Embed Video: <a href="https://www.youtube.com/watch?v=XQA7S93Jv20&t=5s">https://www.youtube.com/watch?v=XQA7S93Jv20&t=5s</a>
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
