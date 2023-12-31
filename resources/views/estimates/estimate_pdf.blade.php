<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.estimate.estimate_pdf') }}</title>
    <link href="{{ asset('css/invoices/invoice-pdf.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
<table class="main-table">
    <tr>
        <td class="app-logo">
            <img src="{{ $settings['logo'] }}" width="100px">
        </td>
        <td class="text-right invoice-number">
            <h2 class="text-uppercase">{{ __('messages.estimate.estimate') }}</h2>
            <p>{{ __('messages.estimate.estimate_prefix') }}{{ $estimate->estimate_number }}</p>
        </td>
    </tr>
    <tr>
        <td class="invoice-customer-detail">
            <p class="font-weight-bold m-0">{{ html_entity_decode($estimate->customer->company_name) }}</p>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td>
                        @foreach($estimate->estimateAddresses as $address)
                            <div class="invoice-addresses text-right mb-2">
                                <p class="font-weight-bold m-0">{{ ($address->type == 1) ? __('messages.invoice.bill_to') : __('messages.invoice.ship_to') }}
                                    :</p>
                                <p class="m-0">{{ html_entity_decode($address->street) }}</p>
                                <p class="m-0">{{ $address->city }}, {{ $address->state }}</p>
                                <p class="m-0">{{ $address->country }}</p>
                                <p class="m-0">{{ $address->zip_code }}</p>
                            </div>
                        @endforeach
                        <div class="text-right">
                            <table class="invoice-date-table">
                                <tr>
                                    <td class="text-right font-weight-bold"
                                        style="width: 70%;">{{ __('messages.estimate.estimate_date').': ' }}</td>
                                    <td>{{ !empty($estimate->estimate_date) ? Carbon\Carbon::parse($estimate->estimate_date)->format('jS M, Y') : __('messages.common.n/a') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right font-weight-bold"
                                        style="width: 70%;">{{ __('messages.estimate.expiry_date').': ' }}</td>
                                    <td>{{ !empty($estimate->estimate_expiry_date) ? Carbon\Carbon::parse($estimate->estimate_expiry_date)->format('jS M, Y') : __('messages.common.n/a') }}</td>
                                </tr>
                                @if(isset($estimate->sales_agent_id))
                                    <tr>
                                        <td class="text-right font-weight-bold"
                                            style="width: 70%;">{{ __('messages.invoice.sale_agent').': ' }}</td>
                                        <td>{{ isset($estimate->sales_agent_id) ? ($estimate->user->full_name) : __('messages.common.n/a') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" class="table table-bordered invoice-sales-items mt-2">
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('messages.estimate.item') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.estimate.qty') }}</th>
                    <th scope="col" class="text-right rate">{{ __('messages.estimate.rate') }}( <span
                                class="pdf-css">&#{{ getCurrencyIcon($estimate->currency) }}</span>
                        )
                    </th>
                    <th scope="col">{{ __('messages.estimate.taxes') }}</th>
                    <th scope="col" class="text-right total-amount">{{ __('messages.estimate.amount') }}( <span
                                class="pdf-css">&#{{ getCurrencyIcon($estimate->currency) }}</span>
                        )
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($estimate->salesItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <p class="m-0">{{ html_entity_decode($item->item) }}</p>
                            <p class="text-muted m-0 table-data">
                                <small>{{ html_entity_decode($item->description) }}</small></p>
                        </td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">
                            <span class="pdf-css">&#{{ getCurrencyIcon($estimate->currency) }}</span>
                            {{ number_format($item->rate, 2) }}
                        </td>
                        <td>
                            @forelse($item->taxes as $tax)
                                <p><span class="badge badge-secondary font-weight-normal">{{ $tax->tax_rate }}%</span>
                                </p>
                            @empty
                                <p>{{ __('messages.common.n/a') }}</p>
                            @endforelse
                        </td>
                        <td class="text-right">
                            <span class="pdf-css">&#{{ getCurrencyIcon($estimate->currency) }}</span>
                            {{ number_format((($item->total*isset($tax) ? $tax->tax_rate : 1)/100) + $item->total, 2) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td></td>
        <td class="float-right">
            <table class="table text-right invoice-footer-table mt-2">
                <tbody>
                <tr>
                    <td>
                        {{ __('messages.estimate.sub_total').':' }}
                    </td>
                    <td>
                        <span class="pdf-css">&#{{ getCurrencyIcon($estimate->currency) }}</span>
                        {{ !empty($estimate->sub_total) ? number_format($estimate->sub_total, 2) : __('messages.common.n/a') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('messages.estimate.discount').':' }}
                    </td>
                    <td>
                        {{ formatNumber($estimate->discount) }}{{ isset($estimate->discount_symbol) && $estimate->discount_symbol == 1 ? '%' : '' }}
                    </td>
                </tr>
                @foreach($estimate->salesTaxes as $commonTax)
                    <tr>
                        <td>{{ __('messages.item.tax') }} {{ $commonTax->tax }}%</td>
                        <td>
                            <span class="pdf-css">&#{{ getCurrencyIcon($estimate->currency) }}</span>
                            {{ number_format($commonTax->amount, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>{{ __('messages.estimate.adjustment').':' }}</td>
                    <td>
                        <span class="pdf-css">&#{{ getCurrencyIcon($estimate->currency) }}</span>
                        {{ number_format($estimate->adjustment) }}
                    </td>
                </tr>
                <tr>
                    <td>{{ __('messages.estimate.total').':' }}</td>
                    <td>
                        <span class="pdf-css">&#{{ getCurrencyIcon($estimate->currency) }}</span>
                        {{ number_format($estimate->total_amount, 2) }}
                    </td>
                </tr>
                <tr class="text-color">
                    <td>{{ __('messages.estimate.amount_due').':' }}</td>
                    <td>
                        <span class="pdf-css">&#{{ getCurrencyIcon($estimate->currency) }}</span>
                        {{ number_format($estimate->total_amount - $totalPaid, 2) }}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h4 class="mt-2">{{ __('messages.estimate.client_note').':' }}</h4>
            {!! !empty($estimate->client_note) ? html_entity_decode($estimate->client_note) :  __('messages.common.n/a')  !!}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h4 class="mt-2">{{ __('messages.estimate.terms_conditions').':' }}</h4>
            {!! !empty($estimate->term_conditions) ? html_entity_decode($estimate->term_conditions) :  __('messages.common.n/a')  !!}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p class="mt-2">{{ __('messages.estimate.authorized_signature').' _________________' }}</p>
        </td>
    </tr>
</table>
</body>
</html>
