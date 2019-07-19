<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth; 
use DB;
use App\User;
use Illuminate\Support\Facades\Input;

class templatecontroller extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
    public function index()
	{	
		$userrole=Auth::user()->role;
		
		if($userrole == 'admin')
		{
		$perentid = getPerentId(Auth::user()->id);
		$tbl_templates =DB::table('tbl_templates_'.$perentid)->where('temptype','=','o')->get();
		}
		else if($userrole=='auditor')
		{
		$perentid = getPerentId(Auth::user()->id);
		$tbl_templates =DB::table('tbl_templates_'.$perentid)->where('temptype','=','o')->get();	
		}
		return view('template.own_template',compact('tbl_templates'));
	}
	 public function client_company()
	{	
		$userrole=Auth::user()->role;
		
		if($userrole == 'admin')
		{
		$perentid = getPerentId(Auth::user()->id);
		$tbl_templates =DB::table('tbl_templates_'.$perentid)->where('temptype','=','c')->get();
		}
		else if($userrole=='auditor')
		{
		$perentid = getPerentId(Auth::user()->id);
		$tbl_templates =DB::table('tbl_templates_'.$perentid)->where('temptype','=','c')->get();
		}
		return view('template.client_template',compact('tbl_templates'));
	}
	
	public function store(Request $request)
    {	
		$template_name = $request->input('template_name');
		$company_name = $request->input('company_name');
		$temptype='o';
        	
		if(Input::hasFile('image'))
			{
				$file= Input::file('image');
				$filename=$file->getClientOriginalName();
				$file->move(public_path().'/company_logo/', $file->getClientOriginalName());
				
			}
		$userid= Auth::user()->id;
		$perentid = getPerentId(Auth::user()->id);
		$sql = DB::insert("insert into tbl_templates_$perentid (tempname,auditorcname,temptype,auditorclogo,uid)
		values('$template_name','$company_name','$temptype','$filename','$userid')");
		return redirect('/template')->with('message','Successfully Submited');
    }
	
	public function storeClient(Request $request)
    {	
		$template_name = $request->input('template_name');
		$company_name = $request->input('company_name');
		$temptype='c';
        $auditor_company_name = $request->input('auditor_company_name');
		if(Input::hasFile('image'))
			{
				$file= Input::file('image');
				$filename1=$file->getClientOriginalName();
				$file->move(public_path().'/company_logo/', $file->getClientOriginalName());
			}
		
		if(Input::hasFile('image1'))
			{
				$file1= Input::file('image1');
				$filename2=$file1->getClientOriginalName();
				$file1->move(public_path().'/client_logo/', $file1->getClientOriginalName());
			}
			
		$userid= Auth::user()->id;
		$perentid = getPerentId(Auth::user()->id);
		$sql = DB::insert("insert into tbl_templates_$perentid (tempname,auditorcname,temptype,clientcname,auditorclogo,clientclogo,uid)
		values('$template_name','$company_name','$temptype','$auditor_company_name','$filename1','$filename2','$userid')");
		
		return redirect('/client_company')->with('message','Successfully Submited');
    }
	
	public function destroy($id)
    {	
		$userrole=Auth::user()->role;
		
		if($userrole == 'admin')
		{
		$perentid = getPerentId(Auth::user()->id);
		DB::table('tbl_templates_'.$perentid)->where('id','=',$id)->delete();
		}
		else if($userrole=='auditor')
		{
		$perentid = getPerentId(Auth::user()->id);
		DB::table('tbl_templates_'.$perentid)->where('id','=',$id)->delete();
		}
		return redirect('/template')->with('message','Successfully Deleted');
    }
	
	public function destroyClient($id)
    {	
		$userrole=Auth::user()->role;
		
		if($userrole == 'admin')
		{
		$perentid = getPerentId(Auth::user()->id);
		DB::table('tbl_templates_'.$perentid)->where('id','=',$id)->delete();
		}
		else if($userrole=='auditor')
		{
		$perentid = getPerentId(Auth::user()->id);
		DB::table('tbl_templates_'.$perentid)->where('id','=',$id)->delete();
		}
		return redirect('/client_company')->with('message','Successfully Deleted');
    }
	
	public function edit($id)
    {
		$editid = $id;
		$userrole=Auth::user()->role;
		
		if($userrole == 'admin')
		{
		$perentid = getPerentId(Auth::user()->id);
        $tbl_templates = Db::table('tbl_templates_'.$perentid)->where('id','=',$id)->first();
		}
		else if($userrole=='auditor')
		{
		$perentid = getPerentId(Auth::user()->id);
		$tbl_templates = Db::table('tbl_templates_'.$perentid)->where('id','=',$id)->first();
		}
		return view('template.template_edit_data',compact('tbl_templates','editid'));
    }
	
	public function editClient($id)
    {
		$editClient = $id;
		$userrole=Auth::user()->role;
		
		if($userrole == 'admin')
		{
		$perentid = getPerentId(Auth::user()->id);
        $tbl_templates = Db::table('tbl_templates_'.$perentid)->where('id','=',$id)->first();
		}
		else if($userrole=='auditor')
		{
		$perentid = getPerentId(Auth::user()->id);
		 $tbl_templates = Db::table('tbl_templates_'.$perentid)->where('id','=',$id)->first();
		}
		return view('template.client_edit_data',compact('tbl_templates','editClient'));
    }
	
	public function update(Request $request, $id)
    {
		
		$template_name = $request->input('template_name');
		$company_name = $request->input('company_name');
		$temptype='o';
        	$filename ="";
		if(Input::hasFile('image'))
			{
				$file= Input::file('image');
				$filename->auditorclogo=$file->getClientOriginalName();
				
				$file->move(public_path().'/company_logo/', $file->getClientOriginalName());
				
			}
		$userid= Auth::user()->id;
		$perentid = getPerentId(Auth::user()->id);
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d H:i:s');
		DB::update("update tbl_templates_$perentid set tempname='$template_name',auditorcname='$company_name',temptype='$temptype',auditorclogo='$filename',updated_at='$date' where id='$id'");
		return redirect('/template')->with('message','Successfully Updated');
	}
	
	public function updateClient(Request $request, $id)
    {
		
		$template_name = $request->input('template_name');
		$company_name = $request->input('company_name');
		$temptype='c';
                $auditor_company_name = $request->input('auditor_company_name');
		$filename1 ="";
		$filename2 ="";
		if(Input::hasFile('image'))
			{
				$file= Input::file('image');
				$filename1=$file->getClientOriginalName();
				$file->move(public_path().'/company_logo/', $file->getClientOriginalName());
			}
		
		if(Input::hasFile('image1'))
			{
				$file1= Input::file('image1');
				$filename2=$file1->getClientOriginalName();
				$file1->move(public_path().'/client_logo/', $file1->getClientOriginalName());
			}
			
		$userid= Auth::user()->id;
		$perentid = getPerentId(Auth::user()->id);
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d H:i:s');
		DB::update("update tbl_templates_$perentid set tempname='$template_name',auditorcname='$company_name',temptype='$temptype',auditorclogo='$filename1',clientcname='$auditor_company_name',clientclogo='$filename2',updated_at='$date' where id='$id'");
		return redirect('/client_company')->with('message','Successfully Updated');
	}
}
