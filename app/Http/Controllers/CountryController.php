<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Address;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Lead;
use App\Repositories\CountryRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CountryController extends AppBaseController
{
    /** @var CountryRepository */
    private $countryRepo;

    public function __construct(CountryRepository $countryRepo)
    {
        $this->countryRepo = $countryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('countries.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCountryRequest  $request
     *
     * @return Response
     */
    public function store(CreateCountryRequest $request)
    {
        $input = $request->all();
        $country = $this->countryRepo->create($input);

        activity()->performedOn($country)->causedBy(getLoggedInUser())
            ->useLog('New Country created.')->log($country->name.' Country created.');

        return $this->sendSuccess('Country saved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Country  $country
     * @return Response
     */
    public function edit(Country $country)
    {
        return $this->sendResponse($country, 'Country retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCountryRequest  $request
     * @param  Country  $country
     * @return Response
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $input = $request->all();
        $country = $this->countryRepo->update($input, $country->id);

        activity()->performedOn($country)->causedBy(getLoggedInUser())
            ->useLog('Country updated.')->log($country->name.' Country updated.');

        return $this->sendSuccess('Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Country  $country
     * @throws Exception
     * @return Response
     */
    public function destroy(Country $country)
    {
        $customerCountry = Customer::whereCountry($country->id)->exists();
        $leadCountry = Lead::whereCountry($country->id)->exists();
        $addressCountry = Address::whereCountry($country->id)->exists();

        if ($customerCountry || $leadCountry || $addressCountry) {
            return $this->sendError('Country used somewhere else.');
        }

        $country = $country->delete();

        return $this->sendSuccess('Country deleted successfully.');
    }
}
