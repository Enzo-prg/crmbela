<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.invoice.invoice_prefix').$invoice->invoice_number }}</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/sales/view-as-customer.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/invoices/invoices.css') }}">
</head>
<body>
<div class="container">
    <div class="col-12">
        <div class="row">
            <div class="logo mt-4">
                <a href="{{ route('redirect.login') }}">
                    <img src="{{ $settings['logo'] }}" class="img-fluid" width="120px">
                </a>
            </div>
        </div>
    </div>
    <div class="buttons d-flex mt-3 justify-content-between">
        <div class="status">
            <a href="#"
               class="btn btn-outline-secondary mx-1 status-{{ \Illuminate\Support\Str::slug(\App\Models\Invoice::PAYMENT_STATUS[($invoice->payment_status)]) }}">
                {{ \App\Models\Invoice::PAYMENT_STATUS[$invoice->payment_status] }}
            </a>
        </div>
        <div class="download-btn">
            <a href="{{ route('invoices.index') }}" class="btn btn-light btn-sm text-uppercase mx-1 border">
                <i class="fa fa-undo"></i> {{ __('messages.common.back') }}</a>
            <a href="{{ route('invoice.pdf', ['invoice' => $invoice->id]) }}"
               class="btn btn-light btn-sm text-uppercase mx-1 border">
                <i class="far fa-file-pdf"></i> {{ __('messages.common.download') }}
            </a>
        </div>
    </div>
    <div class="card my-4 shadow ">
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h4>{{ __('messages.invoice.invoice_prefix').$invoice->invoice_number }}</h4>
                        <p class="invoice-company-name m-0 text-muted font-weight-bold">{{ $invoice->customer->company_name }}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        @foreach($invoice->invoiceAddresses as $address)
                            <div class="w-75 float-right invoice-addresses text-right text-muted mb-2">
                                <p class="font-weight-bold m-0">{{ ($address->type == 1) ? __('messages.invoice.bill_to') : __('messages.invoice.ship_to') }}
                                    :</p>
                                <p class="m-0">{{ $address->street }}</p>
                                <p class="m-0">{{ $address->city }}, {{ $address->state }}</p>
                                <p class="m-0">{{ $address->country }}</p>
                                <p class="m-0">{{ $address->zip_code }}</p>
                            </div>
                        @endforeach
                        <div class="invoice-date d-table float-right">
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.invoice.invoice_date').':' }}</div>
                                <div class="d-table-cell">{{ !empty($invoice->invoice_date) ? Carbon\Carbon::parse($invoice->invoice_date)->format('jS M, Y') : __('messages.common.n/a')}}</div>
                            </div>
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.invoice.due_date').':' }}</div>
                                <div class="d-table-cell">{{ !empty($invoice->due_date) ? Carbon\Carbon::parse($invoice->due_date)->format('jS M, Y') : __('messages.common.n/a')}}</div>
                            </div>
                            @if(isset($invoice->sales_agent_id))
                                <div class="d-table-row">
                                    <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.invoice.sale_agent').':' }}</div>
                                    <div class="d-table-cell">{{ isset($invoice->sales_agent_id) ? ($invoice->user->full_name) : __('messages.common.n/a') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 mt-5">
                        <table class="table table-responsive-sm table-responsive-md table-responsive-lg table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('messages.invoice.item') }}</th>
                                <th scope="col">{{ __('messages.invoice.qty') }}</th>
                                <th scope="col" class="text-right itemRate">{{ __('messages.item.rate') }}</th>
                                <th scope="col">{{ __('messages.invoice.taxes') }}</th>
                                <th scope="col" class="text-right itemTotal">{{ __('messages.invoice.amount') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice->salesItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <p class="m-0">{{ html_entity_decode($item->item) }}</p>
                                        <p class="text-muted m-0 table-data">
                                            <small>{{ html_entity_decode($item->description) }}</small></p>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-right">
                                        <small class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></small>
                                        {{ number_format($item->rate, 2) }}
                                    </td>
                                    <td>
                                        @forelse($item->taxes as $tax)
                                            <span class="badge badge-secondary font-weight-normal">{{ $tax->tax_rate }}%</span>
                                        @empty
                                            <p>{{ __('messages.common.n/a') }}</p>
                                        @endforelse
                                    </td>
                                    <td class="text-right">
                                        <small class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></small>
                                        {{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table class="table w-25 float-right text-right">
                            <tbody>
                            <tr>
                                <td>
                                    {{ __('messages.invoice.sub_total').':' }}
                                </td>
                                <td class="amountData">
                                    <small class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></small>
                                    {{ !empty($invoice->sub_total) ? number_format($invoice->sub_total, 2) : __('messages.common.n/a') }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ __('messages.invoice.discount').':' }}
                                </td>
                                <td>
                                    {{ formatNumber($invoice->discount) }} {{ isset($invoice->discount_symbol) && $invoice->discount_symbol == 1 ? '%' : '' }}
                                </td>
                            </tr>
                            @foreach($invoice->salesTaxes as $commonTax)
                                <tr>
                                    <td>{{ __('messages.item.tax') }} {{ $commonTax->tax }}%</td>
                                    <td>
                                        <small class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></small>
                                        {{ number_format($commonTax->amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>{{ __('messages.invoice.adjustment').':' }}</td>
                                <td class="itemTotal">
                                    <small class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></small>
                                    {{ number_format($invoice->adjustment) }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('messages.invoice.total').':' }}</td>
                                <td class="amountData">
                                    <small class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></small>
                                    {{ number_format($invoice->total_amount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('messages.invoice.total_paid').':' }}</td>
                                <td class="amountData">
                                    <small class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></small>
                                    {{ number_format($totalPaid, 2) }}
                                </td>
                            </tr>
                            <tr class="{{ empty($totalPaid) ? 'text-danger' : '' }}">
                                <td>{{ __('messages.invoice.amount_due').':' }}</td>
                                <td class="amountData">
                                    <small class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></small>
                                    {{ number_format($invoice->total_amount - $totalPaid, 2) }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <p class="font-weight-bold">{{ __('messages.invoice.terms_conditions').':' }}</p>
                        {!! !empty($invoice->term_conditions) ? html_entity_decode($invoice->term_conditions) :  __('messages.common.n/a')  !!}
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <h4>{{ __('messages.invoice.transactions').':' }}</h4>
                        <div class="table-responsive-sm">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('messages.payment.note') }}</th>
                                    <th scope="col">{{ __('messages.payment.payment_mode') }}</th>
                                    <th scope="col">{{ __('messages.payment.date') }}</th>
                                    <th scope="col"
                                        class="text-right itemTotal">{{ __('messages.payment.amount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($invoice->payments as $payment)
                                    <tr>
                                        <td>{!! !empty($payment->note) ? html_entity_decode($payment->note) : __('messages.common.n/a')!!}</td>
                                        <td>{{ $payment->paymentMode->name }}</td>
                                        <td>{{ Carbon\Carbon::parse($payment->payment_date)->format('jS M, Y') }}</td>
                                        <td class="text-right">
                                            <small class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></small>
                                            {{ number_format($payment->amount_received, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="text-muted text-center">{{ __('messages.invoice.no_payments_available').'...' }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>
</html>
