<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

function pdf_create($html, $filename = '', $stream = TRUE, $paper = 'A4', $orientation = 'portrait')
{
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
    } else {
        $ci = &get_instance();
        $ci->load->helper('file');
        write_file($filename, $dompdf->output());
    }
}
?>
