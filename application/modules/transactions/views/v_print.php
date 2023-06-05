<html moznomarginboxes mozdisallowselectionprint>

<head>
    <title>&nbsp;</title>
    <style>
        html {
            font-family: "Verdana";
        }

        .content {
            width: 80mm;
            font-size: 12px;
            padding: 5px;
        }

        .content .title {
            text-align: center;
        }

        .content .head-desc {
            margin-top: 10px;
            display: table;
            width: 100%;
        }

        .content .head-desc>div {
            display: table-cell;
        }

        .content .head-desc .user {
            text-align: right;
        }

        .content .nota {
            text-align: center;
            margin: 5px 0;
        }

        .content .separate {
            margin: 10px 0 15px 0;
            border-bottom: 1px dashed #000;
        }

        .content .transaction-table {
            width: 100%;
            font-size: 12px;
        }

        .content .transaction-table .name {
            width: 185px;
        }

        .content .transaction-table .quantity {
            text-align: center;
        }

        .content .transaction-table .sell-price,
        .content .transaction-table .final-price {
            text-align: right;
            width: 65px;
            padding-right: 5px;
        }

        .content .transaction-table {
            vertical-align: top;
        }

        .content .transaction-table .price-tr td {
            padding: 7px 0 7px 0;
        }

        .content .transaction-table .discount-tr td {
            padding: 7px 0 7px 0;
        }

        .content .transaction-table .separate-line {
            height: 1px;
            border: 1px dashed #000;
        }

        .content .thanks {
            text-align: center;
            margin-top: 15px;
        }

        .content .madtive {
            margin-top: 5px;
            text-align: center;
            font-size: 10px;
        }

        @media print {
            @page {
                width: 80mm;
                margin: 0mm;
            }
        }
    </style>
</head>

<body>
    <div class="content">

        <div class="title">
            <?php
            echo $settings['shop_name'];
            echo "<br>";
            echo $settings['address'];
            ?>
        </div>

        <div class="head-desc">
            <div class="date">
                <?= date('d-m-Y H:i', strtotime($transactions->tanggal_transaksi)) ?>
            </div>
            <div class="user">
                <?= $transactions->nama_kasir ?>
            </div>
        </div>

        <div class="nota">
            <?= $transactions->nota ?>
        </div>

        <div class="separate"></div>

        <div class="transaction">
            <table class="transaction-table" cellspacing="0" cellpadding="0">
                <?php
                $arrDiscount = [];
                foreach ($transactions->transaction_details as $key => $value) {
                    echo "<tr>";
                    echo "<td class='name'>" . $value->name . "</td>";
                    echo "<td class='quantity'>x" . $value->quantity . "</td>";
                    echo "<td class='sell-price'>" . number_format($value->price) . "</td>";
                    echo "<td class='final-price'>" . number_format($value->price * $value->quantity) . "</td>";
                    echo "<tr>";

                    if ($value->discount > 0) {
                        $arrDiscount[] = $value->discount;
                    }
                }

                $calcDiscount = 0;

                foreach ($arrDiscount as $key => $value) {
                    echo '
                        <tr>
                            <td colspan="2"></td>
                            <td class="final-price">Diskon ' . ($key + 1) . '</td>
                            <td class="final-price">' . number_format($value) . '</td>
                        </tr>  
                    ';
                    $calcDiscount += $value;
                }
                ?>

                <tr class="price-tr">
                    <td colspan="4">
                        <div class="separate-line"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="final-price">
                        Total Bayar
                    </td>
                    <td class="final-price">
                        <?= ' Rp.' . number_format($transactions->total + $transactions->total_discount) ?>
                    </td>
                </tr>

                <?php if ($transactions->total_discount > 0) { ?>
                    <tr>
                        <td colspan="3" class="final-price">
                            Diskon (Total)
                        </td>
                        <td class="final-price">
                            <?= 'Rp.' . number_format($transactions->total_discount) ?>
                        </td>
                    </tr>
                <?php } ?>

                <tr class="discount-tr">
                    <td colspan="4">
                        <div class="separate-line"></div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="final-price">
                        TOTAL
                    </td>
                    <td class="final-price">
                        <?= 'Rp.' . number_format($transactions->total) ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="final-price">
                        BAYAR
                    </td>
                    <td class="final-price">
                        <?= 'Rp.' . number_format($transactions->total_bayar) ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="final-price">
                        KEMBALI
                    </td>
                    <td class="final-price">
                        <?= 'Rp.' . number_format($transactions->kembalian) ?>
                    </td>
                </tr>

            </table>
        </div>
        <div class="thanks">
            ~~~ Terima Kasih ~~~
        </div>
        <!-- <div class="madtive">
                www.madtive.com
            </div> -->
    </div>

    <script>
        document.addEventListener("load", () => {
            setTimeout(() => {
                window.print()
            }, 500)
        })
    </script>
</body>

</html>