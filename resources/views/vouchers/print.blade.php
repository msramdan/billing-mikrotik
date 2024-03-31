<!DOCTYPE html>
<html>

<head>
    <title>Voucher-Hotspot</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="pragma" content="no-cache" />
    <link rel="icon" href="../img/favicon.png" />
    <script src="../js/qrious.min.js"></script>
    <style>
        body {
            color: #000000;
            background-color: #FFFFFF;
            font-size: 14px;
            font-family: 'Helvetica', arial, sans-serif;
            margin: 0px;
            -webkit-print-color-adjust: exact;
        }

        table.voucher {
            display: inline-block;
            border: 2px solid black;
            margin: 2px;
        }

        @page {
            size: auto;
            margin-left: 7mm;
            margin-right: 3mm;
            margin-top: 9mm;
            margin-bottom: 3mm;
        }

        @media print {
            table {
                page-break-after: auto
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto
            }

            td {
                page-break-inside: avoid;
                page-break-after: auto
            }

            thead {
                display: table-header-group
            }

            tfoot {
                display: table-footer-group
            }
        }

        #num {
            float: right;
            display: inline-block;
        }

        .qrc {
            width: 30px;
            height: 30px;
            margin-top: 1px;
        }
    </style>
</head>

<body onload="window.print()">
    <style>
        .qrcode {
            height: 80px;
            width: 80px;
        }
    </style>

    <table class="voucher" style=" width: 220px;">
        <tbody>
            <tr>
                <td style="text-align: left; font-size: 14px; font-weight:bold; border-bottom: 1px black solid;"><img
                        src="https://rajabilling.my.id/storage/uploads/logos/a3zGPkSYhP5DCIeaY8BYqYHAjjpuIuD2PObM47sy.png"
                        alt="logo" style="height:30px;border:0;"> SawitSkyLink <span id="num">[1]</span>
                </td>
            </tr>
            <tr>
                <td>
                    <table style=" text-align: center; width: 210px; font-size: 12px;">
                        <tbody>
                            <tr>
                                <td>
                                    <table style="width:100%;">
                                        <tr>
                                            <td style="width: 50%">Username</td>
                                            <td>Password</td>
                                        </tr>
                                        <tr style="font-size: 14px;">
                                            <td style="border: 1px solid black; font-weight:bold;">Ramdangenz</td>
                                            <td style="border: 1px solid black; font-weight:bold;">12345</td>
                                        </tr>
                                    </table>
                                </td>
                            <tr>
                                <td colspan="2" style="border-top: 1px solid black;font-weight:bold; font-size:16px">
                                    Rp.4000</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold; font-size:12px">Login: http://
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>
