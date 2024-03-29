<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Exception;
use Log;
use App\Models\Service;

class ServiceController extends Controller
{

    public function index() {
        return view('dashboard.services.index');
    }

    public function data()
    {
        $data = DB::table('services')->get();
        return Datatables::of($data)->
            addIndexColumn()->
            addColumn('name', function ($c) {
                return $c->name;
            })->
            addColumn('delete', function($c){
				return <<<EOD
				<span class='admin' style='font-size: 20px; color:gray;cursor:pointer;color:#aa0000;' onclick='deleteService($c->id)' ><i class='fa fa-trash'></i></span>"
EOD;
			})->
			escapeColumns([])->make(true);  
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255'
            ]);    
            
			if ($validator->fails()) {
                throw new \Exception(implode(",",$validator->messages()->all()));
            } 
        
            Service::create($request->all());

            $msg = ["success" => true, "msg" =>	"Service created successfully."];
            return view('message', compact('msg'));
        } catch (\Exception $e) {
			Log::info([
				"Error"	=>	$e->getMessage(),
				"File"	=>	$e->getFile(),
				"Line"	=>	$e->getLine()
			]);
            $msg = ["success" => false, "msg" =>	"Error: ". $e->getMessage()];
            return view('message', compact('msg'));
		}
    }


	public function destroy(Request $request) {
		try {
		
			$validator = Validator::make($request->all(),[
				"service_id"	=>	"required",
			]);

			if ($validator->fails()) {
				throw new Exception(implode(",",$validator->messages()->all()));
			} 

			$service = Service::find($request->service_id);
			if (!$service)
				throw new Exception("Invalid service id");

			$service->delete();

			return response()->json(['status'=>'ok']);
		} catch (Exception $e) {
			Log::info([
				"Error"	=>	$e->getMessage(),
				"File"	=>	$e->getFile(),
				"Line"	=>	$e->getLine()
			]);
			return response()->json(['status' => false, 'error' => $e->getMessage()], 404);
		}
	}
}
