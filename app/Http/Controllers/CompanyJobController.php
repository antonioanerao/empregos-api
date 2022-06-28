<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\CompanysJob;

class CompanyJobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show', 'index']]);
    }

    public function index()
    {
        if(CompanysJob::count() < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'No jobs found'
            ], 404);
        }

        if(auth()->check()) {
            return response()->json([
                'warning' => '',
                'jobs' => CompanysJob::where('status', 1)->paginate(10, ['id', 'title', 'description', 'companyName', 'expirationDate', 'email', 'phone', 'status'])
            ]);
        }

        return response()->json([
            'warning' => 'You must log in to view email and phone numbers.',
            'jobs' => CompanysJob::where('status', 1)->paginate(10, ['id', 'title', 'description', 'companyName', 'expirationDate', 'status'])
        ]);
    }

    public function store(JobRequest $request)
    {
        $data = $request->all();

        try{
            $job = CompanysJob::create($data);
        }catch(\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Your job was successfully created',
            'job-details' => $job
        ], 201);

    }

    public function show(CompanysJob $job)
    {
        if($job->status === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'CompanysJob not found or is no longer active'
            ], 404);
        }

        return $job->only(['id', 'title', 'description', 'companyName', 'expirationDate', 'email', 'phone', 'status']);
    }

    public function update(JobRequest $request, CompanysJob $job)
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

    public function destroy(CompanysJob $job)
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
