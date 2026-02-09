<?php
require_once RUTA_BASE . '/scripts/TCPDF/tcpdf.php';

class pdf extends TCPDF
{
    public function Header()
    {
        $image = K_PATH_IMAGES . 'logo.png';
        $this->Image($image, 10, 10, 20);

        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 15, 'Informe de Productos', 0, 1, 'C');

        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 0, 'Fecha: ' . date('d/m/Y'), 0, 1, 'C');
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(
            0,
            10,
            'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(),
            0,
            0,
            'C'
        );
    }
}