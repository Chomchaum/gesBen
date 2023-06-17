<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEvenementRequest;
use App\Http\Requests\UpdateEvenementRequest;
use App\Models\Evenement;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->owned_events;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateEvenementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateEvenementRequest $request)
    {
        $event = Evenement::create($request->validated());

        return response($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evenement  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Evenement $event)
    {
        abort_unless($event->owner == auth()->user(), 403);

        return response($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEvenementRequest  $request
     * @param  \App\Models\Evenement  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEvenementRequest $request, Evenement $event)
    {
        return response ($event->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evenement  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evenement $event)
    {
        abort_unless($event->owner == auth()->user(), 403);

        return response($event->delete());
    }
}
