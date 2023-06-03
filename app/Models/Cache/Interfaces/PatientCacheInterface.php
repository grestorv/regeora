<?php


namespace App\Models\Cache\Interfaces;


use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PatientCacheInterface
{
    public const KEY = 'patients';
    public const TTL = 300;

    public function getAllPatients();
    public function saveToCache(Collection $patients);
    public function hasCache();
    public function addToCache(Model $patient);

}
