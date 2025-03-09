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
            Finding the right creative talent is essential for your business success. Here’s how you can effectively search and evaluate candidates on MySpurr.
        </p>

        <p><strong>Using Our Platform:</strong></p>
        <ul>
            <li><strong>Advanced Filters:</strong> Use our search tools to filter candidates by skill set, experience, location, and availability.</li>
            <li><strong>Profile Review:</strong> Dive into each candidate’s portfolio, review their past projects, and check ratings and testimonials.</li>
            <li><strong>Tailored Recommendations:</strong> Our platform’s algorithm provides personalized candidate suggestions based on your job requirements.</li>
        </ul>

        <p><strong>Best Practices:</strong></p>
        <ul>
            <li>Look for consistency in quality and presentation.</li>
            <li>Prioritize candidates with strong portfolios and clear professional narratives.</li>
        </ul>

        <p>
            Watch this video to learn more: <br />
            <a href="https://www.youtube.com/watch?v=wOKNNYPdOzg">https://www.youtube.com/watch?v=wOKNNYPdOzg</a>
        </p>
        <p>
            Need further guidance? Our support team is here to help at <a href="mailto:hello@myspurr.net">hello@myspurr.net</a>.
        </p>
        <p>
            Best regards,<br>
            The MySpurr Team
        </p>
    </div>
</body>
</html>
