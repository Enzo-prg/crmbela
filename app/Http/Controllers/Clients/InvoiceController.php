<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use App\Models\Invoice;
use App\Models\Setting;
use App\Repositories\InvoiceRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class InvoiceController
 */
class InvoiceController extends AppBaseController
{
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Display a listing of the Invoice.
     *
     * @return Factory|View
     */
    public function index()
    {
        $invoiceStatusCount = $this->invoiceRepository->getInvoicesStatusCount(getLoggedInUser()->contact->customer_id);

        $paymentStatus = Invoice::CLIENT_PAYMENT_STATUS;

        return view('clients.invoices.index', compact('invoiceStatusCount', 'paymentStatus'));
    }

    /**
     * @param  Invoice  $invoice
     *
     * @return Factory|View
     */
    public function viewAsCustomer(Invoice $invoice)
    {
        $invoice = $this->invoiceRepository->getInvoiceDetailClient($invoice->id);

        $settings = Setting::pluck('value', 'key')->toArray();

        $totalPaid = 0;

        foreach ($invoice->payments as $payment) {
            $totalPaid += $payment->amount_received;
        }

        return view('clients.invoices.view_as_customer', compact('invoice', 'totalPaid', 'settings'));
    }

    /**
     * @param  Invoice  $invoice
     *
     * @return mixed
     */
    public function covertToPdf(Invoice $invoice)
    {
        $invoice = $this->invoiceRepository->getSyncListForInvoiceDetail($invoice->id);
        $totalPaid = 0;

        foreach ($invoice->payments as $payment) {
            $totalPaid += $payment->amount_received;
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $pdf = PDF::loadView('clients.invoices.invoice_pdf', compact(['invoice', 'settings', 'totalPaid']));

        return $pdf->download(__('messages.invoice.invoice_prefix').$invoice->invoice_number.'.pdf');
    }
}
