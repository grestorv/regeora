<?php


namespace App\Services;


use App\Jobs\ProcessPatient;
use App\Models\Cache\Interfaces\PatientCacheInterface;
use App\Models\Patient;
use App\Services\Interfaces\PatientServiceInterface;
use Carbon\Carbon;

class PatientService implements PatientServiceInterface
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
     * @param string $firstName
     * @param string $lastName
     * @param Carbon $birthdate
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function createFromBirthdate(string $firstName, string $lastName, Carbon $birthdate)
    {
        $birthdateDiffNow = collect($birthdate->diffAsCarbonInterval(Carbon::now()))
            ->intersectByKeys(array_flip(['y', 'm', 'd']))
            ->filter();// возможен пустой массив
        $ageType = $birthdateDiffNow->keys()->first() ?? 'd';
        $ageScalar = $birthdateDiffNow->first() ?? '0';
        return $this->create($firstName, $lastName, $birthdate, $ageType, $ageScalar);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param Carbon $birthdate
     * @param string $ageType
     * @param int $ageScalar
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(string $firstName, string $lastName, Carbon $birthdate, string $ageType, int $ageScalar)
    {
        $data['birthdate'] = $birthdate->toDateString();
        $model = (new Patient)->newQuery()->create(
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'birthdate' => $birthdate,
                'age_type' => $ageType,
                'age' => $ageScalar,
            ]
        );
        $this->patientCache->addToCache($model);
        ProcessPatient::dispatch($model);
        return $model;
    }

}
