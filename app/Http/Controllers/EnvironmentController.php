<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use Illuminate\Http\Request;

class EnvironmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        ini_set('max_execution_time', 3000);
    }

    public function index(Request $request)
    {
        $environment = Environment::Leftjoin('companies', 'companies.id', '=', 'environments.company_id');
        $environment = $environment->selectRaw('MIN(company_id) AS company_id, MAX(emossion_year) AS emossion_year, SUM(after_gas_emission) AS after_gas_emission, MAX(companies.name) AS name, SUM(CASE WHEN emossion_year = ' . $request->emossion_year . ' THEN after_gas_emission * -1 ELSE after_gas_emission END) AS reduction_emission')->whereNotNull('name');

        $environment = $environment->whereBetween('emossion_year', [$request->emossion_year - 1, $request->emossion_year]);
        if($request->name)
            $environment = $environment->where('name', 'LIKE', '%'.$request->name.'%');

        switch($request->emoss_amount) {
            case 1:
                $environment = $environment->where('after_gas_emission', '<', 50000);
                break;
            case 2:
                $environment = $environment->where('after_gas_emission', '>=', 50000)->where('after_gas_emission', '<', 200000);
                break;
            case 3:
                $environment = $environment->where('after_gas_emission', '>=', 200000);
                break;
            default:
                break;
        }

        $environment = $environment->groupBy('company_id');
        
        $total = $environment->get()->count();
        $result = $environment->offset($request->page * 50)->limit(50)->orderBy('company_id', 'asc')->get();
        return response()->json(['status' => '200', 'data' => $result, 'total' => $total]);
    }

    public function getYear()
    {
        $year = Environment::select('emossion_year')->groupBy('emossion_year')->get();
        return response()->json(['status' => '200', 'data' => $year]);
    }

    public function getEmossionRank(Request $request)
    {
        $environment = Environment::Leftjoin('companies', 'companies.id', '=', 'environments.company_id');
        $environment = $environment->select('company_id', 'emossion_year', 'after_gas_emission', 'name')->whereNotNull('name');

        $environment = $environment->where('emossion_year', '=', $request->emossion_year);
        if($request->name)
            $environment = $environment->where('name', 'LIKE', '%'.$request->name.'%');
        
        switch($request->emoss_amount) {
            case 1:
                $environment = $environment->where('after_gas_emission', '<', 50000);
                break;
            case 2:
                $environment = $environment->where('after_gas_emission', '>=', 50000)->where('after_gas_emission', '<', 200000);
                break;
            case 3:
                $environment = $environment->where('after_gas_emission', '>=', 200000);
                break;
            default:
                break;
        }
            
        $total = $environment->count();
        $environment = $environment->offset($request->page * 50)->limit(50)->orderByRaw('CONVERT(after_gas_emission, INT) desc')->get();
        return response()->json(['status' => '200', 'data' => $environment, 'total' => $total]);
    }

    public function getReductionRank(Request $request)
    {
        $environment = Environment::Leftjoin('companies', 'companies.id', '=', 'environments.company_id');
        $environment = $environment->selectRaw('MIN(company_id) AS company_id, MAX(emossion_year) AS emossion_year, MAX(name) AS name, SUM(CASE WHEN emossion_year = ' . $request->emossion_year . ' THEN CAST(after_gas_emission * -1 AS int) ELSE CAST(after_gas_emission AS int) END) AS reduction_emission')->whereNotNull('name');

        $environment = $environment->whereBetween('emossion_year', [$request->emossion_year - 1, $request->emossion_year]);
        if($request->name)
            $environment = $environment->where('name', 'LIKE', '%'.$request->name.'%');

        switch($request->emoss_amount) {
            case 1:
                $environment = $environment->where('after_gas_emission', '<', 50000);
                break;
            case 2:
                $environment = $environment->where('after_gas_emission', '>=', 50000)->where('after_gas_emission', '<', 200000);
                break;
            case 3:
                $environment = $environment->where('after_gas_emission', '>=', 200000);
                break;
            default:
                break;
        }

        $environment = $environment->groupBy('company_id');
        
        $total = $environment->get()->count();
        $result = $environment->offset($request->page * 50)->limit(50)->orderBy('reduction_emission', 'desc')->get();
        return response()->json(['status' => '200', 'data' => $result, 'total' => $total]);
    }

    public function getDetail(Request $request)
    {
        $detail = Environment::Leftjoin('companies', 'companies.id', '=', 'environments.company_id');
        $detail = $detail->select('company_id', 'emossion_year', 'after_gas_emission', 'name');

        $detail = $detail->whereBetween('emossion_year', [$request->start_year - 1, $request->end_year])->where('company_id', '=', $request->id);

        $detail = $detail->orderBy('emossion_year', 'desc')->get();
        return response()->json(['status' => '200', 'data' => $detail]);
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
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function show(Environment $environment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function edit(Environment $environment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Environment $environment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Environment $environment)
    {
        //
    }
}
