<?php


namespace App\ViewModels;


use App\Models\Patient;
use App\ViewModels\Interfaces\PatientViewModelInterface;

class PatientIndexViewModel implements PatientViewModelInterface
{
    /**
     * @var Patient
     */
    private $patientModel;
    /**
     * @var array
     */
    private $viewModel;

    public function __construct(Patient $patient)
    {
        $this->patientModel = $patient;
        $this->viewModel =
            [
                'name' => $this->getFullName(),
                'birthdate' => $patient->birthdate->format('d.m.Y'),
                'age' => $this->getLocalizedAge(),
            ];
    }

    public function toArray()
    {
        return $this->viewModel;
    }

    private function getFullName(){
        return $this->patientModel->first_name . ' ' . $this->patientModel->last_name;
    }

    private function getLocalizedAge()
    {

        return $this->patientModel->age . ' ' . $this->patientModel::AGE_TYPES[$this->patientModel->age_type];
    }
}
