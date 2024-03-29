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

class UserManagementController extends Controller
{
    public function main() {
        return view('dashboard.usermanagement.manage_users');
    }

	public function updateOrAddUser(Request $request)
    {
		try {
			
			$rules = [
				'name' => 'required|string',
				'phone' => 'required',
				'email' => 'required|email',
				'role' => 'required',
			];

			// Validate the input data
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				throw new Exception(implode(",",$validator->messages()->all()));
			}

			$user = User::find($request->id);
			$user = !$user ? new User():$user;
			$user->name = $request->name;
			$user->phone = $request->phone;
			$user->email = $request->email;
			$user->role = $request->role;
			$user->save();
		

			$msg = ["success" => true, "msg" => 'User updated/created successfully'];
            return view('message', compact('msg'));
		} catch (Exception $e) {
			Log::info([
				"Error"	=>	$e->getMessage(),
				"File"	=>	$e->getFile(),
				"Line"	=>	$e->getLine()
			]);
			$msg = ["success" => false, "msg" =>	"Error: ". $e->getMessage()];
            return view('message', compact('msg'));
		}
    }

	public function ban(Request $request) {
		try {
			if (Auth::User()->role != 'admin')
				throw new Exception("You don't have the privilege to perform action");
		
			$validator = Validator::make($request->all(),[ "user_id"	=>	"required"]);

			if ($validator->fails()) {
				throw new Exception(implode(",",$validator->messages()->all()));
			} 

			$user = User::find($request->user_id);
			if (!$user)
				throw new Exception("Invalid user id");

			$user->status = $user->status == "inactive" ? 'active':'inactive';
			$user->save();

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

	public function delete(Request $request) {
		try {
			if (Auth::User()->role != 'admin')
				throw new Exception("You don't have the privilege to perform action");
		
			$validator = Validator::make($request->all(),[
				"user_id"	=>	"required",
			]);

			if ($validator->fails()) {
				throw new Exception(implode(",",$validator->messages()->all()));
			} 

			$user = User::find($request->user_id);
			if (!$user)
				throw new Exception("Invalid user id");

			$user->delete();

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


    public function data() {
      		
		$data = DB::table('users')->get();

		return Datatables::of($data)->
			addIndexColumn()->
			addColumn('name', function ($c) {
				return $c->name;
			})->

			addColumn('email', function ($c) {
				return $c->email;
			})->

			addColumn('status', function ($c) {
				return ucfirst($c->status ?? '') ;
			})->
			addColumn('type', function ($c) {
				return ucfirst($c->role ?? '') ;
			})->

			addColumn('ban', function ($c) {
				$id = $c->id;

				$class = '';
				if ($c->status == 'inactive')
				$class =  'unban';

				return <<<EOD
			<span onclick="ban($id)" class="ban_btn $class ban"><i class="fa fa-ban"></i></span>
EOD;
			})->
			addColumn('edit', function ($c) {
				return <<<EOD
				<span style='font-size: 20px; color:gray;cursor:pointer;;' onclick='updateUserModal("$c->id","$c->name", "$c->email", "$c->phone","$c->role") ' ><i class='fa fa-edit'></i></span>"
EOD;
			})->
			addColumn('delete', function($c){
				return <<<EOD
				<span class='admin' style='font-size: 20px; color:gray;cursor:pointer;color:#aa0000;' onclick='deleteUser($c->id)' ><i class='fa fa-trash'></i></span>"
EOD;
			})->
			escapeColumns([])->make(true);  
    }
}
