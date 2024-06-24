<!doctype html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">
    <style>
        /* -------------------------------------
              GLOBAL RESETS
          ------------------------------------- */
    
        /*All the styling goes here*/
        *,
        ::before,
        ::after {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }
    
        img {
          border: none;
          -ms-interpolation-mode: bicubic;
          max-width: 100%;
        }
    
        body {
          background-color: #f6f6f6;
          font-family: sans-serif;
          -webkit-font-smoothing: antialiased;
          font-size: 14px;
          line-height: 1.4;
          margin: 0;
          padding: 0;
          -ms-text-size-adjust: 100%;
          -webkit-text-size-adjust: 100%;
        }
    
        table {
          border-collapse: separate;
          mso-table-lspace: 0pt;
          mso-table-rspace: 0pt;
          width: 100%;
        }
    
        table td {
          font-family: sans-serif;
          font-size: 14px;
          /* vertical-align: top;  */
        }
    
        /* -------------------------------------
              BODY & CONTAINER
          ------------------------------------- */
    
        .body {
          background-color: #f6f6f6;
          width: 100%;
        }
    
        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
          display: block;
          margin: 0 auto !important;
          /* makes it centered */
          max-width: 580px;
          padding: 10px;
          width: 580px;
        }
    
        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
          box-sizing: border-box;
          display: block;
          margin: 0 auto;
          max-width: 580px;
          padding: 10px;
        }
    
        /* -------------------------------------
              HEADER, FOOTER, MAIN
          ------------------------------------- */
        .main {
          background: #F9F9F9;
          border-radius: 3px;
          width: 100%;
        }
    
        .wrapper {
          box-sizing: border-box;
          padding: 80px 50px;
        }
    
        .content-block {
          padding-bottom: 10px;
          padding-top: 10px;
        }
    
        .footer {
          clear: both;
          margin-top: 30px;
          text-align: center;
          width: 100%;
        }
    
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center;
        }
    
        /* -------------------------------------
              TYPOGRAPHY
          ------------------------------------- */
        h1,
        h2,
        h3,
        h4 {
          color: #000000;
          font-family: sans-serif;
          font-weight: 400;
          line-height: 1.4;
          margin: 0;
          /* margin-bottom: 30px;  */
        }
    
        h1 {
          font-size: 35px;
          font-weight: 300;
          text-align: center;
          text-transform: capitalize;
        }
    
        p,
        ul,
        ol {
          font-family: 'Satoshi';
          font-size: 14px;
          font-weight: normal;
          margin: 0;
          /* margin-bottom: 15px;  */
        }
    
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px;
        }
    
    
    
        /* -------------------------------------
              BUTTONS
          ------------------------------------- */
        .btn {
          box-sizing: border-box;
          width: 100%;
        }
    
        .btn>tbody>tr>td {
          padding-bottom: 15px;
        }
    
        .btn table {
          width: auto;
        }
    
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center;
        }
    
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 10.165px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize;
        }
    
        .btn-primary table td {
          background-color: #43D0DF;
          border: none;
          border-radius: 50px;
    
        }
    
        .btn-primary a {
          background: #43D0DF;
          color: #000;
          border: none;
          border-radius: 50px;
          font-size: 10.165px;
        }
    
    
    
        /* -------------------------------------
              OTHER STYLES THAT MIGHT BE USEFUL
          ------------------------------------- */
        .last {
          margin-bottom: 0;
        }
    
        .align-center {
          text-align: center;
        }
    
        .align-right {
          text-align: right;
        }
    
        .align-left {
          text-align: left;
        }
    
        .clear {
          clear: both;
        }
    
        .mt0 {
          margin-top: 0;
        }
    
        .mb0 {
          margin-bottom: 0;
        }
    
        .preheader {
          color: transparent;
          display: none;
          height: 0;
          max-height: 0;
          max-width: 0;
          opacity: 0;
          overflow: hidden;
          mso-hide: all;
          visibility: hidden;
          width: 0;
        }
    
        .powered-by a {
          text-decoration: none;
        }
    
        hr {
          border: 0;
          border-bottom: 1px solid #EAEAEA;
          margin: 5px 0 5px 0;
        }
    
        .heading {
          color: #007582;
          font-family: EB Garamond;
          font-size: 38.9px;
          font-style: normal;
          font-weight: 400;
          line-height: 45.574px;
          /* 116.129% */
          padding-top: 60px;
          font-family: 'EB Garamond', serif;
          margin-bottom: 30px !important;
    
        }
    
        .welcome_text {
          color: #011B1F;
          font-family: Satoshi;
          font-size: 19.628px;
          font-style: normal;
          font-weight: 400;
          line-height: 33px;
          /* 190.909% */
        }
    
        .logo {
          width: 239.813px;
          height: 51.619px;
          font-family: 'Satoshi';
        }
    
        @font-face {
          font-family: 'Satoshi';
          src: url('https://res.cloudinary.com/dkxn7qs49/raw/upload/v1657200404/Font/Satoshi-Variable_iu9svo.ttf') format('truetype');
          font-weight: 400 900;
          font-display: swap;
          font-style: normal;
        }
    
        /* -------------------------------------
              RESPONSIVE AND MOBILE FRIENDLY STYLES
          ------------------------------------- */
        @media only screen and (max-width: 620px) {
    
          /* .topRow .text {
                padding-left: 0px !important;
            } */
    
          /* recent change start */
    
          .viewText {
            padding: 6px !important;
            font-size: 8px !important;
            margin-left: 0 !important;
          }
    
          .salary {
            font-size: 12px !important;
          }
    
          .col2 p {
            padding: 4px !important;
            font-size: 6px !important;
          }
    
          /* recent change end */
    
          .table0 .text {
            width: auto !important;
          }
    
          .jobDescription {
            width: 100% !important;
          }
    
          .col2 {
            width: auto !important;
          }
    
          .adsMain {
            width: 100% !important;
            padding: 10px !important;
          }
    
          .topRow .text {
            padding-left: 0 !important;
          }
    
          .table3 .btn {
            width: 100% !important;
          }
    
          .footerTable .text1 h3,
          .footerTable .text2 {
            text-align: center !important;
          }
    
          .footerTable .btn {
            width: 100% !important;
          }
    
          .links {
            text-align: center !important;
          }
    
          hr {
            margin: 10px 0 10px 0 !important;
          }
    
          .adsMain .company,
          .adsMain .role {
            font-size: 14px !important;
            margin-bottom: 0 !important;
          }
    
          .adsMain .workTime {
            font-size: 9px !important;
          }
    
          .heading {
            font-size: 25.9px !important;
          }
    
          .welcome_text {
            font-size: 15.628px;
            line-height: 22px;
            /* 190.909% */
          }
    
    
          table.body h1 {
            font-size: 28px !important;
            margin-bottom: 10px !important;
          }
    
          /* table.body ul,
            table.body ol,
            table.body td,
            table.body span {
              font-size: 16px !important; 
            } */
          table.body .wrapper,
          table.body .article {
            padding: 40px 20px !important;
          }
    
          table.body .content {
            padding: 0 !important;
          }
    
          table.body .container {
            padding: 0 !important;
            width: 100% !important;
          }
    
          table.body .main {
            border-left-width: 0 !important;
            border-radius: 0 !important;
            border-right-width: 0 !important;
          }
    
          table.body .btn table {
            width: 100% !important;
          }
    
          table.body .btn a {
            width: 100% !important;
            text-align: center;
          }
    
          table.body .img-responsive {
            height: auto !important;
            max-width: 100% !important;
            width: auto !important;
          }
        }
    
        /* -------------------------------------
              PRESERVE THESE STYLES IN THE HEAD
          ------------------------------------- */
        @media all {
          .ExternalClass {
            width: 100%;
          }
    
          .ExternalClass,
          .ExternalClass p,
          .ExternalClass span,
          .ExternalClass font,
          .ExternalClass td,
          .ExternalClass div {
            line-height: 100%;
          }
    
          .apple-link a {
            color: inherit !important;
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            text-decoration: none !important;
          }
    
          #MessageViewBody a {
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            font-family: inherit;
            font-weight: inherit;
            line-height: inherit;
          }
    
          .btn-primary table td:hover {
            background-color: #34495e !important;
          }
    
          .btn-primary a:hover {
            background-color: #00474F !important;
            color: #ffffff !important;
          }
        }
    
        /* -------------------------------------
              SCOPED STYLES
          ------------------------------------- */
        .table1 .row1 {
          padding: 42px 30px;
        }
    
        .table2 {
          background: #00525B;
          padding: 22px 30px;
        }
    
        p {
          color: var(--Foundation-Body-B50, #E6E9EA);
          font-family: Satoshi;
          font-size: 14px;
          font-style: normal;
          font-weight: 400;
          line-height: 37.471px;
        }
    
        a {
          color: #000;
          font-style: normal;
          font-family: Satoshi;
          font-weight: 500;
          text-decoration: none;
          line-height: 0;
          color: inherit;
          width: 100%;
        }
    
        .table2 h3 {
          color: #FFF;
          font-feature-settings: 'clig' off, 'liga' off;
          font-family: Satoshi;
          font-size: 19px;
          font-style: normal;
          font-weight: 700;
          line-height: 45.088px;
        }
    
        .table3,
        .footerTable {
          width: 90%;
          margin: 41px auto 0 auto;
        }
    
        .table3 p {
          color: #000;
          font-feature-settings: 'clig' off, 'liga' off;
          line-height: 18px;
          margin-bottom: 41px;
        }
    
    
    
        .adsMain {
          width: 90%;
          margin: 0 auto;
          border-radius: 6.254px;
          border: 0.625px solid rgba(37, 64, 53, 0.67);
          background: #FFFFFD;
          padding: 18px;
          margin-bottom: 31px;
        }
    
        .adsContainer {
          margin-bottom: 54px;
        }
    
        .adsContainer h3 {
          margin: 0;
        }
    
        .img {
          width: 20%;
        }
    
        .img.time img,
        .img.location img,
        .img.schedule img {
          width: 100%;
          vertical-align: middle;
        }
    
        .img.time,
        .img.location,
        .img.schedule {
          width: auto;
          vertical-align: middle;
          padding: 0;
          margin: 0;
        }
    
        .topRow .text {
          padding-top: 10px;
        }
    
        .img img {
          width: 80%;
          height: 80%;
        }
    
        .text .img img,
        .table4 .img img {
          width: 19.531px;
          height: 19.531px;
        }
    
        .adsMain .company {
          color: var(--Secondary-S400, #2F929C);
          font-family: Satoshi;
          font-size: 15.38px;
          font-style: normal;
          font-weight: 500;
          line-height: 15.634px;
          margin-bottom: 7px;
        }
    
        .adsMain .role {
          color: #000;
          font-feature-settings: 'clig' off, 'liga' off;
          font-family: Satoshi;
          font-size: 13.006px;
          font-style: normal;
          font-weight: 500;
          line-height: 12.653px;
          margin-bottom: 1px;
        }
    
        .adsMain .workTime {
          margin-bottom: 0;
          color: var(--Foundation-danger-D300, #DA5252);
          font-feature-settings: 'clig' off, 'liga' off;
          font-family: Satoshi;
          font-size: 8.391px;
          font-style: normal;
          font-weight: 500;
          line-height: 10.382px;
        }
    
        .text .img,
        .text .workTime,
        .col1,
        .col2 {
          vertical-align: middle;
        }
    
        .col2 {
          text-align: end;
          width: 32%;
        }
    
        .text3 .btn-primary a {
          background: #00474F !important;
          color: white !important;
        }
    
        .text3 .btn-primary a:hover {
          background: #43D0DF !important;
        }
    
        .text .workTime {
          width: 90%;
        }
    
        .table4 p {
          margin: 0;
    
        }
    
        .table4 .salary {
          color: rgba(36, 64, 52, 0.70);
          font-feature-settings: 'clig' off, 'liga' off;
          font-family: Satoshi;
          font-size: 15.008px;
          font-style: normal;
          font-weight: 500;
          line-height: 23.284px;
          /* 155.142% */
          /* margin-bottom: 7px; */
        }
    
        .table4 .img {
          height: 100%;
          width: 12px;
        }
    
        .table4 .text {
          padding: 0;
          height: 100%;
    
        }
    
        .table4 .col1 table {
          width: 100%;
        }
    
        .col1 .text {
          color: rgba(0, 0, 0, 0.70);
          font-feature-settings: 'clig' off, 'liga' off;
          font-family: Satoshi;
          font-size: 11.992px;
          font-style: normal;
          font-weight: 700;
          line-height: 26.575px;
        }
    
        .col2 p {
          width: 100%;
          margin-bottom: 0 !important;
          /* margin-left: auto; */
          color: #000;
          text-align: center;
          font-family: Satoshi;
          font-size: 9.71px;
          font-style: normal;
          font-weight: 500;
          line-height: 11.882px;
          /* 208.088% */
          letter-spacing: 0.625px;
          text-transform: uppercase;
          padding: 9px;
          border-radius: 15px;
          background: var(--Foundation-Success-S75, #EDF0B8);
        }
    
        .table4 .text {
          padding: 0;
          vertical-align: center;
          margin-left: auto;
        }
    
        .table4 .viewText {
          text-align: end;
        }
    
        /* recent change */
        .table4 .text .viewText {
          margin: 0;
          width: 100%;
          text-align: center;
          font-size: 9.7px;
          line-height: 11.882px;
          /* 158.333% */
          letter-spacing: 0.625px;
          text-transform: uppercase;
          border-radius: 15px;
          background: #43D0DF;
          padding: 9px 21px;
        }
    
        /* recent change */
        .table4 .text .viewText:hover {
          background-color: #00474F !important;
          color: #ffffff !important;
        }
    
        .table5 table {
          width: auto;
          margin-left: auto;
        }
    
        .table5 table .img {
          width: auto;
        }
    
        .table5 .img img {
          width: 40px;
          height: 40px;
          margin-left: 10px;
        }
    
        .table3 .btn {
          width: 40%;
          margin: 0 auto;
          margin-bottom: 50px;
        }
    
        .table3 .btn a {
          text-align: center;
          font-size: 10.135px;
          line-height: 20.192px;
          /* 142.857% */
          letter-spacing: 0.883px;
          text-transform: uppercase;
          padding: 14px 15px;
        }
    
        .footerTable {
          margin-top: 0;
        }
    
        .footerTable .text1 h3 {
          color: var(--Foundation-Body-B400, #011B1F);
          font-family: Satoshi;
          font-size: 14px;
          font-style: normal;
          font-weight: 500;
          line-height: 23px;
          /* 115% */
          margin-bottom: 15px;
          text-align: center;
        }
    
        .footerTable .text2 {
          color: #000;
          font-feature-settings: 'clig' off, 'liga' off;
          font-family: Satoshi;
          font-size: 14px;
          font-style: normal;
          font-weight: 400;
          line-height: 19px;
          /* 135.714% */
          text-align: center;
    
        }
    
        .footerTable .btn {
          width: 50%;
          margin: 34px auto 45px;
    
        }
    
        .footerTable .text3 a {
          border-radius: 13.882px;
          background: var(--Secondary-S75, #B2ECF2);
          font-feature-settings: 'clig' off, 'liga' off;
          font-size: 11.846px;
          font-weight: 400;
          line-height: 22.615px;
          text-decoration-line: underline;
        }
    
        .links {
          text-align: center;
        }
    
        .links a {
          color: var(--P300, #007582);
          font-size: 11.96px;
          font-weight: 400;
          line-height: 22.834px;
          text-decoration-line: underline;
        }
    
        .links a:hover {
          color: #00474F !important;
        }
    
        .table0 .text {
          width: 45%;
        }
    
        .table0 .text a {
          width: 100%;
        }
    
        .table0 table {
          width: 30%;
          vertical-align: middle;
          text-align: center;
          margin-left: auto;
        }
    
        .shareJob,
        .col0 {
          vertical-align: middle;
        }
    
        .table0 .img {
          width: 100%;
          padding-top: 5px;
        }
    
        .table0 .shareJob img {
          width: 30px;
          height: 30px;
          cursor: pointer;
        }
    
        .jobDescription {
          width: 90%;
        }
      </style>
</head>

<body>
    <table border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">
                    <table class="main">
                        <tr>
                            <td class="">
                                <table class="table1">
                                    <tr>
                                        <td class="row1">
                                            <!-- myspurrr_logo_dark -->
                                            <img src="https://backend-api.myspurr.net/public/logo/logo.png" alt="">
                                        </td>
                                    </tr>
                                </table>
                                <table class="table2">
                                    <tr>
                                        <td>
                                            <p>
                                                Dear {{ $talent->first_name }} {{ $talent->last_name }},
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3>New Job Suggestions for {{ $talent->first_name }}</h3>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table3">
                                    <tr>
                                        <td>
                                            <p>
                                                Here are some jobs on MySpurr that might be a good fit for you:
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table class="adsContainer">

                                                @foreach ($jobs as $job)
                                                    <tr class="singleAdsContainer">
                                                        <td>
                                                            <table class="adsMain">
                                                                <tr>
                                                                    <td>
                                                                        <table>
                                                                            <tr class="topRow">
                                                                                @php
                                                                                    $image = $job->business->company_logo !== null ? $job->business->company_logo : "https://backend-api.myspurr.net/public/assets/userplaceholder.jpg";
                                                                                @endphp
                                                                                <td class="img">
                                                                                    <img src="{{ $image }}" alt="job logo">
                                                                                </td>
                                                                                <td class="text">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <table>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <h3
                                                                                                                class="company">
                                                                                                                {{ $job->business->business_name }}
                                                                                                            </h3>
                                                                                                            <h3
                                                                                                                class="role">
                                                                                                                {{ $job->job_title }}
                                                                                                            </h3>
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="col2">
                                                                                                            <p>
                                                                                                                {{ $job->job_type }}
                                                                                                            </p>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <table
                                                                                                    class="jobDescription">
                                                                                                    <tr>
                                                                                                        <td
                                                                                                            class="data">
                                                                                                            <table>
                                                                                                                <tr
                                                                                                                    class="row">
                                                                                                                    <td
                                                                                                                        class="img location">
                                                                                                                        <!-- calender png -->
                                                                                                                        <img src="https://backend-api.myspurr.net/public/assets/calendar.png" style="width: 100%; height: 100%;"
                                                                                                                        alt="">
                                                                                                                    </td>
                                                                                                                    <td
                                                                                                                        class="workTime">
                                                                                                                        {{ \Carbon\Carbon::parse($job->created_at)->format('d M Y') }}
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="data">
                                                                                                            <table>
                                                                                                                <tr
                                                                                                                    class="row">
                                                                                                                    <td
                                                                                                                        class="img location">
                                                                                                                        <!-- location png -->
                                                                                                                        <img src="https://backend-api.myspurr.net/public/assets/location_on.png" alt="">
                                                                                                                    </td>
                                                                                                                    <td
                                                                                                                        class="workTime">
                                                                                                                        Work
                                                                                                                        from
                                                                                                                        anywhere
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="data">
                                                                                                            <table>
                                                                                                                <tr
                                                                                                                    class="row">
                                                                                                                    <td
                                                                                                                        class="img location">
                                                                                                                        <!-- timer png -->
                                                                                                                        <img src="https://backend-api.myspurr.net/public/assets/timer.png" style="width: 100%; height: 100%;" alt="">
                                                                                                                    </td>
                                                                                                                    <td
                                                                                                                        class="workTime">
                                                                                                                        Anytime
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <hr>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table class="table4">
                                                                            <tr>
                                                                                <td class="col1">
                                                                                    <p class="salary">
                                                                                        &#x20A6;{{ number_format($job->salary_min) }} - &#x20A6;{{ number_format($job->salary_max) }}/{{ $job->salaray_type }}
                                                                                    </p>
                                                                                    <p>
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td class="img">
                                                                                                <img src="https://backend-api.myspurr.net/public/assets/verified.jpg" style="width: 10px; height: 10px;" alt="">
                                                                                            </td>
                                                                                            <td>
                                                                                                <p class="text">
                                                                                                    Verified Client
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    </p>
                                                                                </td>
                                                                                <td class="col0">
                                                                                    <table class="table0">
                                                                                        <tr>
                                                                                            {{-- <td class="shareJob">
                                                                                                <table>
                                                                                                    <tr>
                                                                                                        <td
                                                                                                            class="img">
                                                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                                width="23"
                                                                                                                height="23"
                                                                                                                viewBox="0 0 23 23"
                                                                                                                fill="none">
                                                                                                                <path
                                                                                                                    d="M22.2591 11.0718C22.2591 16.9449 17.4994 21.7059 11.6282 21.7059C5.75695 21.7059 0.997246 16.9449 0.997246 11.0718C0.997246 5.19864 5.75695 0.437676 11.6282 0.437676C17.4994 0.437676 22.2591 5.19864 22.2591 11.0718Z"
                                                                                                                    stroke="#97A6A8"
                                                                                                                    stroke-width="0.625351" />
                                                                                                                <path
                                                                                                                    fill-rule="evenodd"
                                                                                                                    clip-rule="evenodd"
                                                                                                                    d="M13.4352 5.45312C15.1278 5.45312 16.0988 6.31509 16.0988 7.81673V15.2792C16.0988 15.5924 15.9421 15.8742 15.6787 16.0319C15.4162 16.19 15.0998 16.1931 14.8344 16.039L11.8605 14.3105L8.8591 16.0426C8.72936 16.1176 8.58715 16.1556 8.44445 16.1556C8.29725 16.1556 8.15005 16.115 8.01632 16.0339C7.75336 15.8763 7.59668 15.5945 7.59668 15.2818V7.72278C7.59668 6.28018 8.56819 5.45312 10.2622 5.45312H13.4352ZM13.4352 6.2232H10.2622C8.99033 6.2232 8.34515 6.72734 8.34515 7.72278V15.2818C8.34515 15.3301 8.37209 15.3562 8.39455 15.3696C8.417 15.384 8.45243 15.3942 8.49335 15.3706L11.6778 13.5327C11.7916 13.4675 11.9308 13.467 12.0451 13.5332L15.2021 15.3681C15.2435 15.3927 15.279 15.3814 15.3014 15.3675C15.3239 15.3537 15.3503 15.3275 15.3503 15.2792L15.3501 7.75823C15.3464 7.31638 15.2633 6.2232 13.4352 6.2232ZM13.6542 8.90741C13.8608 8.90741 14.0284 9.07991 14.0284 9.29245C14.0284 9.50498 13.8608 9.67748 13.6542 9.67748H10.0027C9.79608 9.67748 9.62842 9.50498 9.62842 9.29245C9.62842 9.07991 9.79608 8.90741 10.0027 8.90741H13.6542Z"
                                                                                                                    fill="#97A6A8" />
                                                                                                            </svg>
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="img">
                                                                                                            <svg width="22"
                                                                                                                height="23"
                                                                                                                viewBox="0 0 22 23"
                                                                                                                fill="none"
                                                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                                                <path
                                                                                                                    d="M21.6165 11.0718C21.6165 16.9449 16.8568 21.7059 10.9856 21.7059C5.11438 21.7059 0.354668 16.9449 0.354668 11.0718C0.354668 5.19864 5.11438 0.437676 10.9856 0.437676C16.8568 0.437676 21.6165 5.19864 21.6165 11.0718Z"
                                                                                                                    stroke="#97A6A8"
                                                                                                                    stroke-width="0.625351" />
                                                                                                                <g
                                                                                                                    clip-path="url(#clip0_5482_20425)">
                                                                                                                    <path
                                                                                                                        d="M8.73578 10.7849C8.53554 10.4252 8.15149 10.1819 7.71062 10.1819C7.06305 10.1819 6.53809 10.7068 6.53809 11.3544C6.53809 12.002 7.06305 12.5269 7.71062 12.5269C8.15149 12.5269 8.53554 12.2836 8.73578 11.924M8.73578 10.7849C8.82967 10.9535 8.88315 11.1477 8.88315 11.3544C8.88315 11.5611 8.82967 11.7553 8.73578 11.924M8.73578 10.7849L13.7207 8.01551M8.73578 11.924L13.7207 14.6933M13.7207 14.6933C13.6268 14.862 13.5733 15.0562 13.5733 15.2629C13.5733 15.9104 14.0982 16.4354 14.7458 16.4354C15.3934 16.4354 15.9184 15.9104 15.9184 15.2629C15.9184 14.6153 15.3934 14.0903 14.7458 14.0903C14.3049 14.0903 13.9209 14.3336 13.7207 14.6933ZM13.7207 8.01551C13.9209 8.37518 14.3049 8.6185 14.7458 8.6185C15.3934 8.6185 15.9184 8.09354 15.9184 7.44597C15.9184 6.7984 15.3934 6.27344 14.7458 6.27344C14.0982 6.27344 13.5733 6.7984 13.5733 7.44597C13.5733 7.65267 13.6268 7.84688 13.7207 8.01551Z"
                                                                                                                        stroke="#97A6A8"
                                                                                                                        stroke-width="0.938027"
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round" />
                                                                                                                </g>
                                                                                                                <defs>
                                                                                                                    <clipPath
                                                                                                                        id="clip0_5482_20425">
                                                                                                                        <rect
                                                                                                                            width="12.507"
                                                                                                                            height="12.507"
                                                                                                                            fill="white"
                                                                                                                            transform="translate(4.97461 5.10156)" />
                                                                                                                    </clipPath>
                                                                                                                </defs>
                                                                                                            </svg>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td> --}}
                                                                                            <td class="text viewText" style="background-color: #43D0DF !important; color: #000; border: none; border-radius: 50px; text-align: center !important; padding: 8px 5px;">
                                                                                                <a href="https://www.myspurr.net/job-details/{{ $job->slug }}"
                                                                                                    target="_blank">VIEW
                                                                                                    JOB</a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="btn btn-primary">
                                                <a href="https://www.myspurr.net/jobs" target="_blank">see more jobs</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <table class="footerTable">
                                            <tr>
                                                <td class="text1">
                                                    <h3>
                                                        Want to be in the know with all the latest happenings on
                                                        MySpurr?
                                                    </h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text2">
                                                    Join our telegram group channel to stay updated on new jobs
                                                    available.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text3">
                                                    <div class="btn btn-primary">
                                                        <a href="https://t.me/+tT1PkFVhBnA0NWVk" target="_blank">
                                                            Join Telegram
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="links">
                                                <td>
                                                    <p>
                                                        <a target="_blank"
                                                            href="https://www.instagram.com/myspurr/">Instagram</a>
                                                        <a style="padding-left: 10px;" target="_blank"
                                                            href="https://facebook.com/usemyspurr">Facebook</a>
                                                        <a style="padding-left: 10px;" target="_blank"
                                                            href="https://www.linkedin.com/company/usemyspurr/">LinkedIn</a>
                                                        <a style="padding-left: 10px;" target="_blank"
                                                            href="https://twitter.com/usemyspurr">X (formerly
                                                            twitter)</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>

</html>
