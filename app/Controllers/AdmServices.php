<?php

namespace App\Controllers;
use App\Database\DbUtils;

class AdmServices
{
    public function injection(): string
    {
        // Get data from DB
        $query = DbUtils::getPdo()->query('SELECT * FROM service');
        $services = $query->fetchAll(\PDO::FETCH_ASSOC);
        
        // Creat HTML for each service
        $html = '';
        foreach ($services as $service) {
            $html .= '<tr>';
            $html .= '<td>' . $service['name'] . '</td>';
            $html .= '<td>' . $service['description'] . '</td>';
            $html .= '<td>' . $service['image_url']. '</td>';
            $html .= '<td>' . $service['image_alt'] . '</td>';
            $html .= '<td>' . $service['image_alt'] . '</td>';
            $html .= '<td>' .'<i class="bi bi-pencil-square"></i>'.'<i class="bi bi-trash"></i>' . '</td>';
            $html .= '</tr>';
        }
        return $html;
    }
}
