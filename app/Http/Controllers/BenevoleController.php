<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBenevoleRequest;
use App\Models\Benevole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BenevoleController extends Controller
{

    /**
     * Crée un bénévole et le stocke en DB
     *
     * @param CreateBenevoleRequest $request
     */
    public function create(CreateBenevoleRequest $request)
    {
        Benevole::create($request->validated());
        return response("OK");
    }

    /**
     * Renvoie les infos sur un bénévole donné
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * Modifie le bénévole concerné
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Supprime le bénévole concerné
     *
     * @param int $id
     */
    public function destroy($id)
    {
        Benevole::find($id)->delete();
    }
}
