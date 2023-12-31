<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\CreateProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Proposal;
use App\Models\Reminder;
use App\Models\Setting;
use App\Models\Task;
use App\Repositories\ProposalRepository;
use App\Repositories\TicketRepository;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Redirect;
use Throwable;

class ProposalController extends AppBaseController
{
    /** @var ProposalRepository */
    private $proposalRepository;

    public function __construct(ProposalRepository $proposalRepo)
    {
        $this->proposalRepository = $proposalRepo;
    }

    /**
     * Display a listing of the Proposal.
     *
     * @return Factory|View
     */
    public function index()
    {
        $statusArr = Proposal::STATUS;

        return view('proposals.index', compact('statusArr'));
    }

    /**
     * Show the form for creating a new Proposal.
     *
     * @param  null  $relatedTo
     *
     * @return Factory|View
     */
    public function create($relatedTo = null)
    {
        $data = $this->proposalRepository->getSyncList();

        return view('proposals.create', compact('data', 'relatedTo'));
    }

    /**
     * Store a newly created Proposal in storage.
     *
     * @param  CreateProposalRequest  $request
     *
     * @throws Throwable
     *
     * @return JsonResponse
     */
    public function store(CreateProposalRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();

            if (array_sum($input['quantity']) > 9999999) {
                return $this->sendError('Quantity is not greater than 9999999');
            }

            $proposal = $this->proposalRepository->saveProposal($input);
            DB::commit();

            Flash::success('Proposal saved successfully.');

            return $this->sendResponse($proposal, 'Proposal created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified Proposal.
     *
     * @param  Proposal  $proposal
     *
     * @return Factory|View
     */
    public function show(Proposal $proposal)
    {
        $proposal = $this->proposalRepository->getSyncListForProposalDetail($proposal->id);

        /** @var TicketRepository $ticketRepo */
        $ticketRepo = App::make(TicketRepository::class);
        $data = $ticketRepo->getReminderData($proposal->id, Proposal::class);
        $notifiedReminder = Reminder::IS_NOTIFIED;
        $status = Task::STATUS;
        $priorities = Task::PRIORITY;
        $groupName = (request('group') === null) ? 'proposal_details' : (request('group'));

        return view("proposals.views.$groupName",
            compact('proposal', 'data', 'notifiedReminder', 'status', 'priorities', 'groupName'));
    }

    /**
     * Show the form for editing the specified Proposal.
     *
     * @param  Proposal  $proposal
     *
     * @return Factory|View
     */
    public function edit(Proposal $proposal)
    {
        if ($proposal->status == App\Models\Proposal::STATUS_DECLINED) {
            return redirect()->back();
        }
        $data = $this->proposalRepository->getSyncList();
        $proposal = $this->proposalRepository->getSyncListForProposalDetail($proposal->id);

        return view('proposals.edit', compact('data', 'proposal'));
    }

    /**
     * Update the specified Proposal in storage.
     *
     * @param  Proposal  $proposal
     *
     * @param  UpdateProposalRequest  $request
     *
     * @throws Throwable
     *
     * @return JsonResponse
     */
    public function update(Proposal $proposal, UpdateProposalRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();

            if (array_sum($input['quantity']) > 9999999) {
                return $this->sendError('Quantity is not greater than 9999999');
            }

            $proposal = $this->proposalRepository->updateProposal($input, $proposal->id);
            DB::commit();

            Flash::success('Proposal updated successfully.');

            return $this->sendResponse($proposal, 'Proposal created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified Proposal from storage.
     *
     * @param  Proposal  $proposal
     *
     * @throws Throwable
     *
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(Proposal $proposal)
    {
        try {
            DB::beginTransaction();
            $this->proposalRepository->deleteProposal($proposal);
            DB::commit();

            return $this->sendSuccess('Proposal deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return Redirect::back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param  Proposal  $proposal
     *
     * @param  Request  $request
     *
     * @return mixed
     */
    public function changeStatus(Proposal $proposal, Request $request)
    {
        $this->proposalRepository->changeProposalStatus($proposal->id, $request->get('status'));

        return $this->sendSuccess('Proposal status updated successfully.');
    }

    /**
     * @param  Proposal  $proposal
     *
     * @return Factory|View
     */
    public function viewAsCustomer(Proposal $proposal)
    {
        $proposal = $this->proposalRepository->getSyncListForProposalDetail($proposal->id);
        $totalPaid = 0;
        $proposalStatus = Proposal::STATUS;
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('proposals.view_as_customer', compact('proposal', 'totalPaid', 'proposalStatus', 'settings'));
    }

    /**
     * @param  Proposal  $proposal
     *
     * @return mixed
     */
    public function convertToPdf(Proposal $proposal)
    {
        $proposal = $this->proposalRepository->getSyncListForProposalDetail($proposal->id);

        $totalPaid = 0;
        $settings = Setting::pluck('value', 'key')->toArray();

        /** @var PDF $pdf */
        $pdf = PDF::loadView('proposals.proposal_pdf', compact(['proposal', 'totalPaid', 'settings']));

        return $pdf->download(__('messages.proposal.proposal_prefix').$proposal->proposal_number.'.pdf');
    }

    /**
     * @param  Proposal  $proposal
     *
     * @return JsonResponse
     */
    public function convertToInvoice(Proposal $proposal)
    {
        $invoice = $this->proposalRepository->convertToInvoice($proposal);

        return $this->sendResponse($invoice, 'Convert Proposal To Invoice Successfully.');
    }

    /**
     * @param  Proposal  $proposal
     *
     * @return JsonResponse
     */
    public function convertToEstimate(Proposal $proposal)
    {
        $estimate = $this->proposalRepository->convertToEstimate($proposal);

        return $this->sendResponse($estimate, 'Convert Proposal To Estimate Successfully.');
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function getCustomerAddress(Request $request)
    {
        $address = Address::where('owner_id', '=', $request->customer_id)->where('owner_type', '=', Customer::class)->first();
        if (! empty($address)) {
            $address->country = $address->country != null ? $address->addressCountry->name : null;
        }

        return $this->sendResponse($address, 'Address retrieved successfully');
    }
}
