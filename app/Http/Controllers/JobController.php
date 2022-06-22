<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
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
        if($job->user_id != auth()->user()->id) {
            return response()->json(['error' => 'Operation unauthorized'], 401);
        }

        return response()->json([
            'status' => 'success',
            'job-details' => $job
        ]);
    }

    public function edit(Job $job)
    {
        //
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
}
