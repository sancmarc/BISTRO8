@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"> 
            <h2 class="text-center">Search Arrival Date</h2>
            <form action="{{route('search.inventory')}}" method="get">
                <div class="row">
                    <div class="col-md-6">
                        <label for="from">From Date:</label>
                        <input class="form-control  @error('from') is-invalid @enderror" value="{{ old('from') }}" type="date" id="from" name="from">

                        @error('from')
                        <span class="text-center invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="to">To Date:</label>
                        <input class="form-control  @error('to') is-invalid @enderror" value="{{ old('to') }}" type="date" id="to" name="to">

                        @error('from')
                        <span class="text-center invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-primary float-end mt-2">Search</button>
            </form>

            @if ($to != null && $from != null)
            <table class="table table-hover table-condensed  dt-responsive nowrap">
                @php
                $inventory = ['#','Part name','Part area','Weight','Remaining','¥ Basic Unit Price','¥ Cost Price','Unit Price','Selling Price','Arrival Date','Expiration Date','Storage','Note'];
                $nameInventory = ['id','part_name','part_area','weight','quantity_stocks','basic_unit_price','cost_price','unit_price','selling_price','arrival_date','expiration_date','storage_location','note'];
                
                $getInventory = DB::table('inventories')->whereBetween('arrival_date', [$from, $to])->get();

                @endphp
                <thead>
                    <tr>
         
                        @foreach ($inventory as $th)
                        <th>{{$th}}</th>
                        @endforeach
        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getInventory as $inv)
                    <tr>
                        @foreach ($nameInventory as $nameInv)
                        @if($nameInv == 'id')
                            <td>Part &num; {{$inv->$nameInv}}</td>
                        @else
                            <td>{{$inv->$nameInv}}</td>
                        @endif
                      
                        @endforeach
                        
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
            @endif

        </div>
    </div>
</div>
@endsection