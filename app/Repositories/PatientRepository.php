<?php


namespace App\Repositories;


use App\Models\Cache\Interfaces\PatientCacheInterface;
use App\Models\Patient;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\ViewModels\Interfaces\PatientViewModelInterface;
use Illuminate\Support\Collection;

class PatientRepository implements PatientRepositoryInterface
{
    /**
     * @var PatientCacheInterface
     */
    private $patientCache;

    public function __construct(PatientCacheInterface $patientCache)
    {
        $this->patientCache = $patientCache;
    }

    /**
     * @return Collection<Patient>
     */
    public function all()
    {
        if ($this->patientCache->hasCache()) {
            $patients = $this->patientCache->getAllPatients();
        } else {
            $patients = Patient::all()->collect();
            $this->patientCache->saveToCache($patients);
        }

        return $patients;
    }

    public function getFormattedPatients($viewModelClass)
    {
        $patients = $this->all();
        $formattedCollection = collect();
        /** @var Patient $patient */
        foreach ($patients as $patient) {
            $formattedCollection->add(
                (new $viewModelClass($patient))->toArray()
            );
        }
        return $formattedCollection;
    }
}
