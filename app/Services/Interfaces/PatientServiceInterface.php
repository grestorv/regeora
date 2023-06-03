<?php


namespace App\Services\Interfaces;


use Carbon\Carbon;

interface PatientServiceInterface
{
    public function create(string $firstName, string $lastName, Carbon $birthdate, string $ageType, int $ageScalar);
}
