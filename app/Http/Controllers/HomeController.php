<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Crypt;
use PDF;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function storage(){
        return view('store');
    }

    public function account(){
        return view('account');
    }

    public function log(){
        return view('logs');
    }

    public function DownloadReport($date_from, $date_to){

        $date_from = Crypt::decrypt($date_from);
        $date_to = Crypt::decrypt($date_to);

        $transactions = Activity::selectRaw('medicines.general_description, 
                    SUM(CASE WHEN activities.type = 0 THEN activities.quantity ELSE 0 END) as total_deducted, 
                    SUM(CASE WHEN activities.type = 1 THEN activities.quantity ELSE 0 END) as total_added, 
                    medicines.quantity as total_onhand')
                    ->join('medicines', 'activities.medicine_id', '=', 'medicines.id')
                    ->whereDate('log_time', '>=', $date_from)
                    ->whereDate('log_time', '<=', $date_to)
                    ->groupBy('medicines.general_description', 'medicines.quantity')
                    ->orderBy('log_time', 'asc')
                    ->get();

        $transactions = PDF::loadView('report', ['transactions' => $transactions, 'date_from' => $date_from, 'date_to' => $date_to]);
        
        return $transactions->stream('pdf.report');
    }
}
