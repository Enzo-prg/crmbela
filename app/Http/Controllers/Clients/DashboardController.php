<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Models\Invoice;
use App\Repositories\EstimateRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ProposalRepository;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardController
 */
class DashboardController extends AppBaseController
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;
    /**
     * @var ProposalRepository
     */
    private $proposalRepository;
    /**
     * @var EstimateRepository
     */
    private $estimateRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        InvoiceRepository $invoiceRepository,
        ProposalRepository $proposalRepository,
        EstimateRepository $estimateRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->proposalRepository = $proposalRepository;
        $this->estimateRepository = $estimateRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $customerId = getLoggedInUser()->contact->customer_id;
        $data['projectStatusCount'] = $this->projectRepository->getProjectsStatusCount($customerId);
        $data['estimateStatusCount'] = $this->estimateRepository->getEstimatesStatusCount($customerId);
        $data['invoiceStatusCount'] = $this->invoiceRepository->getInvoicesStatusCount($customerId);
        $data['proposalStatusCount'] = $this->proposalRepository->getProposalsStatusCount($customerId);

        $invoices = Invoice::whereCustomerId($customerId)->whereYear('created_at',
            Carbon::now()->year)->select(DB::raw('MONTH(created_at) as month,invoices.*'))->get();

        $monthsWiseInvoice = [];
        $months = [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July ',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        foreach ($months as $month => $monthName) {
            $monthsWiseInvoice['paid'][$monthName] = $invoices->where('month', $month)->where('payment_status',
                Invoice::STATUS_PAID)->sum('total_amount');
            $monthsWiseInvoice['unpaid'][$monthName] = $invoices->where('month', $month)->where('payment_status',
                Invoice::STATUS_UNPAID)->sum('total_amount');
        }

        $data['monthsWiseInvoice'] = $monthsWiseInvoice;
        $data['months'] = $months;

        return view('clients.dashboard', $data);
    }
}
