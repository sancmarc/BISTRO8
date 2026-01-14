@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Check Barcode') }}</div>

                <div class="card-body">
                    <form action="{{route('check.barcode')}}" method="get">

                        <div class="col-md-12">
                            <label for="barcodeID" class="form-label">BARCODE</label>
                            <input type="number" class="form-control " id="barcodeID" name="barcodeID">

                        </div>
                    </form>

                    @if($printData != null)
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="card mt-5">
                                <div class="card-header">
                                    <div class="text-center">Sold to: {{$printData->sold_to}}</div>
                                </div>
                                <ul>
                                    <li>Billing &#35;: <span class="float-end pe-3">Billing &num;{{$printData->id}}</span></li>
                                    <li>Part Name: <span class="float-end pe-3">{{$printData->part_name}}</span></li>
                                    <li>Part Area: <span class="float-end pe-3">{{$printData->part_area}}</span></li>

                                    <li>Delivery Date: <span class="float-end pe-3">{{$printData->delivery_date}}</span></li>
                                    <li>Billing Date: <span class="float-end pe-3">{{$printData->billing_date}}</span></li>
                                    <li>Payment Date: <span class="float-end pe-3">{{$printData->payment_date}}</span></li>
                                    <li>Processing: <span class="float-end pe-3">{{$printData->processing}}</span></li>
                                    <li>Sold: <span class="float-end pe-3">{{$printData->usage}} /kg</span></li>
                                    <li>Memo: <span class="float-end pe-3">{{$printData->memo}}</span></li>
                                    <li>Cut Fee: <span class="float-end pe-3">₱ {{$printData->cut_fee}}</span></li>
                                    <li>Final Price: <span class="float-end pe-3">₱ {{$printData->final_price}}</span></li>
                                </ul>
                                <div class="card-footer">
                                    <div class="text-center">
                                        Bistro 8
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection