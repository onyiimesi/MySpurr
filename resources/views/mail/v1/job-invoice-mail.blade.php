<!Doctype html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
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

            .table3 .col1,
            .table4 .col1,
            .table6 .col1 {
                width: 30% !important;
            }

            .table3 .col2,
            .table4 .col2,
            .table6 .col2 {
                width: 70% !important;
            }

            .table4 {
                margin-top: 51.67px !important;
            }

            .table3,
            .table4,
            .table5,
            .table6,
            .table7 {
                width: 95% !important;
                margin-left: auto !important;
                margin-right: auto !important;
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
            padding: 42px 30px 24.07px;
        }

        .table2 {
            background: #007582;
            height: 26px;
            margin-bottom: 47px;
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

        .table4 {
            margin-top: 78.55px;
            margin-bottom: 31.67px;
        }

        .table3 tr {
            width: 100%;
        }

        .table3 .col1,
        .table3 .col2,
        .table4 .col1,
        .table4 .col2,
        .table6 .col1,
        .table6 .col2 {
            width: 50%;
            vertical-align: top !important;
        }

        .table3 p,
        .table4 .col1,
        .table4 .col2,
        .table7 p {
            color: #000;
            font-feature-settings: 'clig' off, 'liga' off;
            font-family: Satoshi;
            font-size: 11.181px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
        }

        .table4 .head,
        .table4 .key {
            font-weight: 500;
        }

        .table3 .col2,
        .table4 .col2 .tableBody,
        .table6 .col2 {
            text-align: right;
        }

        .table4 .col2 .key {
            text-align: left !important;
        }

        .table_center {
            background: #F9F9F9;
        }

        .table5 {
            border-collapse: collapse;
            margin-bottom: 22.525px;
        }

        .table5 thead td {
            border: 0.2px solid rgba(37, 64, 53, 0.67);
            background: #FFFFFD;
            padding: 8.75px;
            color: #000;
            font-family: Satoshi;
            font-size: 10.25px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }

        .table5 .top-row td {
            padding: 24.065px 8.75px 0;
        }

        .table5 tbody td,
        .table6 td {
            color: #1B1B1B;
            font-family: Satoshi;
            font-size: 9.84px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            letter-spacing: -0.177px;
        }

        .table6 td {
            padding-bottom: 14.02px;
        }

        /* .table6 .col2 {
        padding-right: 4px;
      } */

        .table6 hr {
            /* border: 0.5px solid #1B1B1B; */
            /* border-color: #1B1B1B; */
            width: 100%;
        }

        .no_padding {
            padding-bottom: 0 !important;
        }

        .padding_right {
            padding-right: 4px;
        }

        .balance_table {
            border-radius: 8.843px;
            border: 1px solid rgba(37, 64, 53, 0.67);
            background: #E6F1F3;
            padding: 8.75px 5px;
        }

        .balance_table .align-left {
            font-weight: 700;
        }

        .table7 {
            margin-top: 71.19px;
            margin-bottom: 119px
        }

        .table7 p {
            margin-bottom: 30px;
        }

        .table3,
        .table4,
        .table5,
        .table6,
        .table7 {
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .table4 .head .tableBody {
            font-weight: 400;
        }
    </style>
</head>

<body>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">
                    <table class="main" role="presentation">
                        <tr>
                            <td class="table_center">
                                <table class="table1">
                                    <tr>
                                        <td class="row1">
                                            <!-- myspurrr_logo_dark -->
                                            <img src="https://backend-api.myspurr.net/public/logo/logo.png"
                                                alt="">
                                        </td>
                                    </tr>
                                </table>
                                <table class="table2">

                                </table>
                                <table class="table3">
                                    <tr>
                                        <td class="col1">
                                            <p>Order ID:</p>
                                            <p>{{ $payment->reference }}</p>
                                        </td>
                                        <td class="col2">
                                            <p>Trigon Media Limited Company</p>
                                            <p>Plot 228. 1(R), 32 Road FHA, Lugbe FCT Abuja</p>
                                            <p>VAT. 24074249-0001</p>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table4">
                                    <tr>
                                        <td class="col1">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <p class="head">Billed to:</p>
                                                        <p>{{ $user->business_name }}</p>
                                                        <p>{{ $user->phone_number }}</p>
                                                        <p>{{ $user->location }}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="col2">
                                            <table>
                                                <thead>
                                                    <tr class="head">
                                                        <th class="key">Date:</th>
                                                        <th class="tableBody">{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableBody">
                                                    <tr>
                                                        <td class="key">Order Total:</td>
                                                        <td>₦{{ $payment->amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">Payment Method:</td>
                                                        <td>{{ $payment->channel }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">Receipt #:</td>
                                                        <td>{{ $payment->reference }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table5">
                                    <thead>
                                        <tr>
                                            <td class="align-center">Item</td>
                                            <td>Description</td>
                                            <td class="align-center">Quantity</td>
                                            <td class="align-center">Rate</td>
                                            <td class="align-center">Price</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="top-row">
                                            <td class="align-center">1</td>
                                            <td>{{ $job->job_title }}</td>
                                            <td class="align-center">1</td>
                                            <td class="align-center">0.00</td>
                                            <td class="align-right">₦{{ $payment->amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table6">
                                    <tr>
                                        <td class="col1"></td>
                                        <td class="col2">
                                            <table>
                                                <tr>
                                                    <td class="no_padding padding_right">
                                                        <table>
                                                            <tr>
                                                                <td class="align-left">Total Purchases</td>
                                                                <td>₦{{ $payment->amount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-left">VAT (0%)</td>
                                                                <td></td>
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
                                                    <td class="no_padding padding_right">
                                                        <table>
                                                            <tr>
                                                                <td class="align-left">Order Total:</td>
                                                                <td>₦{{ $payment->amount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-left">Payment:</td>
                                                                <td>₦{{ $payment->amount }}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="balance_table">
                                                            <tr>
                                                                <td class="align-left no_padding"> Balance:</td>
                                                                <td class="no_padding">₦0.00</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table7">
                                    <tr>
                                        <td>
                                            <p>© 2024 Trigon Media Limited. MySpurr, the MySpurr logo, are registered
                                                trademarks of Trigon Media Limited in Nigeria and/or other countries.
                                                All rights reserved.</p>
                                            <p>This email was intended for [Business Name] If you need assistance or
                                                have questions, please contact MySpurr Customer Service.</p>
                                            <p>MySpurr is a registered trade mark of Trigon Media Limited. Registered in
                                                Abuja Nigeria as a limited liability company , Company Number 1866752.
                                                Registered Office: Plot 228. 1(R), 32 Road FHA, Lugbe FCT Abuja</p>
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
