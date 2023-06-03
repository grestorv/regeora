<?php


namespace App\Models\Cache;


use App\Models\Cache\Interfaces\PatientCacheInterface;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class PatientCache implements PatientCacheInterface
{

    /**
     * @return Collection|null
     */
    public function getAllPatients()
    {
        return Cache::get(self::KEY, null);
    }

    /**
     * @param Collection $patients
     */
    public function saveToCache(Collection $patients)
    {
        Cache::put(self::KEY, $patients, self::TTL);
    }

    public function hasCache()
    {
        return Cache::has(self::KEY);
    }

    public function addToCache(Model $patient)
    {
        if ($this->hasCache()) {
            $patients = $this->getAllPatients();
            $patients->add($patient);
            $this->saveToCache($patients);
        }
    }
}
