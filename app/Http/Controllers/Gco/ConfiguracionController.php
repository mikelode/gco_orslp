<?php

namespace App\Http\Controllers\Gco;

use App\User;
use App\Models\Proyecto;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Sistema;
use App\Models\Equiprof;
use App\Models\Uejecutora;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = view('setting.panel_configuracion');
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getRegisterUser(Request $request)
    {
        $pys = Proyecto::with('ejecutor')->where('pryInvalidate',false)->get();
        $view = view('setting.register_user',compact('pys'));

        if($request->ajax())
        {
            $sections = $view->renderSections();
            return $sections['sub-content'];
        }

        return $view;
    }

    public function  postRegisterUser(Request $request)
    {
        DB::transaction(function() use ($request){

            $user = new User();

            $user->tusNickName = trim($request->dni_user);
            $user->password = \Hash::make(trim($request->dni_user));
            $user->tusDni = trim($request->dni_user);
            $user->tusFullName = strtoupper($request->name_user).' '.strtoupper($request->patern_user).' '.strtoupper($request->matern_user);
            $user->tusNames = strtoupper($request->name_user);
            $user->tusPaterno = strtoupper($request->patern_user);
            $user->tusMaterno = strtoupper($request->matern_user);
            $user->tusProject = implode(',',$request->npyName);
            $user->tusJob = strtoupper(trim($request->job_user));
            $user->tusEmail = strtoupper(trim($request->email_user));
            $user->tusPhone = strtoupper(trim($request->phone_user));
            $user->tusRegisterBy = Auth::user()->tusId;
            $user->tusRegisterAt = Carbon::now();//->format('d/m/Y h:i:s A');
            $user->tusState = true;

            $user->save();
        });

        if($request->ajax())
        {
            return "Usuario ".$request->dni_user." creado con éxito.";
        }

        return false;

    }

    public function showProfileUser($idUser, Request $request)
    {
        /*$profile = DB::select("SELECT  r.trolId,r.trolIdUser,r.trolIdSyst, s.tsysDescF, r.trolEnable
                      FROM tramRoles r
                      INNER JOIN tramSistema s ON r.trolIdSyst = s.tsysId
                      WHERE r.trolIdUser = '".$idUser."';");*/
        $user = User::find($idUser);
        $projects = Proyecto::all();
        $user_projects = explode(',',$user->tusProject);
        
        $profile = Rol::select('*')
                    ->where('trolIdUser',$idUser)
                    ->where('trolEnable',true)
                    ->get();

        $funciones = Sistema::select('*')
                        ->orderby('tsysModulo','ASC')
                        ->get();

        $idFunciones = $funciones->pluck('tsysId');
        $idProfile = $profile->pluck('trolIdSyst');

        $view = view('setting.tabla_perfil_usuario', compact('idUser','idProfile','funciones','profile','projects','user_projects'));

        //$prof_func = array_intersect($idFunciones->toArray(), $idProfile->toArray());
        //dd($prof_func);

        return $view;
    }

    public function getListUsers(Request $request)
    {
        $list_users = User::all();

        $view = view('setting.list_users',compact('list_users'));

        if($request->ajax())
        {
            $sections = $view->renderSections();
            return $sections['sub-content'];
        }

        return $view;
    }

    public function postUpdateProfile(Request $request)
    {
        $user = $request->name;
        $funcion = $request->pk;
        $valor = $request->value; // A: asignado B: no asignado (quitar)

        //check if exist the user with this function

        $profile = Rol::select('*')
                    ->where('trolIdUser',$user)
                    ->where('trolIdSyst',$funcion)
                    ->get();

        if($profile->isEmpty()){
            $addProfile = new Rol();
            $addProfile->trolIdUser = $user;
            $addProfile->trolIdSyst = $funcion;
            $addProfile->trolEnable = true;
            $addProfile->save();
        }
        else{
            $editProfile = Rol::find($profile[0]->trolId);
            $editProfile->trolEnable = $valor=='A' ? true : false;
            $editProfile->save();
        }

        $success = true;
        $msg = 'Estado cambiado correctamente';

        return response()->json(compact('success','msg'));
    }

    public function postUpdateStateUser(Request $request)
    {
        DB::transaction(function() use($request){

            $user = User::find($request->id);
            $user->tusState = $request->active;
            $user->save();

        });

        if($request->ajax())
        {
            if($request->active)
                return 'El usuario '.$request->id.' ha sido ACTIVADO';
            else
                return 'El usuario '.$request->id.' ha sido DESACTIVADO';
        }
        return false;
    }

    public function getUpdatePasswordUser(Request $request)
    {
        $view = view('setting.update_password');

        if($request->ajax())
        {
            $sections = $view->renderSections();
            return $sections['main-content'];
        }

        return $view;
    }

    public function postUpdatePasswordUser(Request $request)
    {
        DB::transaction(function() use($request){

            $dni = $request->idUser;

            $user = User::find($dni);
            $user->password = \Hash::make($request->rpassUser);
            $user->save();

        });

        if($request->ajax())
        {
            return 'Su contraseña ha sido actualizada';
        }

        return false;
    }

    public function getResetPasswordUser(Request $request)
    {
        DB::transaction(function() use($request){

            $dni = $request->idUser;

            $user = User::find($dni);
            $user->password = \Hash::make($user->tusDni);
            $user->save();

        });

        if($request->ajax())
        {
            return 'La nueva contraseña es el DNI del usuario';
        }

        return false;
    }

}
