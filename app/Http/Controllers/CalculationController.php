<?php

namespace App\Http\Controllers;

use App\Calculation;
use App\Sheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
//        $validator = Validator::make($request->all(), [
//            'sheet_id' => 'integer',
//            'description' => 'string|max:191',
//            'type' => 'string|max:3',
//            'height_feet' => 'integer',
//            'height_inches' => 'integer',
//            'width_feet' => 'integer',
//            'width_inches' => 'integer',
//            'qty' => 'integer',
//        ]);
//
//        if ($validator->fails()){
//            return $validator->errors();
//        }

        if (!$request->type){
            $request['type'] = 'add';
        }
        if (!$request->height_feet){
            $request['height_feet'] = 0;
        }
        if (!$request->height_inches){
            $request['height_inches'] = 0;
        }
        if (!$request->width_feet){
            $request['width_feet'] = 0;
        }
        if (!$request->width_inches){
            $request['width_inches'] = 0;
        }
        if (!$request->qty){
            $request['qty'] = 1;
        }

        $calculation = new Calculation();

        $calculation->sheet_id = $request->sheet_id;
        $calculation->description = $request->description;
        $calculation->height_feet = $request->height_feet;
        $calculation->height_inches = $request->height_inches;
        $calculation->width_feet = $request->width_feet;
        $calculation->width_inches = $request->width_inches;
        $calculation->qty = $request->qty;
        $calculation->type = $request->type;

        $calculation->save();

        return $this->showBySheet(Sheet::find($request->sheet_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function show(Calculation $calculation)
    {
        return $calculation;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function edit(Calculation $calculation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calculation $calculation)
    {
        if (!$request->height_feet){
            $request['height_feet'] = 0;
        }
        if (!$request->height_inches){
            $request['height_inches'] = 0;
        }
        if (!$request->width_feet){
            $request['width_feet'] = 0;
        }
        if (!$request->width_inches){
            $request['width_inches'] = 0;
        }
        if (!$request->qty){
            $request['qty'] = 1;
        }

        $calculation->description = $request->description;
        $calculation->height_feet = $request->height_feet;
        $calculation->height_inches = $request->height_inches;
        $calculation->width_feet = $request->width_feet;
        $calculation->width_inches = $request->width_inches;
        $calculation->qty = $request->qty;
        $calculation->type = $request->type;

        $calculation->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Calculation $calculation
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Calculation $calculation)
    {
        $calculation->delete();
    }

    public function showBySheet(Sheet $sheet){
        $calculations = Calculation::with('sheet.project')->where('sheet_id', $sheet->id)->get();
        $this->converter($calculations);
        return $calculations;
    }

    private function converter($calculations){
        foreach ($calculations as $calculation){
            $calculation['height'] = "$calculation->height_feet' $calculation->height_inches\"";
            $calculation['width'] = "$calculation->width_feet' $calculation->width_inches\"";
            // Total Converter
            $inches = $calculation->total;
            $feet = 0;
            while ($inches > 11){
                $feet++;
                $inches -= 12;
            }
            $calculation['total'] = "$feet' $inches\"";
        }
    }
}
