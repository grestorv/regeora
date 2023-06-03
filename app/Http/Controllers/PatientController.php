<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Services\Interfaces\PatientServiceInterface;
use App\ViewModels\PatientIndexViewModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    /**
     * @var PatientRepositoryInterface
     */
    private $patientRepository;
    /**
     * @var PatientServiceInterface
     */
    private $patientService;

    public function __construct(PatientRepositoryInterface $patientRepository, PatientServiceInterface $patientService)
    {
        $this->patientRepository = $patientRepository;
        $this->patientService = $patientService;
    }

    public function index()
    {
        return $this->patientRepository->getFormattedPatients(PatientIndexViewModel::class);
    }

    public function create(CreatePatientRequest $request)
    {
        list('first_name' => $firstName, 'last_name' => $lastName, 'birthdate' => $birthdate) = $request->validated();
        $birthdate = Carbon::createFromFormat('d.m.Y', $birthdate);
        $this->patientService->createFromBirthdate($firstName, $lastName, $birthdate);
    }
}
