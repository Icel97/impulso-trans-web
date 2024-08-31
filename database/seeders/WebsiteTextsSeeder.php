<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WebsiteText;

class WebsiteTextsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebsiteText::create(['identifier' => 'programa1', 'title' => 'Asesora jurídicaa', 'content' => 'Contenido del programa 1', 'url_img' => 'https://armas-asociados.com/wp-content/uploads/2023/06/contratar-una-asesoria-juridica-1024x683.jpg']);
        WebsiteText::create(['identifier' => 'programa2', 'title' => 'Consejería estratégica', 'content' => 'Contenido del programa 2', 'url_img' => 'https://atisa.es/wp-content/uploads/2022/08/estrategia-empresa.jpg']);
        WebsiteText::create(['identifier' => 'programa3', 'title' => 'Fortalecimiento económico', 'content' => 'Contenido del programa 3', 'url_img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTUm2kmhDbvO2ut57Jhov-hYCboXT9eY_whNQ&s']);
    }
}
