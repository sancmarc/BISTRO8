@extends('layouts.apps')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('History') }}</div>
                <div class="card-body">


                    <div class="row">
                        @foreach($showInventory as $inv)
                        <div class="col-md-3">

                            <div class="card">
                                <div class="card-header">
                                    <div class="text-center">Sold to: {{$inv->sold_to}}</div>
                                </div>
                                <ul>
                                    <li>Billing &#35;: <span class="float-end pe-3">{{$inv->id}}</span></li>
                                    <li>Part Name: <span class="float-end pe-3">{{$inv->part_name}}</span></li>
                                    <li>Part Area: <span class="float-end pe-3">{{$inv->part_area}}</span></li>

                                    <li>Delivery Date: <span class="float-end pe-3">{{$inv->delivery_date}}</span></li>
                                    <li>Billing Date: <span class="float-end pe-3">{{$inv->billing_date}}</span></li>
                                    <li>Payment Date: <span class="float-end pe-3">{{$inv->payment_date}}</span></li>
                                    <li>Processing: <span class="float-end pe-3">{{$inv->processing}}</span></li>
                                    <li>Sold: <span class="float-end pe-3">{{$inv->usage}} /kg</span></li>
                                    <li>Memo: <span class="float-end pe-3">{{$inv->memo}}</span></li>
                                    <li>Cut Fee: <span class="float-end pe-3">₱ {{$inv->cut_fee}}</span></li>
                                    <li>Final Price: <span class="float-end pe-3">₱ {{$inv->final_price}}</span></li>
                                </ul>
                                <div class="card-footer">
                                    <div class="text-center">
                                        Bistro 8
                                    </div>
                                    @if($checkRole == 1)
                                    <div class="float-end">
                                        <a href="{{route('print.history',$inv->id)}}" target="_blank" class="btn btn-sm btn-primary">Process to Print</a>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection