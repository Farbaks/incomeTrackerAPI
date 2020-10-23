<!DOCTYPE html>
<html lang='en' xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='x-apple-disable-message-reformatting'>
    <title></title>
    <!-- <link href='https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700' rel='stylesheet'> -->
    <style>
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*='margin: 16px 0'] {
            margin: 0 !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        td {
            font-size: .85em !important;
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u~div .email-container {
                min-width: 320px !important;
            }
        }

        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u~div .email-container {
                min-width: 375px !important;
            }
        }

        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u~div .email-container {
                min-width: 414px !important;
            }
        }
    </style>
    <style>
        .bg_white {
            background: #ffffff;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            /* font-family: 'Poppins', sans-serif; */
            color: rgba(0, 0, 0, .7);
            margin: 2px;
            font-weight: 400;
        }

        body {
            /* font-family: 'Poppins', sans-serif; */
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
        }

        a {
            color: #17bebb;
        }

        /*HERO*/
        .hero {
            position: relative;
            z-index: 0;
        }

        .hero .text {
            color: black;
        }

        .hero .text h2 {
            color: #000;
            font-size: 34px;
            margin-bottom: 0;
            font-weight: 200;
            line-height: 1.4;
        }

        .hero .text h3 {
            font-size: 22px;
            font-weight: 300;
        }

        .hero .text h2 span {
            font-weight: 600;
            color: #000;
        }

        ul.social {
            padding: 0;
        }

        ul.social li {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>

<body width='100%' style='margin: 0; padding: 0 !important; background-color: #f1f1f1;'>
    <center style='width: 100%; background-color: #f1f1f1;'>
        <div style='max-width: 800px; margin: 0 auto;background-color: white !important;' class='email-container'>
            <table align='center' role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%' style='margin: auto;'>
                <tr>
                    <td valign='middle' style='padding: 60px 20px 10px 20px;text-align: right;'>
                        <h2><strong>INVOICE</strong></h2>
                    </td>
                </tr>
                <tr>
                    <td valign='middle' style='padding: 10px 20px 10px 20px;'>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left;">
                                    <img src="{{ asset('storage/avatars/2.jpg') }}" style='width:130px;align-items: center;' class='CToWUd'>
                                </td>
                                <td style="text-align: right;">
                                    <p>Date: [Date]</p>
                                    <p>Quotation No: [#No]</p>
                                    <p>Quotation Validity: [Number of days]</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign='middle' style='padding: 10px 20px 10px 20px;'>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left;">
                                    <p>From: [Company Name]</p>
                                    <p>[Address]</p>
                                    <p>[Phone Number]</p>
                                    <p>[E-mail]</p>
                                </td>
                                <td style="text-align: right;">
                                    <p>To: [Company Name]</p>
                                    <p>[Address]</p>
                                    <p>[Phone Number]</p>
                                    <p>[E-mail]</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign='middle' style='padding: 10px 20px 20px 20px;'>
                        <table style='width: 100%;'>
                            <thead>
                                <tr>
                                    <th style='padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        Sales Person
                                    </th>
                                    <th style='padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        Reference No
                                    </th>
                                    <th style='padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        Payment Terms
                                    </th>
                                    <th style='padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        Delivery Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Faysal Bakre
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        12343214
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        None
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        None
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign='middle' style='padding: 10px 20px 0px 20px;'>
                        <table style='width: 100%;'>
                            <thead>
                                <tr>
                                    <th style='width:30px;padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        S/N
                                    </th>
                                    <th style='padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        Description
                                    </th>
                                    <th style='padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        UOM
                                    </th>
                                    <th style='padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        Unit Price
                                    </th>
                                    <th style='padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        Quantity
                                    </th>
                                    <th style='padding: 7px; background-color: teal;color: white; border-right: solid 1px white;text-align: left;'>
                                        Sub-Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style='width:30px;padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        5
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Metal Pins
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Rods
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 14,000
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        10
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000
                                    </td>
                                </tr>
                                <tr>
                                    <td style='width:30px;padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        5
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Metal Pins
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Rods
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 14,000
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        10
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000
                                    </td>
                                </tr>
                                <tr>
                                    <td style='width:30px;padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        5
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Metal Pins
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Rods
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 14,000
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        10
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000
                                    </td>
                                </tr>
                                <tr>
                                    <td style='width:30px;padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        5
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Metal Pins
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Rods
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 14,000
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        10
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000
                                    </td>
                                </tr>
                                <tr>
                                    <td style='width:30px;padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        5
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Metal Pins
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Rods
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 14,000
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        10
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000
                                    </td>
                                </tr>
                                <tr>
                                    <td style='width:30px;padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        5
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Metal Pins
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        Rods
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 14,000
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        10
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign='middle' style='padding: 0px 20px 40px 20px;'>
                        <table style='width: 100%;'>
                            <tbody>
                                <tr>
                                    <td style="width:30px;padding: 7px;"></td>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: right;' colspan="4">
                                        <strong>Sub Total:</strong>
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30px;padding: 7px;"></td>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: right;' colspan="4">
                                        <strong>VAT:</strong>
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000 (7%)
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30px;padding: 7px;"></td>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: right;' colspan="4">
                                        <strong>Discount:</strong>
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30px;padding: 7px;"></td>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: right;' colspan="4">
                                        <strong>Total:</strong>
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        &#8358; 140,000
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign='middle' style='padding: 0px 20px 40px 20px;'>
                        <table style='width: 100%;'>
                            <tbody>
                                <tr>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: left;' colspan="4">
                                        Quotation prepared by:
                                    </td>
                                </tr>
                                <tr>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: left;' colspan="4">
                                        Direct All Inquiries to: Kismetgate2@yahoo.com
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>
</body>

</html>