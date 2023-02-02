<?php

namespace App\Exports;

use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class NumberalPdfExport
{
    private static $configFile = [
//        'mode'              => 'utf-8',
        'format'            => 'A3',
        'default_font_size' => 12,
        'default_font'      => 'Times New Roman',
        'margin_left'       => 5,
        'margin_right'      => 5,
        'margin_top'        => 5,
        'margin_bottom'     => 1,
        'margin_header'     => 5,
        'margin_footer'     => 5,
        'orientation'       => 'L',
        'mode'              => '+aCJK',
        "autoScriptToLang"  => true,
        "autoLangToFont"    => true,
    ];

    /**
     * @param $data
     * @param $view
     *
     * @return array|string
     * @throws \Throwable
     */
    private static function getView($data, $view)
    {
        return view($view, [
            'itemCats' => $data->customer->itemCats,
        ])->render();
    }

    /**
     * Get data base64 pdf
     *
     * @param array $data
     * @param string $view
     * @param string $fileName
     *
     * @return bool|string
     * @throws \Throwable
     */
    public static function makePdf($data, $view, $fileName = '')
    {
        try {
            $pdf  = new Mpdf(array_merge(self::$configFile,
                ['tempDir' => storage_path() . '/app/public']
            ));
            $html = self::getView($data, $view);
            $strings = str_split($html, 500000);
            foreach ($strings as $string) {
                $pdf->WriteHTML($string);
            }

            return $pdf->Output($fileName, 'I');

        } catch (MpdfException $error) {
            Log::error("{$error->getMessage()} - {$error->getFile()}} - {$error->getLine()}");

            return false;
        }
    }
}
