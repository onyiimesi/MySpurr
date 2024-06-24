<!doctype html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title></title>
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
      font-family: 'Satoshi', sans-serif !important;
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
      font-family: 'Satoshi', sans-serif !important;
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
      font-family: 'Satoshi', sans-serif !important;
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
      font-family: 'Satoshi', sans-serif !important;
    }

    p,
    ul,
    ol {
      font-family: 'Satoshi', sans-serif !important;
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
      font-family: 'Satoshi', sans-serif !important;
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

      .jobDescription {
        width: 100% !important;
      }

      .table6 {
        width: 95% !important;
      }

      .certificateList {
        width: 100% !important;
      }

      .adsMain {
        width: 100% !important;
        padding: 10px !important;
      }

      .table2 {
        padding: 12px 20px !important;
      }

      .topImg .img {
        width: 20% !important;
      }

      .table4 .salary {
        margin-bottom: 5px !important;
      }

      .table5 .text h4 {
        width: auto !important;
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



      .adsMain .company,
      .adsMain .role {
        font-size: 14px !important;
        margin-bottom: 0 !important;
      }

      .adsMain .workTime {
        font-size: 10px !important;
      }

      .text .img img,
      .table4 .img img {
        width: 15.531px !important;
        height: 15.531px !important;
      }

      .col1 .text {
        font-size: 11px;
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
      font-family: 'Satoshi', sans-serif !important;
      font-size: 14px;
      font-style: normal;
      font-weight: 400;
    }

    a {
      color: #000;
      font-style: normal;
      font-family: 'Satoshi', sans-serif !important;
      font-weight: 500;
      text-decoration: none;
      line-height: 0;
      color: inherit;
      width: 100%;
    }

    h3,
    .footerTable .text2 {
      font-family: 'Satoshi', sans-serif !important;
      font-style: normal;
    }

    .table2 h3 {
      color: #FFF;
      font-feature-settings: 'clig' off, 'liga' off;
      font-size: 19px;
      font-weight: 700;
      line-height: 45.088px;
    }

    .footerTable {
      padding: 22px 30px;
      margin: 0 0 40px;
    }

    .footerTable .text1 h3 {
      color: var(--Foundation-Body-B400, #011B1F);
      font-size: 14px;
      font-weight: 500;
      line-height: 23px;
      /* 115% */
      margin-bottom: 15px;
    }

    .footerTable .text2 {
      color: #000;
      font-feature-settings: 'clig' off, 'liga' off;
      font-size: 14px;
      font-weight: 400;
      line-height: 19px;

    }

    .footerTable .btn {
      width: 50%;
      margin-top: 34px;
      margin-bottom: 45px;
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

    .adsMain {
      width: 100%;
      margin: 0 auto;
      border-radius: 6.254px;
      border: 0.625px solid rgba(37, 64, 53, 0.67);
      background: #FFFFFD;
      padding: 18px;
      margin-bottom: 31px;
    }

    .applied .adsMain {
      margin: 20px 0;
      width: 100%;
    }

    .adsContainer {
      margin-bottom: 54px;
    }

    .adsContainer h3 {
      margin: 0;
    }

    .img {
      width: 15%;
      vertical-align: top;
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
      padding-left: 10px;
      padding-top: 10px;
    }

    .img img {
      width: 100%;
      height: 100%;
    }

    .text .img img,
    .table4 .img img {
      width: 11.531px;
      height: 11.531px;
      vertical-align: middle;
    }

    .adsMain .company {
      color: var(--Secondary-S400, #2F929C);
      font-family: 'Satoshi', sans-serif !important;
      font-size: 15.38px;
      font-style: normal;
      font-weight: 500;
      line-height: 15.634px;
      /* margin-bottom: 7px; */
    }

    .adsMain .role {
      color: #000;
      font-feature-settings: 'clig' off, 'liga' off;
      font-family: 'Satoshi', sans-serif !important;
      font-size: 12.6px;
      font-style: normal;
      font-weight: 500;
      line-height: 12.653px;
      /* margin-bottom: 15px; */
    }

    .adsMain .workTime {
      margin-bottom: 0;
      color: var(--Foundation-danger-D300, #DA5252);
      font-feature-settings: 'clig' off, 'liga' off;
      font-family: 'Satoshi', sans-serif !important;
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
      font-family: 'Satoshi', sans-serif !important;
      font-size: 15.008px;
      font-style: normal;
      font-weight: 500;
      line-height: 23.284px;
      /* 155.142% */
      /* margin-bottom: 4px; */
    }

    .table4 .img {
      height: 100%;
      width: 12px;
      vertical-align: middle;
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
      font-family: 'Satoshi', sans-serif !important;
      font-size: 10.992px;
      font-style: normal;
      font-weight: 700;
      line-height: 26.575px;
    }

    .col2 p {
      width: 70%;
      margin-left: auto;
      color: #000;
      text-align: center;
      font-family: 'Satoshi', sans-serif !important;
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

    .table5 .text {
      padding: 0;
      vertical-align: center;
    }

    .table5 .text a,
    .table5 .text h4 {
      margin: 0;
      width: 50%;
      text-align: center;
      font-size: 10.504px;
      line-height: 11.882px;
      /* 158.333% */
      letter-spacing: 0.625px;
      text-transform: uppercase;
      border-radius: 10.631px;
      background: #43D0DF;
      padding: 9px 21px;
    }

    .table5 .text a:hover {
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

    .table6 {
      width: 90%;
      margin: 29px auto;
    }

    .card {
      border-radius: 6.965px;
      border: 0.464px solid #F6F6F6;
      background: #E9FAFB;
      padding: 21px 26px;
    }

    .card .text {
      padding-left: 10px;
      padding-top: 10px;
    }

    .card h3 {
      color: #244034;
      font-size: 16.404px;
      font-weight: 500;
      line-height: 24.968px;
      /* 173.333% */
      margin-bottom: 10px;
    }

    .card .role {
      color: rgba(0, 0, 0, 0.40);
      font-family: 'Satoshi', sans-serif !important;
      font-size: 12.54px;
      font-style: normal;
      font-weight: 400;
      line-height: 10.028px;
      /* 153.333% */
    }

    .card .roleDetails {
      margin-bottom: 7px;
    }

    .card .roleDetails a {
      color: #244034;
      font-size: 11.104px;
      font-weight: 500;
      line-height: 11.336px;
      /* 185.714% */
      padding-right: 7px;
      cursor: text;
    }

    .pseudoLinks {
      vertical-align: middle;
    }

    .pseudoLinks img {
      width: 15px;
      height: 15px;
      margin-right: 5px;
    }

    .card .profiles {
      margin: 0 0 10px;
    }

    .btn {
      color: #FFF;
      text-align: center;
      font-family: 'Satoshi', sans-serif !important;
      font-size: 10.47px;
      font-style: normal;
      font-weight: 500;
      line-height: 4.47px;
      /* 100% */
      letter-spacing: -0.149px;
      padding: 8px 18px;
      border-radius: 15px;
      background: #31795A;
    }

    .table7 {
      width: 90%;
      margin: 30px auto;
    }

    .table7 h3 {
      color: #000;
      font-size: 13.382px;
      font-weight: 500;
      line-height: 12.918px;
      /* 175% */
    }

    .table7 .profileSummary {
      color: rgba(0, 0, 0, 0.75);
      font-size: 14px;
      font-weight: 400;
      line-height: 24.227px;
      /* 153.788% */
      margin: 5px 0 40px;
      text-align: justify;
    }

    .table7 #downloadBtn {
      padding: 8px 25px;
      margin-top: 30px;
    }



    .certificates h3 {
      margin: 50px 0 30px;
    }

    .certificateList {
      background: #E9FAFB;
      padding: 15px 20px;
    }

    .cert .img {
      vertical-align: top;
    }

    .certificateList .text {
      padding-left: 10px;
    }

    .certificates .course {
      color: #000;
      font-size: 14.745px;
      font-weight: 500;
      line-height: 8.7px;
      /* 183.333% */
      margin-bottom: 15px;
    }

    .certificates .host {
      color: #31795A;
      font-size: 13.691px;
      font-weight: 500;
      line-height: 7.909px;
      /* 214.286% */
      margin-bottom: 15px;
    }

    .cert {
      margin-bottom: 35px;
    }

    .status {
      width: auto;
    }

    .checkLogo {
      vertical-align: middle;
    }

    .checkLogo img {
      width: 15px;
      height: 15px;
    }

    .status .year {
      color: #000;
      font-family: 'Satoshi', sans-serif !important;
      font-size: 10.401px;
      font-style: normal;
      font-weight: 500;
      line-height: 6.235px;
      /* 183.333% */
      vertical-align: middle;
    }

    .certificates .btn {
      width: 100%;
      padding: 15px;
      margin-top: 20px;
    }

    .attachedFiles .title {
      color: #000;
      font-size: 13.382px;
      font-weight: 500;
      line-height: 12.918px;
      /* 175% */
      margin: 30px 0 10px;
    }

    .attachedFiles img {
      width: 100%;
      height: 100%;
    }

    .table6 .row3 .btn {
      background: #43D0DF;
      width: 70%;
      margin: 40px auto 70px;
      padding: 20px;
      border-radius: 20px;
      cursor: pointer;
    }

    .table8 {
      width: 100%;
      padding: 22px 30px;
      background: #DA5252;
      margin-bottom: 90px;
    }

    .table8 .topText {
      color: var(--Foundation-warning-W50, #F0F6EB);
      font-size: 16.4px;
      font-weight: 700;
      line-height: 20.219px;
      /* 97.933% */
      margin-bottom: 20px;
    }

    .table8 a {
      color: #FFF;
      font-feature-settings: 'clig' off, 'liga' off;
      font-size: 12px;
      font-weight: 700;
      line-height: 15.006px;
      /* 155.142% */
      text-decoration-line: underline;
    }

    .table8 .btm p {
      color: var(--Secondary-S50, #ECFAFC);
      font-feature-settings: 'clig' off, 'liga' off;
      font-size: 10.804px;
      font-weight: 400;
      line-height: 15.739px;
    }

    .jobDescription {
      width: 70%;
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
                      <!-- MySpurr_logo_dark image -->
                      <img src="https://backend-api.myspurr.net/public/logo/logo.png" alt="">
                    </td>
                  </tr>
                </table>
                <table class="table2">
                  <tr>
                    <td>
                      <p>
                        Dear {{ $business->first_name }} {{ $business->last_name }},
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h3>Your job has a new applicant</h3>
                    </td>
                  </tr>
                  <tr class="singleAdsContainer applied">
                    <td>
                      <table class="adsMain">
                        <tr>
                          <td>
                            <table>
                              <tr class="topImg">
                                @php
                                    $image = $business->company_logo !== null ? $business->company_logo : "https://backend-api.myspurr.net/public/assets/userplaceholder.jpg";
                                @endphp
                                <td class="img">
                                  <img src="{{ $image }}" style="width: 50px; height: 50px; border-radius: 50px;" alt="company logo image">
                                </td>
                                <td class="text">
                                  <table>
                                    <tr>
                                      <td>
                                        <h3 class="company">{{ $business->business_name }}</h3>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <h3 class="role">{{ $job->job_title }}</h3>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <table class="jobDescription">
                                          <tr>
                                            <td class="data">
                                              <table>
                                                <tr class="row">
                                                  <td class="img time">
                                                    <!-- calendar img -->
                                                    <img src="https://backend-api.myspurr.net/public/assets/calendar.png" style="width: 100%; height: 100%;" alt="">
                                                  </td>
                                                  <td class="workTime">
                                                    {{ \Carbon\Carbon::parse($job->created_at)->format('d M Y') }}
                                                  </td>
                                                </tr>
                                              </table>
                                            </td>
                                            <td class="data">
                                              <table>
                                                <tr class="row">
                                                  <td class="img location">
                                                    <!-- location img -->
                                                    <img src="https://backend-api.myspurr.net/public/assets/location_on.png" style="width: 100%; height: 100%;" alt="">
                                                  </td>
                                                  <td class="workTime">
                                                    Work from anywhere
                                                  </td>
                                                </tr>
                                              </table>
                                            </td>
                                            <td class="data">
                                              <table>
                                                <tr class="row">
                                                  <td class="img schedule">
                                                    <!-- timer image -->
                                                    <img src="https://backend-api.myspurr.net/public/assets/timer.png" style="width: 100%; height: 100%;" alt="">
                                                  </td>
                                                  <td class="workTime">
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
                                  <p class="salary">&#x20A6;{{ number_format($job->salary_min) }}-&#x20A6;{{ number_format($job->salary_max) }}/{{ $job->salaray_type }} </p>
                                  <p>
                                  <table>
                                    <tr>
                                      <td class="img">
                                        <!-- verified_icon -->
                                        <img src="https://backend-api.myspurr.net/public/assets/verified.jpg" alt="">
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
                                <td class="col2">
                                  <p>
                                    {{ $job->job_type }}
                                  </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>

                    </td>
                  </tr>
                </table>
                <table class="table6">
                  <tr>
                    <td>
                      <table class="card">
                        <tr>
                            @php
                                $image = $talent->image !== null ? $talent->image : "https://backend-api.myspurr.net/public/assets/userplaceholder.jpg";
                            @endphp
                          <td class="img">
                            <img src="{{ $image }}" style="width: 50px; height: 50px; border-radius: 50px;" alt="applicant profile image">
                          </td>
                          <td class="text">
                            <table>
                              <tr>
                                <td>
                                  <h3>{{ $talent->first_name }} {{ $talent->last_name }}'s Application</h3>
                                  <p class="role">{{ $talent->skill_title }}</p>
                                  <p class="pseudoLinks roleDetails">
                                    <a href="">
                                        &#x20A6;{{ number_format($job->salary_min) }} - &#x20A6;{{ number_format($job->salary_max) }}/{{ $job->salaray_type }}
                                    </a>
                                    <a href="">{{ $talent->location }}</a>
                                  </p>
                                </td>
                                <td>

                                  <p class="pseudoLinks profiles">
                                    @if ($talent->linkedin)
                                        <a href="{{ $talent->linkedin }}">
                                            <!-- linkedIn logo -->
                                            <img src="https://backend-api.myspurr.net/public/assets/linkedln.jpg" alt="">
                                        </a>
                                    @endif
                                    @if ($talent->instagram)
                                        <a href="{{ $talent->instagram }}">
                                            <!-- instagram logo -->
                                            <img src="https://backend-api.myspurr.net/public/assets/instagram.jpg" alt="">
                                        </a>
                                    @endif
                                    {{-- <a href="">
                                      <!-- behance logo -->
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"
                                        fill="none">
                                        <path
                                          d="M4.31243 2.83637C4.4992 2.61544 4.61975 2.34463 4.65978 2.05607C4.69981 1.76751 4.65763 1.47332 4.53825 1.20842C4.41887 0.943527 4.22731 0.719045 3.98629 0.561623C3.74528 0.404202 3.46493 0.320451 3.17854 0.320312H1.25427C1.14086 0.320312 1.0321 0.366155 0.951905 0.447755C0.871712 0.529355 0.82666 0.640028 0.82666 0.755428V5.39666C0.82666 5.51206 0.871712 5.62273 0.951905 5.70433C1.0321 5.78593 1.14086 5.83177 1.25427 5.83177H3.32107C3.66406 5.83153 3.99832 5.72183 4.27681 5.51811C4.55529 5.31438 4.76395 5.02691 4.87341 4.69616C4.98288 4.36541 4.98762 4.00806 4.88699 3.67442C4.78635 3.34078 4.58539 3.04767 4.31243 2.83637ZM1.68189 1.19054H3.17854C3.34865 1.19054 3.5118 1.25931 3.63209 1.38171C3.75238 1.50411 3.81996 1.67012 3.81996 1.84322C3.81996 2.01632 3.75238 2.18233 3.63209 2.30473C3.5118 2.42713 3.34865 2.49589 3.17854 2.49589H1.68189V1.19054ZM3.32107 4.96154H1.68189V3.36612H3.32107C3.52899 3.36612 3.7284 3.45016 3.87542 3.59976C4.02244 3.74936 4.10503 3.95227 4.10503 4.16383C4.10503 4.3754 4.02244 4.5783 3.87542 4.7279C3.7284 4.8775 3.52899 4.96154 3.32107 4.96154ZM5.67295 1.19054C5.67295 1.07514 5.718 0.96447 5.7982 0.88287C5.87839 0.80127 5.98715 0.755428 6.10056 0.755428H8.38117C8.49458 0.755428 8.60335 0.80127 8.68354 0.88287C8.76373 0.96447 8.80879 1.07514 8.80879 1.19054C8.80879 1.30594 8.76373 1.41662 8.68354 1.49822C8.60335 1.57982 8.49458 1.62566 8.38117 1.62566H6.10056C5.98715 1.62566 5.87839 1.57982 5.7982 1.49822C5.718 1.41662 5.67295 1.30594 5.67295 1.19054ZM7.24087 2.06077C6.74942 2.06077 6.27811 2.25942 5.9306 2.61302C5.5831 2.96662 5.38788 3.44621 5.38788 3.94627C5.38788 4.44634 5.5831 4.92592 5.9306 5.27952C6.27811 5.63312 6.74942 5.83177 7.24087 5.83177C7.52115 5.83255 7.79787 5.76792 8.04977 5.64286C8.10149 5.61866 8.14794 5.58419 8.18639 5.54148C8.22484 5.49877 8.25453 5.44868 8.27371 5.39414C8.29289 5.33961 8.30117 5.28172 8.29808 5.22388C8.29498 5.16605 8.28056 5.10942 8.25568 5.05733C8.23079 5.00523 8.19593 4.95872 8.15315 4.92051C8.11036 4.8823 8.06051 4.85318 8.00652 4.83483C7.95252 4.81649 7.89547 4.8093 7.83871 4.81369C7.78195 4.81807 7.72662 4.83395 7.67597 4.86038C7.54041 4.92742 7.39159 4.96203 7.24087 4.96154C7.05209 4.96134 6.86723 4.90674 6.70768 4.80407C6.54813 4.7014 6.42041 4.55485 6.33932 4.38139H8.66625C8.77966 4.38139 8.88842 4.33555 8.96862 4.25395C9.04881 4.17235 9.09386 4.06167 9.09386 3.94627C9.0933 3.44638 8.89789 2.96713 8.55051 2.61366C8.20313 2.26018 7.73214 2.06135 7.24087 2.06077ZM6.33932 3.51116C6.42022 3.33754 6.54789 3.19084 6.70748 3.08812C6.86707 2.9854 7.05203 2.93087 7.24087 2.93087C7.42971 2.93087 7.61467 2.9854 7.77426 3.08812C7.93385 3.19084 8.06152 3.33754 8.14242 3.51116H6.33932Z"
                                          fill="black" />
                                      </svg>
                                    </a> --}}
                                    @if ($talent->twitter)
                                        <a href="{{ $talent->twitter }}">
                                            <!-- twitter logo -->
                                            <img src="https://backend-api.myspurr.net/public/assets/twitter.jpg" alt="">
                                        </a>
                                    @endif
                                  </p>
                                  {{-- <a href="" class="btn">Message</a> --}}
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
                      <table class="table7">
                        <tr>
                          <td>
                            <h3>Overview</h3>
                            <p class="profileSummary">
                              {{ $talent->overview }}
                            </p>
                            <a href="https://www.myspurr.net/talent/{{ $talent->first_name }}-{{ $talent->last_name }}/{{ $talent->uuid }}" class="btn" id="downloadBtn">View Profile</a>
                          </td>
                        </tr>
                        <tr class="certificates">
                          <td>
                            <h3>Certificates</h3>
                            <table class="certificateList">
                              <tr class="">
                                <td>
                                  <p class="cert">
                                  <table>
                                    @foreach ($talent['certificates'] as $certificate)
                                        <tr>
                                            <td class="img" style="width: 11px; height: 15px;">
                                            <!-- certificate -->
                                            <img src="https://backend-api.myspurr.net/public/assets/certificate.png" alt="">
                                            </td>
                                            <td class="text">
                                            <p class="course">{{ $certificate->title }}</p>
                                            <p class="host">{{ $certificate->institute }}</p>
                                            <p>
                                            <table class="status">
                                                <tr>
                                                <td class="checkLogo">
                                                    <!-- certificate_date png -->
                                                    <img src="https://backend-api.myspurr.net/public/assets/certificate_date.png" style="width: 8px; height: 8px;" alt="">
                                                </td>
                                                <td class="year">
                                                    {{ $certificate->certificate_year }}
                                                </td>
                                                </tr>
                                            </table>
                                            </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                  </table>
                                  </p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="btn">
                                    <a href="{{ $jobapply->other_file }}" download target="_blank">Download document</a>
                                  </div>
                                </td>
                              </tr>
                            </table>
                            <table class="attachedFiles">
                              <tr>
                                <td>
                                  <p class="title">Relevant File attached</p>
                                  <p>
                                  <table>
                                    <tr>
                                      <td>
                                        <a href="{{ $jobapply->other_file }}">Other file</a>
                                      </td>
                                    </tr>
                                  </table>
                                  </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr class="row3">
                    <td>
                      <div class="btn">
                        <a href="https://app.myspurr.net/applications/{{ $jobapply->slug }}/{{ $jobapply->job_id }}">VIEW APPLICATION</a>
                      </div>
                    </td>
                  </tr>
                </table>
                <table class="table8">
                  <tr>
                    <td>
                      <p class="topText">Looking for more applicants? <br>
                        Upgrade your job listing </p>
                    </td>
                  </tr>
                  <tr>
                    <td class="btm">
                      <a href="" target="_blank">
                        Highlight job listing for $5</a>
                      <p>Highlighted listing have a red tag in the list so they stand our against the others</p>
                    </td>
                  </tr>
                </table>
                <table class="footerTable">
                  <tr class="links">
                    <td>
                      <p>
                        <a target="_blank" href="https://www.instagram.com/myspurr/">Instagram</a>
                        <a style="padding-left: 10px;" target="_blank"
                          href="https://facebook.com/usemyspurr">Facebook</a>
                        <a style="padding-left: 10px;" target="_blank"
                          href="https://www.linkedin.com/company/usemyspurr/">LinkedIn</a>
                        <a style="padding-left: 10px;" target="_blank" href="https://twitter.com/usemyspurr">X (formerly
                          twitter)</a>
                      </p>
                    </td>
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
