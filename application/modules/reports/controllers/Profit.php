<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Profit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("sistem_model");
        $this->load->model("Profit_report_model");
        $this->loginCheck();
    }

    public function index()
    {
        $this->load->view("v_report_profit");
    }

    public function getTransctions()
    {
        $list = $this->Profit_report_model->_getDatatables();

        // SELECT t.id as trans_id, t.transaction_date as cash_date,
        // t.invoice, t.total as debet, 'TRANSAKSI' as keterangan, NULL as kredit, t.users_id as
        // users_id FROM transactions t WHERE t.status = 'SUCCESS' AND t.transaction_date BETWEEN '2021-09-21 00:00:00' AND '2021-09-21 23:59:59' AND t.users_id = 1
        // UNION ALL SELECT NULL as trans_id,
        // i.date as cash_date, NULL, i.total as debet, UPPER(i.description) as keterangan, NULL as kredit,
        // NULL FROM incomes i UNION ALL SELECT NULL as trans_id, e.date as cash_date, NULL, NULL as debet,
        // UPPER(e.description) as keterangan, e.total as kredit, NULL FROM expenditures e ORDER BY cash_date DESC

        foreach ($list as &$value) {
            $this->db->select(
                'transaction_details.quantity, transaction_details.discount, transaction_details.price, transaction_details.stock_ins_id,
        transaction_details.sub_total, products.name, products.capital_price, product_categories.category_name,'
            );
            $this->db->from("transaction_details");
            $this->db->join(
                "transactions",
                "transactions.id = transaction_details.transactions_id"
            );
            $this->db->join(
              "stock_ins",
              "transaction_details.stock_ins_id = stock_ins.id"
            );
            $this->db->join(
                "products",
                "stock_ins.products_id = products.id"
            );
            $this->db->join(
                "product_categories",
                "products.product_categories_id = product_categories.id"
            );
            $this->db->where("transaction_details.transactions_id", $value->id);
            $value->transaction_details = $this->db->get()->result();
        }

        $result = [];
        for ($i = 0; $i < count($list); $i++) {
            $result[] = $list[$i];
        }

        $data = [];
        $no = $_POST["start"];
        $draw = $_POST["draw"];

        $totalSalesAll = 0;
        $totalCapitalAll = 0;
        $totalDiscountAll = 0;

        foreach ($result as $value) {
            $totalSales = 0;
            $totalCapital = 0;
            $totalDiscount = 0;

            foreach ($value->transaction_details as $detailRows) {
                $totalSalesDetail = $detailRows->price * $detailRows->quantity;
                $totalCapitalDetail =
                    $detailRows->capital_price * $detailRows->quantity;

                $totalSales += $totalSalesDetail;
                $totalCapital += $totalCapitalDetail;
                $totalDiscount += $detailRows->discount;

                $totalSalesAll += $detailRows->sub_total;
                $totalCapitalAll += $totalCapitalDetail;
            }
            $totalDiscountAll += $totalDiscount;

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->transaction_date;
            $row[] =
                '<span class="label label-primary">' .
                $value->invoice .
                "</span>";
            $row[] = $this->getTransactionDetail($value->transaction_details);
            $row[] = "Rp. " . number_format($totalSales, 0, ".", ".") . ",-";
            $row[] = "Rp. " . number_format($totalCapital, 0, ".", ".") . ",-";
            $row[] = "Rp. " . number_format($totalDiscount, 0, ".", ".") . ",-";
            $row[] =
                "Rp. " .
                number_format(
                    $totalSales - $totalCapital - $totalDiscount,
                    0,
                    ".",
                    "."
                ) .
                ",-";
            $data[] = $row;
        }

        $output = [
            "totalSalesAll" => $totalSalesAll,
            "totalCapitalAll" => $totalCapitalAll,
            "totalDiscountAll" => $totalDiscountAll,
            "draw" => $draw,
            "recordsTotal" => $this->Profit_report_model->_countAll(),
            "recordsFiltered" => $this->Profit_report_model->_countFiltered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }

    private function getTransactionDetail($attr)
    {
        $record = "";
        foreach ($attr as $detailRows) {
            $totalSalesDetail = $detailRows->price * $detailRows->quantity;
            $totalCapitalDetail =
                $detailRows->capital_price * $detailRows->quantity;

            $record .=
                '<div style="padding-bottom:0px;"><table class="table w-100" style="font-size:12px;pointer-events:none; margin-bottom: 3px;"><tbody><tr>';
            // $record .= '<td style="width:10px; border-bottom:1px solid #ccc; padding: 3px 3px 5px 3px"><label class="label bg-maroon">' . $detailRows->quantity . '</label></td>';
            $record .=
                '<td style="padding: 5px 3px 5px 3px;border-bottom:1px solid #ccc;">' .
                strtoupper($detailRows->name) .
                " (" .
                strtoupper($detailRows->category_name) .
                ') <span style="width:10px; border-bottom:1px solid #ccc; padding: 3px 7px;" class="label bg-maroon">' .
                $detailRows->quantity .
                "</span></td>";
            $record .=
                '<td style="padding: 5px 3px 5px 3px;text-align:right;border-bottom:1px solid #ccc;">';
            $record .=
                "Rp. " .
                number_format(floatval($totalSalesDetail), 0, ".", ".") .
                " - ";
            $record .=
                "Rp. " .
                number_format(floatval($totalCapitalDetail), 0, ".", ".") .
                " = ";
            $record .=
                "Rp. " .
                number_format(
                    floatval($totalSalesDetail - $totalCapitalDetail),
                    0,
                    ".",
                    "."
                );
            $record .= "</td></tr>";
            $record .= "</tbody></table></div>";
        }
        return $record;
    }
}
