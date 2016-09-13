<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Response;

use App\Http\Requests;
use App\Http\Requests\CreateWorkRequest;
use App\Work;
use App\PRS\Transformers\WorkTransformer;

class WorkController extends Controller
{

    public $workTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WorkTransformer $workTransformer)
    {
        $this->middleware('auth');
        $this->workTransformer = $workTransformer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorkRequest $request)
    {
        $work = Work::create(array_map('htmlentities', $request->all()));
        if($work){
            return Response::json([
                'title' => 'Work Created',
                'message' => 'The work was successfully created'
            ], 200);
        }
        // return Response::json([
        //         'title' => 'Work Created',
        //         'error' => 'The work was not created created'
        //     ], 500);
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
            $work = $this->workTransformer->transform(Work::findOrFail($id));
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work with that id, does not exist.');
        }
        return Response::json($work, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateWorkRequest $request, $id)
    {
        try {
            $work = Work::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work with that id, does not exist.');
        }

        $work->fill(array_map('htmlentities', $request->except('work_order_id')));
        $work->save();

        return Response::json([
                'title' => 'Work Updated',
                'message' => 'The work was successfully updated'
            ], 200);
    }

    public function addPhoto(Request $request, $id)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        try {
            $work = Work::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work with that id, does not exist.');
        }

        $file = $request->file('photo');
        if($work->addImageFromForm($file)){
            return Response::json([
                'message' => 'The photo was added to the equipment'
            ], 200);
        }
        return Response::json([
                'error' => 'The photo could not added to the equipment'
            ], 500);

    }

    public function removePhoto($id, $order)
    {
        try {
            $work = Work::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work with that id, does not exist.');
        }

        $image = $work->image($order, false);

        if($image->delete()){
                return Response::json([
                'message' => 'The photo was deleted from the equipment'
            ], 200);
        }
        return Response::json([
                'error' => 'The photo could not deleted from the equipment'
            ], 500);
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
