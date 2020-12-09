<?php

namespace App\Http\Controllers;

use \App\returned_book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Gate::allows('rolePetugas')) {
                return $next($request);
            }
            abort(403);
        });
    }
    public function indexAllExport()
    {
        return \view('export.index');
    }

    public function allExportBorrowReturnBook(Request $request)
    {
        $export_all = returned_book::with('users')->with('books')->with('borrows')->get();
        if ($export_all->count() > 0) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode('Rekap_pinjam_dan_pengembalian_buku'.date("_Y_m_d_H_i_s").'.xlsx').'"');
            $excel = new Spreadsheet();
            $sheet = $excel->getActiveSheet();
            $sheet->setCellValue('A2', 'Rekap pinjam dan pengembalian buku '.date("Y-m-d H:i:s"));
            $sheet->setCellValue('A5', "NO");
            $sheet->setCellValue('B5', "Kode Buku");
            $sheet->setCellValue('C5', "Judul Buku");
            $sheet->setCellValue('D5', "Peminjam");
            $sheet->setCellValue('E5', "Status Pinjam");
            $sheet->setCellValue('F5', "Tanggal Pinjam");
            $sheet->setCellValue('G5', "Tanggal Kembali");
            $row = 5;
            $no = 0;
            foreach ($export_all as $export) {
                $row++;
                $no++;
                $sheet->setCellValue('A'.$row, $no);
                $sheet->setCellValue('B'.$row, $export->books->id);
                $sheet->setCellValue('C'.$row, $export->books->title);
                $sheet->setCellValue('D'.$row, $export->users->name);
                $sheet->setCellValue('E'.$row, $export->status_return);
                $sheet->setCellValue('F'.$row, $export->borrows->borrow_date);
                $sheet->setCellValue('G'.$row, $export->return_date);
            }
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
            $sheet->getStyle('A5:G5')->getAlignment()->setHorizontal('center');//aligment text,rata tengah
        $sheet->getStyle('A5:G5')->getAlignment()->setVertical('center');//aligment text,rata tengah
        // $sheet->getStyle('A5:G5')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);//font color
        $sheet->getStyle('A5:G5')->getFont()->setBold(true);//bold font
        $sheet->getStyle('A5:G5')->getFont()->setSize(13);//font size
        $sheet->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D3D3D3');//background
        $sheet->getStyle('A5:G'.$row)->applyFromArray($styleArray);//border
        $writer = new Xlsx($excel);
            $writer->save('php://output');
        } else {
            return \redirect()->route('index.export.excel')->with('status_export_all', 'Data for export excel missing / empty!');
        }
    }
}
