<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Response;

use App\Http\Requests;
use App\Work;

class WorkController extends Controller
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
        try{
            $work = Work::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work with that id, does not exist.');
        }

        $photo = array(
            'photos' => $work->images()->get()
                        ->transform(function($item){
                            return (object) array(
                                    'normal' => url($item->normal_path),
                                    'thumbnail' => url($item->thumbnail_path),
                                    'order' => $item->order,
                                    'title' => 'Photo title',
                                );
                        })
                        ->toArray()
        );
        return Response::json(array_merge($work->toArray(), $photo), 200);
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
}
