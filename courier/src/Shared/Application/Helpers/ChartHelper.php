<?php

namespace App\Shared\Application\Helpers;

class ChartHelper
{
    function getChartData(array $response, bool $endDate, bool $error): array
    {
        $key = ($endDate) ? 'fecha' : 'hora';
        $color = ($error) ? 'rgb(255, 99, 132)' : 'rgb(54, 162, 235)';
        $labels = array_map(function ($item) use ($key){
            return ($item[$key]<10) ? '0': '' . $item[$key]. ($key == 'hora' ? ':00' : '');
        }, $response);

        $values = array_map(function ($item) {
            return $item['total'];
        }, $response);

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'backgroundColor' => $color,
                    'label' => ($error) ? 'Errores de inserción' : 'Radicados',
                    'data' => $values
                ],
            ],
        ];
    }

    function getChartDataPie(array $response): array
    {
        $labels = array_map(function ($item){
            return $item['errorCode'];
        }, $response);

        $values = array_map(function ($item) {
            return $item['total'];
        }, $response);

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Cantidad de errores',
                    'data' => $values
                ],
            ],
        ];
    }
}