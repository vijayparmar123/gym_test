<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth; 
use DB;
use App\User;
use \Validator;
use Illuminate\Support\Facades\Input;

class usercontroller extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
		
		$userrole=Auth::user()->role;
		
		if($userrole == 'admin')
		{
			$perentid = getPerentId(Auth::user()->id);
			
			$user = DB::table('users')->where('parent_id','=',$perentid)->whereNotIn('role',['admin'])->get();
		}
		else if($userrole=='auditor')
		{		
			$user = DB::table('users')->where('id','=',Auth::user()->id)->get();
		}
		
       return view('user.newuser',compact('user'));
    }
	
	public function user()
	{
		return view('user.user_registration');
	}
	
	public function store(Request $request)
	{	
		$rules= array(
            'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6|max:12',
			'confirm_password' => 'required|same:password'
			
			
        );
		
		 $validator = Validator::make(Input::all(), $rules);
		 if ($validator->fails())
		{
			$messages = $validator->messages();
			return redirect('/user_registration')->withErrors($validator)->withInput();
		}
		else
		{
		$user = new User;
		$user ->name = Input::get('name');
		$user ->lastname = Input::get('last_name');
		$user ->email = Input::get('email');
		$user ->password = bcrypt(Input::get('password'));
		$user ->role = 'auditor';
		$user ->status=0;
		$user ->parent_id=Auth::user()->id;
		if(Input::hasFile('image'))
			{
				$file= Input::file('image');
				$file->move(public_path().'/user_profile/', $file->getClientOriginalName());
				$user->com_logo=$file->getClientOriginalName();
			}
		$user->save();
		return redirect('/newuser')->with('message','Successfully Submited');
		}
	}
	
	public function edit($id)
    {
		$editid = $id;
        $user = Db::table('users')->where('id','=',$id)->first();
		return view('user.user_edit_data',compact('user','editid'));
    }
	
	public function update(Request $request, $id)
    {
			$this->validate($request, [
			 'password' => 'required|min:6|max:12',
			'confirm_password' => 'required|same:password',
			 ]);
			 
			$user = User::find($id);
			$user ->name = Input::get('name');
			$user ->lastname = Input::get('last_name');
			$user ->email = Input::get('email');
			$user ->password = bcrypt(Input::get('password'));
			$user ->role = 'auditor';
			date_default_timezone_set("Asia/Calcutta");
			$user ->updated_at=date('Y-m-d H:i:s');
		
			if(Input::hasFile('image'))
				{
					$file= Input::file('image');
					$file->move(public_path().'/user_profile/', $file->getClientOriginalName());
					$user->com_logo=$file->getClientOriginalName();
			}
			$user->save();
			return redirect('/newuser')->with('message','Successfully Updated');
		
	}
	
	public function updatestatus(Request $request, $id)
    {
       $users = DB::table('users')->where('id','=',$id)->first();
		$satus = $users->status;
		if($satus == 0)
		{
			$result = DB::table('users')->where('id','=',$id)->update(['status' => 1]);
		
		}elseif($satus == 1)
		{
			$result = DB::table('users')->where('id','=',$id)->update(['status' => 0]);
		}
	  
	   return redirect('/newuser');
    }

}
