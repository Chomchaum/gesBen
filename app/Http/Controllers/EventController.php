<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
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
     * @param  \App\Http\Requests\CreateEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateEventRequest $request)
    {
        dump('plop');
        $myEvent = collect($request->validated())->put('user_id', auth()->user()->id)->toArray();
        //$myEvent['reseaux_sociaux'] = json_encode($myEvent['reseaux_sociaux']);
        dump('$myEvent');
        dump($myEvent);
        $event = Event::create($myEvent);
        dump($event);
        return response($event, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        abort_unless(auth()->user()->owned_events()->whereIn($event->id)->count() > 0, 403);

        return response($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        abort_unless(auth()->user()->owned_events()->whereIn($event->id)->count() > 0, 403);

        return response ($event->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        abort_unless(auth()->user()->owned_events()->whereIn($event->id)->count() > 0, 403);

        return response($event->delete());
    }
}
