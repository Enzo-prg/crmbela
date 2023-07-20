<?php

namespace App\Http\Livewire;

use App\Models\Country;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class Countries extends SearchableComponent
{
    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /**
     * @return string
     */
    public function model()
    {
        return Country::class;
    }

    /**
     * @return string[]
     */
    public function searchableFields()
    {
        return ['name'];
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $countries = $this->searchServices();

        return view('livewire.countries', compact('countries'));
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchServices()
    {
        $this->getQuery();

        return $this->paginate();
    }
}
