<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user()->tusFullName;

        $pyAccess = Auth::user()->tusProject;

        if($pyAccess == 0){
            $pys = Proyecto::where('pryInvalidate',false)->get();

            $dashboard = DB::select("select a.pryId, a.pryShortDenomination, a.prySnip, a.pryUnifiedCode, b.aprId, b.aprProgFisica, c.prgNumberVal, c.prgStartPeriod, c.prgEndPeriod, c.prgAggregateExec, c.prgStatus,
            round((c.prgAggregateExec / c.prgAggregate) * 100,2) as prgPerformance, d.prgProgress
            FROM gcoproyecto a
            left join (select max(aprId) as aprId, aprProject, max(aprProgFisica) as aprProgFisica from gcoavancepres
            group by aprProject) b on a.pryId = b.aprProject
            left join (select GROUP_CONCAT(round(((b.prgAggregateExec / b.prgAggregate) * 100) - 80,2) ORDER by a.aprProgFisica ASC separator ', ') as prgProgress, max(a.aprId) as aprId  from gcoavancepres a
            inner join gcoprogfisica b on a.aprProgFisica = b.prgId
            group by a.aprProject) d on b.aprId = d.aprId
            left join gcoprogfisica c on b.aprProgFisica = c.prgId");
        }
        else{
            $pys = Proyecto::where('pryInvalidate',false)
                    ->whereIn('pryId',explode(',',$pyAccess))
                    ->get();

            $array_projects = $pys->pluck('pryId')->all();
            
            $dashboard = DB::table('gcoproyecto as a')
                            ->select(DB::raw("a.pryId, a.pryShortDenomination, a.prySnip, a.pryUnifiedCode, b.aprId, b.aprProgFisica, c.prgNumberVal, c.prgStartPeriod, c.prgEndPeriod, c.prgAggregateExec, c.prgStatus,
                            round((c.prgAggregateExec / c.prgAggregate) * 100,2) as prgPerformance, d.prgProgress"))
                            ->leftJoin(
                                DB::raw('(select max(aprId) as aprId, aprProject, max(aprProgFisica) as aprProgFisica from gcoavancepres
                                group by aprProject) as b'), function($join){
                                    $join->on('a.pryId','=','b.aprProject');
                                }
                            )
                            ->leftJoin(
                                DB::raw("(select GROUP_CONCAT(round(((q.prgAggregateExec / q.prgAggregate) * 100) - 80,2) ORDER by p.aprProgFisica ASC separator ', ') as prgProgress, max(p.aprId) as aprId  from gcoavancepres p inner join gcoprogfisica q on p.aprProgFisica = q.prgId
                                group by p.aprProject) as d"), function($join){
                                    $join->on('b.aprId','=','d.aprId');
                                }
                            )
                            ->leftJoin('gcoprogfisica as c','b.aprProgFisica','=','c.prgId')
                            ->whereIn('a.pryId',$array_projects)
                            ->get();
        }

        return view('gestion.panel_main',compact('usuario','dashboard'));
        //return view('home'); -> existe pero no es utilizado
    }
}
