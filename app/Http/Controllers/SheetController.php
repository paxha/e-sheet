<?php

namespace App\Http\Controllers;

use App\Project;
use App\Sheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sheet::all();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|integer',
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $sheet = new Sheet();

        $sheet->project_id = $request->project_id;
        $sheet->name = $request->name;

        $sheet->save();

        return $this->showByProject(Project::find($request->project_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sheet $sheet
     * @return \Illuminate\Http\Response
     */
    public function show(Sheet $sheet)
    {
        return Sheet::with('project')->where('id', $sheet->id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sheet $sheet
     * @return \Illuminate\Http\Response
     */
    public function edit(Sheet $sheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Sheet $sheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sheet $sheet)
    {
        $sheet->name = $request->name;

        $sheet->save();

        return $this->showByProject(Project::find($request->project_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sheet $sheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Sheet $sheet)
    {
        $sheet->delete();
    }

    public function showByProject(Project $project)
    {
        return Sheet::with('project')->where('project_id', $project->id)->orderBy('created_at', 'DESC')->paginate(10);
    }
}
