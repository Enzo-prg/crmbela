<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\Setting;
use App\Repositories\ContractRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Class ContractController
 */
class ContractController extends AppBaseController
{
    /**
     * @var ContractRepository
     */
    private $contractRepository;

    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    /**
     * Display a listing of the Contract.
     *
     * @return Factory|View
     */
    public function index()
    {
        $typeArr = ContractType::orderBy('name', 'asc')->pluck('name', 'id');

        return view('clients.contracts.index', compact('typeArr'));
    }

    /**
     * @param  Contract  $contract
     *
     * @return Factory|View
     */
    public function viewAsCustomer(Contract $contract)
    {
        $contract = $this->contractRepository->find($contract->id);
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('clients.contracts.view_as_customer', compact('contract', 'settings'));
    }

    /**
     * @param  Contract  $contract
     *
     * @return mixed
     */
    public function convertToPdf(Contract $contract)
    {
        $contract = $this->contractRepository->find($contract->id);
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $pdf = PDF::loadView('clients.contracts.contract_pdf', compact('contract', 'settings'));

        return $pdf->download($contract->subject.'.pdf');
    }

    /**
     * @return Application|Factory|\Illuminate\View\View
     */
    public function contractSummary()
    {
        $customerId = Auth::user()->contact->customer->id;
        $contracts = Contract::whereCustomerId($customerId)->get();

        $contractTypeIds = [];
        foreach ($contracts as $contract) {
            $contractTypeIds[] = $contract->contract_type_id;
        }

        $contractTypes = ContractType::withCount('contractsCustomer')->whereIn('id', $contractTypeIds)->get();

        return view('clients.contracts.contract_summary', compact('contractTypes'));
    }
}
