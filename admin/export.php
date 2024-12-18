<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

include '../config/config.php';
$connect = mysqli_connect("localhost", "root", "", "v_shop");

$status = $_POST['status'];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'ID đơn hàng');
$sheet->setCellValue('B1', 'Mã sản phẩm');
$sheet->setCellValue('C1', 'Tên sản phẩm');
$sheet->setCellValue('D1', 'Số lượng');
$sheet->setCellValue('E1', 'Giá tiền');
$sheet->setCellValue('F1', 'Mã khách hàng');
$sheet->setCellValue('G1', 'Trạng thái');
$sheet->setCellValue('H1', 'Thời gian');

$query = "SELECT * FROM tbl_order WHERE status = '$status' ORDER BY date_order DESC";
$result = mysqli_query($connect, $query);

$data = [];

while ($row_data = mysqli_fetch_assoc($result)) {
    $date_order = $row_data['date_order'];
    if (!isset($data[$date_order])) {
        $data[$date_order] = [
            'id' => $row_data['id'],
            'productId' => $row_data['productId'],
            'productName' => $row_data['productName'],
            'quantity' => $row_data['quantity'],
            'price' => $row_data['price'],
            'customer_id' => $row_data['customer_id'],
            'status' => $row_data['status'],
            'date_order' => $row_data['date_order']
        ];
    } else {
        $data[$date_order]['id'] .= ', ' . $row_data['id'];
        $data[$date_order]['productId'] .= ', ' . $row_data['productId'];
        $data[$date_order]['productName'] .= ', ' . $row_data['productName'];
        $data[$date_order]['quantity'] .= ', ' . $row_data['quantity'];
        $data[$date_order]['price'] .= ', ' . $row_data['price'];
        $data[$date_order]['customer_id'] .= ', ' . $row_data['customer_id'];
        $data[$date_order]['status'] .= ', ' . $row_data['status'];
    }
}

$row = 2;
foreach ($data as $row_data) {
    $sheet->setCellValue('A' . $row, $row_data['id']);
    $sheet->setCellValue('B' . $row, $row_data['productId']);
    $sheet->setCellValue('C' . $row, $row_data['productName']);
    $sheet->setCellValue('D' . $row, $row_data['quantity']);
    $sheet->setCellValue('E' . $row, $row_data['price']);
    $sheet->setCellValue('F' . $row, $row_data['customer_id']);
    $sheet->setCellValue('G' . $row, $row_data['status']);
    $sheet->setCellValue('H' . $row, $row_data['date_order']);
    $sheet->getStyle('A' . $row . ':H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $row++;
}

foreach (range('A', 'H') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="orders.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
