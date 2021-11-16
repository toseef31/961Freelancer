<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Skills;
use App\Models\Job;
use App\Models\Category;
use App\Models\Countries;
use App\Models\Proposal;
use App\Models\Milestone;
use App\Models\Rating;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Str;
use Hash;
use Session;
use Mail;
use Redirect;

class ProposalController extends Controller
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
      $request->validate([
          'cover_letter' => 'required',
          'duration' => 'required',
      ]);
      // dd($request->all());
      $proposal = new Proposal;
      $proposal->job_id = $request->input('job_id');
      $proposal->user_id = auth()->user()->id;
      $proposal->budget = $request->input('budget');
      $proposal->budget_receive = $request->input('budget_receive');
      $proposal->service_fee = $request->input('service_fee');
      $proposal->cover_letter = $request->input('cover_letter');
      $proposal->proposal_type = $request->input('proposal_type');
      $proposal->duration = $request->input('duration');
      $proposal->status = 1;
      $images=array();
      if($files=$request->file('attachments')){
        foreach($files as $file){
          $imagename= 'proposal-'.rand(000000,999999).'.'.$file->getClientOriginalExtension();
          $extension= $file->getClientOriginalExtension();
          // $imagename= $filename;
          $destinationpath= public_path('assets/images/proposal/');
          $file->move($destinationpath, $imagename);

          $images[]=$imagename;
        }
      }
      $proposal->attachments = implode(",",$images);
      
      $freelancer = User::where('id',auth()->user()->id)->first();
      $jobUser = Job::where('job_id',$request->input('job_id'))->first();
      $client = User::where('id',$jobUser->user_id)->first();
      $toemail = $client->email;
      if ($proposal->save()) {
        if($request->proposal_type == 'by_milestone'){
          if ($request->milestone_detail && $request->milestone_due_date && $request->milestone_amount) {
              for ($i = 0; $i < count($request->milestone_detail); $i++) {
                  Milestone::create([
                      'proposal_id' => $proposal->id,
                      'job_id' => $request->job_id,
                      'user_id' => auth()->id(),
                      'detail' => $request->milestone_detail[$i],
                      'milestone_amount' => $request->milestone_amount[$i],
                      'due_date' => $request->milestone_due_date[$i],
                      'status' => 'request',
                  ]);
              }
          }
        }
        Notification::create([
          'from' => auth()->id(),
          'to' => $client->id,
          'message' => $freelancer->username .' sent proposal on your project "'. $jobUser->job_title .'"',
          'noti_type' => 'proposal',
          'status' => 'unread',
        ]);
        Mail::send('mail.propsalsubmit-email',['user' =>$freelancer,'job' => $jobUser, 'client'=>$client],
        function ($message) use ($toemail)
        {
          $message->subject('961Freelancer - Proposal Submit');
          $message->from('support@961freelancer.com', '961Freelancer');
          $message->to($toemail);
        });
        return redirect()->route('job.show', $request->job_id)->with('message', 'Bid Placed Successfully!');
      } else {
        return redirect()->route('job.show', $request->job_id)->with('error', 'Something wrong please check details again');
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function jobProposal(Request $request,$id){
      $job = Job::where('job_id',$id)->first();
      return View::make('frontend.job-proposal')->with([
        'jobData' => $job
      ]);
    }

    public function allProposalClient(Request $request){
      $user_id = auth()->user()->id;
      $job = Job::with('proposal','clientInfo')->whereuser_id($user_id)->orderBy('created_at','DESC')->paginate(5);

      $proposals = Proposal::with('job','rating')->withCount('rating')->whereuser_id($user_id)->orderBy('created_at','DESC')->paginate(5);

      $freelancerrating = Rating::where('rating_to',$user_id)->get();
      $rating_avg = 0.0;
      $total = 0;
      foreach($freelancerrating as $rate){
        $total += $rate->general_rating;
        $rating_avg = $total/count($freelancerrating);
      }
      return View::make('frontend.proposal')->with([
        'jobData' => $job,
        'proposals' => $proposals,
        'rating' => $rating_avg
      ]);
    }

    public function hireFreelancer(Request $request){
      $id = $request->proposal_id;
      $job_id = $request->job_id;
      $findData = Proposal::find($id);
      $job = Job::where('job_id',$job_id)->first();
      $findData->status = 2;
      $freelancer = User::where('id',$findData->user_id)->first();
      $toemail =  $freelancer->email;
      Job::where('job_id',$job_id)->update(['job_status'=>2]);
      if ($findData->save()) {
        Notification::create([
          'from' => auth()->id(),
          'to' => $findData->user_id,
          'message' => 'You have been hired for the project "'. $job->job_title .'"',
          'noti_type' => 'hire',
          'status' => 'unread',
        ]);
        Mail::send('mail.hired-email',['user' =>$freelancer,'job' => $job],
        function ($message) use ($toemail)
        {
          $message->subject('961Freelancer - Hired By Client');
          $message->from('support@961freelancer.com', '961Freelancer');
          $message->to($toemail);
        });
        return response()->json(['status'=>'true' , 'message' => 'Freelancer Hired'] , 200);
      }else{
           return response()->json(['status'=>'errorr' , 'message' => 'error occured please try again'] , 200);
      }
    }

    public function rejectFreelancer(Request $request){
      $id = $request->proposal_id;
      $job_id = $request->job_id;
      $findData = Proposal::find($id);
      $job = Job::where('job_id',$job_id)->first();
      $findData->status = 3;
      $freelancer = User::where('id',$findData->id)->first();
      $toemail =  $freelancer->email;
      Job::where('job_id',$job_id)->update(['job_status'=>1]);
      if ($findData->save()) {
        Notification::create([
          'from' => auth()->id(),
          'to' => $findData->user_id,
          'message' => 'You proposal has been rejected for this "'. $job->job_title.'" project.',
          'noti_type' => 'reject',
          'status' => 'unread',
        ]);
        Mail::send('mail.rejectProposal-email',['user' =>$freelancer,'job' => $job],
        function ($message) use ($toemail)
        {
          $message->subject('961Freelancer - Rejected By Client');
          $message->from('support@961freelancer.com', '961Freelancer');
          $message->to($toemail);
        });
          return response()->json(['status'=>'true' , 'message' => 'Freelancer proposal rejected'] , 200);
      }else{
           return response()->json(['status'=>'errorr' , 'message' => 'error occured please try again'] , 200);
      }
    }


    public function projectStatus(Request $request){

      // dd($request->all());
      $proposal_id = $request->proposal_id;
      $job_id = $request->job_id;
      $findData = Proposal::find($proposal_id);
      if($request->project_status == 2){
        $proposal_status = 2;
      }else if($request->project_status == 3){
        $proposal_status = 3;
      }else{
        $proposal_status = 5;
      }
      $findData->status = $proposal_status;
      Job::where('job_id',$job_id)->update(['job_status'=>$request->project_status]);
      if ($findData->save()) {
          return response()->json(['status'=>'true' , 'message' => 'Project Status updated', 'job_id' => $job_id, 'job_status' => $proposal_status] , 200);
      }else{
           return response()->json(['status'=>'errorr' , 'message' => 'error occured please try again'] , 200);
      }
    }
    
}
