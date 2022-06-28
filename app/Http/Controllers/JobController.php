<?php

namespace App\Http\Controllers;

use App\Models\CompanysJob;

/**
 * @property CompanysJob $companysJob
 */
class JobController extends Controller
{
    public function __construct(CompanysJob $job) {
        $this->companysJob = $job;
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
                'jobs' => CompanysJob::where('status', 1)->paginate(10, [
                    'id', 'title', 'description', 'companyName', 'expirationDate', 'email', 'phone', 'status'
                ])
            ]);
        }

        return response()->json([
            'warning' => 'You must log in to view email and phone numbers.',
            'jobs' => CompanysJob::where('status', 1)->paginate(10, [
                'id', 'title', 'description', 'companyName', 'expirationDate', 'status'
            ])
        ]);
    }

    public function show(CompanysJob $job)
    {
        if($job->status === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'CompanysJob not found or is no longer active'
            ], 404);
        }

        if(auth()->check()) {
            return response()->json([
                'warning' => '',
                'jobs' => $job->only([
                    'id', 'title', 'description', 'companyName', 'expirationDate', 'email', 'phone', 'status'
                ])
            ]);
        }

        return response()->json([
            'warning' => 'You must log in to view email and phone numbers.',
            'jobs' => $job->only(['id', 'title', 'description', 'companyName', 'expirationDate', 'status'])
        ]);
    }
}
