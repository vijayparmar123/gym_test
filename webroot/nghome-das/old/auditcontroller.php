<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;

use App\tbl_projects;
use App\tbl_options;
use App\tbl_project_qreviews;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\User;

class auditcontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
   
    public function index()
    {	
		$perentid = getPerentId(Auth::user()->id);
		$template = DB::table('tbl_templates_'.$perentid)->get();
		$location = DB::table('tbl_locations_'.$perentid)->get();
		$question = DB::table('tbl_questionnairs_'.$perentid)->get();
		$catrgories = DB::table('tbl_categorys_'.$perentid)->get();
		
        return view('audit.createaudit',compact('location','template','question','catrgories'));
		
    }

   
    public function getrecord()
    {
		$perentid = getPerentId(Auth::user()->id);
        $tid = Input::get('tmp_id');
		$t_record = DB::table('tbl_templates_'.$perentid)->where('id','=',$tid)->first();
		$record = json_encode($t_record);
		
		echo $record;
    }
	public function storeanswer()
    {
		$perentid = getPerentId(Auth::user()->id);
        $answer = Input::get('answer');
		$project_id = Input::get('project_id');
		if($answer == 0)
			{
					DB::update("update tbl_project_qreviews_$perentid set problem='' where id='$project_id'");
		
	}
		
       
		DB::update("update tbl_project_qreviews_$perentid set answer='$answer' where id='$project_id'");
		
		
			
    }
	
	public function storeanswers(Request $request)
	{
		$project_id = Input::get('que_id');
		$comment = Input::get('coment');
		$perentid = getPerentId(Auth::user()->id);
		
		if(!empty(Input::get('option'))){
			 //$name = $request->input('location_name');
		$option = implode(',',Input::get('option'));
		
		}
		else{
			$option="";
		}
		$attachment ="";
		 if(Input::hasFile('image'))
			 {
				 
				$file= Input::file('image');
				$file->move(public_path().'/attachment/', $file->getClientOriginalName());
				$attachment =$file->getClientOriginalName();
				
              }

			
		DB::update("UPDATE `tbl_project_qreviews_$perentid` SET `comment` ='$comment', `attachment` ='$attachment',`option` = '$option' WHERE `id` = $project_id");
		
		
	}
	
	
	public function storeproblem()
    {
		$perentid = getPerentId(Auth::user()->id);
        $problem = Input::get('problem');
        $project_id = Input::get('project_id');

		DB::update("update tbl_project_qreviews_$perentid set problem='$problem' where id='$project_id'");
		
		
	}
	public function getauditdata()
    {
		$perentid = getPerentId(Auth::user()->id);
        $temp_id = Input::get('tmp_val');
        $loc_id = Input::get('location_id');
        $iso_questionnaire_id = Input::get('iso_questionnaire');
		$projects = DB::table('tbl_projects_'.$perentid)->where([['tempid','=',$temp_id],['locid','=',$loc_id],['qid','=',$iso_questionnaire_id]])->get();
		$projects_count = DB::table('tbl_projects_'.$perentid)->where([['tempid','=',$temp_id],['locid','=',$loc_id],['qid','=',$iso_questionnaire_id]])->count();
		if($projects_count>0){
		?>
		
		<option value="">Select Previous Project</option>
		<?php foreach($projects as $projectss)
		{?>
			<option value="<?php echo $projectss->id; ?>"><?php echo $projectss->auditedby.' '.date('d-m-Y',strtotime($projectss->created_at)); ?></option>
		<?php } }else{
		$data = 0;
		echo $data;
			}?>
		
		<?php	
	}

    public function store(Request $request)
    {
		$perentid = getPerentId(Auth::user()->id);
		$locid = Input::get('loc_id');
		$ldata = DB::table('tbl_locations_'.$perentid)->where('id','=',$locid)->first();
		$locname = $ldata->locname;
		
		$temp_id = Input::get('template_id');
		$tdata = DB::table('tbl_templates_'.$perentid)->where('id','=',$temp_id)->first();
		$tempname = $tdata->tempname;
		$ttype =  $tdata->temptype;
        
		
		
		$qid = Input::get('iso_questionnaire');
		$auditor_c_name=Input::get('auditor_company_name');
		$t_type=$ttype;
		$status=0;
		$auditor_c_logo=Input::get('auditor_logo');;
		$auditedby=Input::get('auditedby');
		$client_c_name=Input::get('client_company_name');
		$client_c_logo=Input::get('client_c_logo');
		$audit_type=Input::get('select_type');
        $categoryid=Input::get('select_category');		
		$uid = Auth::user()->id;
		$sql = DB::insert("insert into tbl_projects_$perentid (tempid,t_name,locid,l_name,qid,auditor_c_name,t_type,status,auditor_c_logo,auditedby,client_c_name,client_c_logo,audit_type,categoryid,uid)
		values('$temp_id','$tempname','$locid','$locname','$qid','$auditor_c_name','$t_type','0','$auditor_c_logo','$auditedby','$client_c_name','$client_c_logo','$audit_type','$categoryid','$uid')");
		
		$projectlastid = DB::table('tbl_projects_'.$perentid)->orderBy('id','=','desc')->first();
		$lastprojectid = $projectlastid->id;
		$catid = Input::get('select_category');	
		$questionnari = Input::get('iso_questionnaire');
		$audittype = Input::get('select_type');
		if($audittype==2)
		{
			
			
			$pre_audit_id = Input::get('previous_project_id');
			DB::update("update tbl_projects_$perentid set pre_audit_id='$pre_audit_id' where id='$lastprojectid'");
		
			
			$privous_project_id = Input::get('previous_project_id');
			$project_option = Input::get('project_option');
			
			if($project_option=='all')
			{
				$select_new_project = DB::table('tbl_project_qreviews_'.$perentid)->where('pid','=',$privous_project_id)->get();
				
				if(!empty($select_new_project))
				 {
					 // foreach($select_new_project as $select_new_projects)
					 // {
						
						 // $qid = $select_new_projects->qid;
						// $que_id=$select_new_projects->que_id;
						// $sid=$select_new_projects->sid;
						$sql = DB::insert("insert into tbl_project_qreviews_$perentid (pid,qid,que_id,sid)
		SELECT $lastprojectid,qid,que_id,sid FROM tbl_project_qreviews_$perentid where pid=$privous_project_id");
						// $sql = DB::insert("insert into tbl_project_qreviews_$perentid (pid,qid,que_id,sid)
		 //values('$lastprojectid','$qid','$que_id','$sid')");
						
						
					// }
					
				 }
			}elseif($project_option==0)
			{
				
					$select_new_project = DB::table('tbl_project_qreviews_'.$perentid)->where([['pid','=',$privous_project_id],['answer','=',1]])->get();
					if(!empty($select_new_project))
				{
					// foreach($select_new_project as $select_new_projects)
					// {
						
						
						// $qid=$select_new_projects->qid;
						// $que_id=$select_new_projects->que_id;
						// $sid=$select_new_projects->sid;
						$sql = DB::insert("insert into tbl_project_qreviews_$perentid (pid,qid,que_id,sid)
		SELECT $lastprojectid,qid,que_id,sid FROM tbl_project_qreviews_$perentid where pid=$privous_project_id");
						//$sql = DB::insert("insert into tbl_project_qreviews_$perentid (pid,qid,que_id,sid)
		//values('$lastprojectid','$qid','$que_id','$sid')");
						
					// }
					
				}
				
			}elseif($project_option==1)
			{
				
				
					$select_new_project = DB::table('tbl_project_qreviews_'.$perentid)->where([['pid','=',$privous_project_id],['answer','=',0]])->get();
					
					if(!empty($select_new_project))
				{
					// foreach($select_new_project as $select_new_projects)
					// {
						// $rproject = new tbl_project_qreviews;
						
						// $qid=$select_new_projects->qid;
						// $que_id=$select_new_projects->que_id;
						// $sid=$select_new_projects->sid;
						$sql = DB::insert("insert into tbl_project_qreviews_$perentid (pid,qid,que_id,sid)
		SELECT $lastprojectid,qid,que_id,sid FROM tbl_project_qreviews_$perentid where pid=$privous_project_id");
						//$sql = DB::insert("insert into tbl_project_qreviews_$perentid (pid,qid,que_id,sid)
		//values('$lastprojectid','$qid','$que_id','$sid')");
						
					// }
					
				}
				
					
			}
			
		}else{
			
		if($catid>0){
		$qustinarriedata = DB::table('tbl_sections_'.$perentid)->where([['qid','=',$questionnari],['catid','=',$catid]])->get();
		}
		if($catid=='all')
		{
			$qustinarriedata = DB::table('tbl_sections_'.$perentid)->where('qid','=',$questionnari)->get();
			
		}
		
		if(!empty($qustinarriedata))
		{
			foreach($qustinarriedata as $qustinarriedatas)
			{
				$sid = $qustinarriedatas->id;
				$qid = $qustinarriedatas->qid;
				
				$tbl_questions = DB::table('tbl_questions_'.$perentid)->where([['qid','=',$qid],['sid','=',$sid]])->get();
				if(!empty($tbl_questions))
				foreach($tbl_questions as $tbl_questionss)
				{
				 
				 $pid=$lastprojectid;
				 $qid=$tbl_questionss->qid;
				 $que_id=$tbl_questionss->id;
				 $sid=$tbl_questionss->sid;
				 // $privous_project_id = Input::get('previous_project_id');
				 
				 // $sql = DB::insert("insert into tbl_project_qreviews_$perentid (pid,qid,que_id,sid)
		// SELECT $lastprojectid,qid,que_id,sid FROM tbl_project_qreviews_$perentid where `pid`=$privous_project_id");
		
				 $sql = DB::insert("insert into tbl_project_qreviews_$perentid (pid,qid,que_id,sid)
		values('$lastprojectid','$qid','$que_id','$sid')");
				 }
				
			}
		}
		}
		$qreview = DB::table('tbl_project_qreviews_'.$perentid)->where('pid','=',$lastprojectid)->groupby('sid')->get();
		$option = DB::table('tbl_options_'.$perentid)->get();
		$project=Db::table('tbl_projects_'.$perentid)->get();
		return view('audit.question',compact('qreview','lastprojectid','option','project'));
    }
	 
	public function storeQuestion(Request $request,$id)
	{	
		$perentid = getPerentId(Auth::user()->id);
		$status_prograse=Input::get('group_composite');
		$notes=Input::get('notes');
		$sql = DB::update("update tbl_projects_$perentid set status_prograse='$status_prograse',notes='$notes' where id='$id'");
		return redirect('/ManageAudit')->with('message','SuccessFully Saved');
	}

    
   
}
