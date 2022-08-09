<?php

namespace App\Services;

use App\Models\CompanysJob;

class CompanysJobService
{
    public function storeNewCompanysJob(
        string $title,
        string $description,
        ?string $companyName,
        ?string $email,
        ?string $phone,
        ?string $expirationDate): CompanysJob
    {
        return CompanysJob::create([
            'title' => $title,
            'description' => $description,
            'companyName' => $companyName,
            'email' => $email,
            'phone' => $phone,
            'expirationDate' => $expirationDate
        ]);
    }
}
