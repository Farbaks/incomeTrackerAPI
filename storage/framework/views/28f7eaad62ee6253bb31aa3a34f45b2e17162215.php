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

        @media  only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u~div .email-container {
                min-width: 320px !important;
            }
        }

        /* iPhone 6, 6S, 7, 8, and X */
        @media  only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u~div .email-container {
                min-width: 375px !important;
            }
        }

        /* iPhone 6+, 7+, and 8+ */
        @media  only screen and (min-device-width: 414px) {
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
                        <?php if($type == "quotation"): ?>
                        <h2><strong>QUOTATION</strong></h2>
                        <?php else: ?>
                        <h2><strong>INVOICE</strong></h2>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td valign='middle' style='padding: 10px 20px 10px 20px;'>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left;">
                                    <img src="<?php echo e($user['pictureUrl'] ||null); ?>" style='width:130px;align-items: center;' class='CToWUd'>
                                </td>
                                <td style="text-align: right;">
                                    <p>Date: <?php echo e($job->quotation['quotationDetails']['updated_at']->format('d/m/y')); ?></p>
                                    <?php if($type == "quotation"): ?>
                                    <p>Quotation No: <?php echo e($job->quotation['quotationDetails']['id']); ?></p>
                                    <p>Quotation Validity: <?php echo e($job->quotation['quotationDetails']['quotationValidity']); ?> days</p>
                                    <?php else: ?>
                                    <p>Invoice No: <?php echo e($job->quotation['quotationDetails']['id']); ?></p>
                                    <?php endif; ?>
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
                                    <p>From: <?php echo e($user['companyName']); ?></p>
                                    <p><?php echo e($user['companyAddress']); ?></p>
                                    <p><?php echo e($user['phoneNumber']); ?></p>
                                    <p><?php echo e($user['email']); ?></p>
                                </td>
                                <td style="text-align: right;">
                                    <p>To: <?php echo e($job['contactName']); ?></p>
                                    <p><?php echo e($job['companyName']); ?></p>
                                    <p><?php echo e($job['companyAddress']); ?></p>
                                    <p><?php echo e($job['contactNumber']); ?></p>
                                    <!-- <p>[E-mail]</p> -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php if($type == "quotation"): ?>
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
                                        <?php echo e($job->quotation['quotationDetails']['salesPerson']); ?>

                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        <?php echo e($job->quotation['quotationDetails']['refNumber']); ?>

                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        <?php echo e($job->quotation['quotationDetails']['paymentTerms']); ?>

                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        <?php echo e($job->quotation['quotationDetails']['deliveryDate']); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php endif; ?>
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
                                        Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $job->quotation['items']['itemList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style='width:30px;padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        <?php echo e($loop->index + 1); ?>

                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: left;'>
                                        <?php echo e($item->itemName); ?>

                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: left;'>
                                        <?php echo e($item->UOM); ?>

                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: right;'>
                                        <?php echo e($job->quotation['quotationDetails']['currency']); ?> <?php echo e(number_format($item->unitPrice, 2)); ?>

                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); border: solid 1px rgb(230,230,230);text-align: center;'>
                                        <?php echo e($item->quantity); ?>

                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: right;'>
                                        <?php echo e($job->quotation['quotationDetails']['currency']); ?> <?php echo e(number_format($item->totalPrice, 2)); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: right;'>
                                        <?php echo e($job->quotation['quotationDetails']['currency']); ?> <?php echo e(number_format($job->quotation['quotationDetails']['subTotalJobCost'], 2)); ?>

                                    </td>
                                </tr>
                                <?php $__currentLoopData = $job->quotation['tax']['taxList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:30px;padding: 7px;"></td>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: right;' colspan="4">
                                        <strong><?php echo e($tax->paymentName); ?>:</strong>
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: right;'>
                                        <?php echo e($job->quotation['quotationDetails']['currency']); ?> <?php echo e(number_format($tax->amount, 2)); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $job->quotation['discount']['discountList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:30px;padding: 7px;"></td>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: right;' colspan="4">
                                        <strong><?php echo e($discount->paymentName); ?>:</strong>
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: right;'>
                                        <?php echo e($job->quotation['quotationDetails']['currency']); ?> <?php echo e(number_format($discount->amount, 2)); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:30px;padding: 7px;"></td>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: right;' colspan="4">
                                        <strong>Total:</strong>
                                    </td>
                                    <td style='padding: 7px; background-color: rgb(245,245,245);color: rgb(100,100,100); font-weight: 500; border: solid 1px rgb(230,230,230);text-align: right;'>
                                        <?php echo e($job->quotation['quotationDetails']['currency']); ?> <?php echo e(number_format($job->quotation['quotationDetails']['totalJobCost'], 2)); ?>

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
                                        <?php echo e($job->quotation['quotationDetails']['comment']); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: left;' colspan="4">
                                        Quotation prepared by: <?php echo e($job->quotation['quotationDetails']['salesPerson']); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style='padding: 7px; background-color: rgb(255,255,255);color: rgb(100,100,100); border: none;text-align: left;' colspan="4">
                                        Direct All Inquiries to: <?php echo e($user['email']); ?>

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

</html><?php /**PATH C:\Users\NAMI\Desktop\farouk\laravel\incomeTrackerAPI\resources\views/quotationtemplate1.blade.php ENDPATH**/ ?>