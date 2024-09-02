<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class MetricasController extends Controller
{
    public function afiliaciones(Request $req)
    {
        // Se encarga de procesar el número de afiliaciones aprobadas por mes y año

        $year = $req->input('year') ? $req->input('year') : date('Y');
        $months = [
            'Enero' => 1,
            'Febrero' => 2,
            'Marzo' => 3,
            'Abril' => 4,
            'Mayo' => 5,
            'Junio' => 6,
            'Julio' => 7,
            'Agosto' => 8,
            'Septiembre' => 9,
            'Octubre' => 10,
            'Noviembre' => 11,
            'Diciembre' => 12
        ];

        $afiliaciones_mes = [];

        foreach ($months as $month => $monthNumber) {
            $afiliaciones_mes[$month] = DB::table("historial__suscripcions")
                ->whereYear('fecha_inicio', $year)
                ->whereMonth('fecha_inicio', $monthNumber)
                ->where('estatus', 'Activa')
                ->count();  // Usar count() directamente para obtener el número total
        }

        return response()->json($afiliaciones_mes);
    }
    public function citas(Request $req)
    {
        # citas canceladas y finalizadas por mes y año
        $year = $req->input('year') ? $req->input('year') : date('Y');
        $months = [
            'Enero' => 1,
            'Febrero' => 2,
            'Marzo' => 3,
            'Abril' => 4,
            'Mayo' => 5,
            'Junio' => 6,
            'Julio' => 7,
            'Agosto' => 8,
            'Septiembre' => 9,
            'Octubre' => 10,
            'Noviembre' => 11,
            'Diciembre' => 12
        ];

        $citas_canceladas = [];

        foreach ($months as $month => $monthNumber) {
            $citas_canceladas[$month] = DB::table("asesorias")
                ->whereYear('fecha_cita', $year)
                ->whereMonth('fecha_cita', $monthNumber)
                ->whereIn('estatus', ['Cancelada'])
                ->count();
        }

        $citas_finalizadas = [];

        foreach ($months as $month => $monthNumber) {
            $citas_finalizadas[$month] = DB::table("asesorias")
                ->whereYear('fecha_cita', $year)
                ->whereMonth('fecha_cita', $monthNumber)
                ->whereIn('estatus', ['Finalizada'])
                ->count();
        }

        $citas_pendientes = [];

        foreach ($months as $month => $monthNumber) {
            $citas_pendientes[$month] = DB::table("asesorias")
                ->whereYear('fecha_cita', $year)
                ->whereMonth('fecha_cita', $monthNumber)
                ->whereIn('estatus', ['Pendiente'])
                ->count();
        }

        return response()->json([
            'citas_canceladas' => $citas_canceladas,
            'citas_finalizadas' => $citas_finalizadas,
            "citas_pendientes" => $citas_pendientes
        ]);
    }

    public function usuario_residencia()
    {
        // Get the count of users grouped by their state of residence
        $residencias = DB::table('users')
            ->select('id_estado_residencia', DB::raw('count(*) as total_usuarios'))
            ->groupBy('id_estado_residencia')
            ->get();

        // Get all states
        $estados = DB::table('estados')->get();

        // Initialize an array to hold the final data
        $data = [];

        // Loop through all states to ensure each state is included in the final response
        foreach ($estados as $estado) {
            // Find the corresponding residencia count for this state, if any
            $residencia = $residencias->firstWhere('id_estado_residencia', $estado->id);
            $data[] = [
                'estado' => $estado->nombre,
                'total_usuarios' => $residencia ? $residencia->total_usuarios : 0
            ];
        }

        return response()->json($data);
    }


    public function usuarios_afiliados()
    {
        $afiliados = DB::table('suscripciones')
            ->where('estatus', 'Activa')
            ->count();

        $total_usuarios = DB::table('users')->count();

        return response()->json([
            'afiliados' => $afiliados,
            'total_usuarios' => $total_usuarios
        ]);
    }

    public function usuario_identidades()
    {


        $identidades = DB::table('users')
            ->select("identidad_genero", DB::raw('count(*) as total_usuarios'))
            ->whereNotNull('identidad_genero')
            ->where('identidad_genero', '!=', '')
            ->groupBy('identidad_genero')
            ->get();

        $total_usuarios = DB::table('users')->count();

        return response()->json([
            'identidades' => $identidades,
            'total_usuarios' => $total_usuarios
        ]);
    }
    public function usuario_pronombres()
    {
        // Get the count of users grouped by their pronoun of choice
        $pronombres = DB::table('users')
            ->select('pronombres', DB::raw('count(*) as total_usuarios'))
            ->whereNotNull('pronombres')
            ->groupBy('pronombres')
            ->get();

        $total_usuarios = DB::table('users')->count();

        return response()->json([
            'pronombres' => $pronombres,
            'total_usuarios' => $total_usuarios
        ]);
    }
    public function usuario_neurodivergentes()
    {
        $neurodivergentes = DB::table('users')
            ->where('neurodivergencia', true)
            ->count();


        return $neurodivergentes;
    }
    public function usuario_afro_indigena()
    {
        $afrodescendientes = DB::table('users')
            ->where('afrodescendiente', true)
            ->count();

        $indigenas = DB::table('users')
            ->where('indigena', true)
            ->count();

        $neurodivergentes = $this->usuario_neurodivergentes();

        $total_usuarios = DB::table('users')->count();

        return response()->json([
            'total_usuarios' => $total_usuarios,
            'afrodescendientes' => $afrodescendientes,
            'indigenas' => $indigenas,
            'neurodivergentes' => $neurodivergentes
        ]);
    }
}
