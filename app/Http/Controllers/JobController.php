<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show', 'index']]);
    }

    public function index()
    {
        if(auth()->check()) {
            return response()->json([
                'warning' => '',
                'jobs' => Job::where('status', 1)->paginate(10, ['id', 'title', 'description', 'companyName', 'expirationDate', 'email', 'phone', 'status'])
            ]);
        }

        return response()->json([
            'warning' => 'You must log in to view email and phone numbers.',
            'jobs' => Job::where('status', 1)->paginate(10, ['id', 'title', 'description', 'companyName', 'expirationDate', 'status'])
        ]);
    }

    public function store(JobRequest $request)
    {
        $data = $request->all();

        try{
            $job = Job::create($data);
        }catch(\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Your job was successfully created',
            'job-details' => $job
        ], 201);

    }


    public function show(Job $job)
    {
        if($job->status === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job not found or is no longer active'
            ], 404);
        }

        return $job->only(['id', 'title', 'description', 'companyName', 'expirationDate', 'email', 'phone', 'status']);
    }

    public function update(JobRequest $request, Job $job)
    {
        if(($job->user_id != auth()->user()->id)) {
            return response()->json(['error' => 'Operation unauthorized'], 401);
        }

        try{
            $job->update($request->all());
        }catch(\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Your job was successfully updated',
            'job-details' => $job
        ]);
    }

    public function destroy(Job $job)
    {
        if (($job->user_id != auth()->user()->id)) {
            return response()->json(['error' => 'Operation unauthorized'], 401);
        }

        try{
            $job->delete();
        }catch(\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Your job was successfully deleted'
        ]);
    }
}
