<?php
namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Exception;
use Log;

use App\Models\User;
use App\Models\Service;
use App\Models\Token;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::get();
        return view('dashboard.tokens.index', compact('services'));
    }

    public function isExist(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
        ]);

        $user = User::where('phone', $request->phone_number)->first();

        if ($user)
            return response()->json([  'exists' => true, 'user' => $user  ]);
        else 
            return response()->json([ 'exists' => false]);
    }

    public function data()  {
        $tokens = Token::get();
        return Datatables::of($tokens)
            ->addIndexColumn()
            ->addColumn('token_no', function ($token) {
                return $token->token_no;
            })
            ->addColumn('job_no', function ($token) {
                return $token->job_no;
            })
            ->addColumn('vehicle_no', function ($token) {
                return $token->vehicle_no;
            })
            ->addColumn('vehicle_type', function ($token) {
                return $token->vehicle_type;
            })
            ->addColumn('user', function ($token) {
                $name = $token->user->name;
                return $name;
            })
            ->addColumn('service', function ($token) {
                return $token->service->name;
            })
            ->addColumn('status', function ($token) {
                return ucfirst($token->status);
            })
            ->addColumn('timer', function ($token) {
                return $token->timer;
            })
            ->escapeColumns([])
            ->make(true);
}
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'vehicle_no' => 'required',
                'vehicle_type' => 'required',
                'user_email' => 'required|email',
                'service_id' => 'required',
                'timer' => 'nullable|date',
            ]);    
            
			if ($validator->fails()) {
                throw new \Exception(implode(",",$validator->messages()->all()));
            } 

            $user = User::where('email', $request->user_email)->first();
            if (!$user) {
                $validator = Validator::make($request->all(), [
                    'user_name' => 'required',
                    'user_phone' => 'required',
                ]);    
                
                if ($validator->fails()) {
                    throw new \Exception(implode(",",$validator->messages()->all()));
                } 
    
                $user = new User();
                $user->name = $request->user_name; 
                $user->email = $request->user_email;
                $user->phone = $request->user_phone;
                $user->role = 'viewer';
                $user->save();
            }
    
            $lastJobNo = Token::max('job_no');
            $jobNo = str_pad($lastJobNo + 1, 4, '0', STR_PAD_LEFT);    
            $lastTokenNo = Token::max('token_no');
            $tokenNo = str_pad($lastTokenNo + 1, 4, '0', STR_PAD_LEFT);

            // Create a new token
            $token = new Token();
            $token->token_no = $tokenNo;
            $token->job_no = $jobNo;
            $token->vehicle_no = $request->vehicle_no;
            $token->vehicle_type = $request->vehicle_type;
            $token->user_id = $user->id;
            $token->service_id = $request->service_id;
            $token->save();

            $msg = ["success" => true, "msg" =>	"Token created successfully."];
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

    public function update(Request $request) {
        
    }

}
