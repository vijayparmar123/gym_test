<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\tbl_settings;
use DB;
use Auth;
use Illuminate\Support\Facades\Session;
use App\tbl_projects;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
		
        
		//$project = Db::table('tbl_projects')->where('status', '=',0)->orderBy('updated_at', 'desc')->take(10)->get();
		
		$userrole=Auth::user()->role;
		
		if($userrole == 'admin')
		{
			$perentid = getPerentId(Auth::user()->id);
			$project = Db::table('tbl_projects_'.$perentid)->where('status', '=',0)->orderBy('updated_at', 'desc')->take(10)->get();
			
			$project_count =  Db::table('tbl_projects_'.$perentid)->count();
			$number_of_progress =  Db::table('tbl_projects_'.$perentid)->where('status_prograse','=',0)->count();
			
			$Number_of_Completed =  Db::table('tbl_projects_'.$perentid)->where('status_prograse','=',1)->count();
			$Number_of_Active_Auditor =  Db::table('users')->where([['status','=',1],['parent_id','=',Auth::user()->id]])->whereNotIn('role',['admin'])->count();
			$arry = DB::table('tbl_projects_'.$perentid)->get();
			
		// $arry	= json_encode($projects_celender);
		
			
			//return $all_data=json_encode($holiday_data_array);
		}
		else if($userrole=='auditor')
		{	
			$perentid = getPerentId(Auth::user()->id);
			$project = Db::table('tbl_projects_'.$perentid)->where([['status', '=',0],['uid','=',Auth::user()->id]])->orderBy('updated_at', 'desc')->take(10)->get();
			$project_count =  Db::table('tbl_projects_'.$perentid)->where('uid','=',Auth::user()->id)->count();
			$number_of_progress =  Db::table('tbl_projects_'.$perentid)->where([['status_prograse','=',0],['uid','=',Auth::user()->id]])->count();
			
			$arry = DB::table('tbl_projects_'.$perentid)->where('uid','=',Auth::user()->id)->get();
		}
        return view('home',compact('project','arry','project_count','number_of_progress','Number_of_Completed','Number_of_Active_Auditor'));
    }
	
	public function setting($id)
	{	
		
		$id=Auth::user()->id;
		$user = Db::table('users')->where('id','=',$id)->first();
		return view('user.setting',compact('user','id'));
	}
	public function language()
	{	
		$userrole=Auth::user()->role;
		
		if($userrole == 'admin')
		{
		$perentid = getPerentId(Auth::user()->id);
		$tblset = DB::table('tbl_settings_'.$perentid)->first();
		$tblsetting = $tblset->language;
		}
		
		return view('user.languagefile',compact('tblsetting'));
	}
	public function savelanguage(Request $request)
	{	
		$language = $request->input('language');
		 $perentid = getPerentId(Auth::user()->id);
		// $language = Input::get("language");
		 $lanng = DB::table('tbl_settings_'.$perentid)->first();
		 $id = $lanng->id;
		// $lan = tbl_settings::find($id);
		 //$lan->language = $language;
		
		$sql = DB::update("update tbl_settings_$perentid set language='$language' where id='$id'");
			Session::put('locale',$language);
			$value=Session::get('locale');
		return redirect('/langagesetting');
	}
	
	public function updateSetting(Request $request,$id)
	{	
		
		// 'old_password' => 'required|old_password:' . Auth::user()->password
			
			
			 
			$data = $request->all();
			$user = User::find(auth()->user()->id);
			  if(!Hash::check($data['user_define_password'], $user->password))
			{
			    return redirect('/setting/{id}')->with('message','The Old password does not match the database password');
			}
			else
			{	
				
				$newpassword = bcrypt(Input::get('new_password'));
			    $user = User::find($id);
				$user->password =$newpassword;
				$user->save();
				return redirect('/')->with('message','Password Successfully Updated');
			}
			
	}
	
	 public function edit($id)
    {	
		$editid = $id;
		$id=Auth::user()->id;
		$user = Db::table('users')->where('id','=',$id)->first();
		return view('user.profile_edit_data',compact('user','editid'));
    }
	
	public function update(Request $request, $id)
    {	
		$this->validate($request, [
			 'password' => 'required|min:6|max:12',
			'confirm_password' => 'required|same:password',
			 ]);
			 
		$id=Auth::user()->id;
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
				$user->com_logo	=$file->getClientOriginalName();
			}
		$user->save();
		return redirect('/')->with('message','Successfully Updated');
	}
	
	
	
	
}
