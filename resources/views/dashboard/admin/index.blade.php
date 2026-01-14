@extends('layouts.apps')
<style>
    span.transferNotes {
        max-width: 100px;
        white-space: normal;
    }
</style>
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">{{ __('Inventory') }}
                    @if($checkRole == 1)
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#inventoryModal">
                        Add Inventory
                    </button>
                    @endif
                </div>

                <div class="card-body">
                    <table class="table table-hover table-condensed  dt-responsive nowrap" id="inventoryTable">
                        @php
                        $inventory = ['Part name','Part area','Weight','Remaining','Basic Unit Price','Cost Price','Unit Price','Selling Price','Arrival Date','Expiration Date','Storage'];
                        @endphp
                        <thead>
                            <tr>
                                <th>&#35;</th>
                                @foreach ($inventory as $th)
                                <th>{{$th}}</th>
                                @endforeach
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@if($checkRole == 1)
<div class="modal fade" id="inventoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="inventoryModalLabel">Inventory Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('store.inventory')}}" method="post" id="inventoryForm">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <label for="part_name" class="form-label">Part Name</label>
                            <input type="text" class="form-control" id="part_name" name="part_name">
                            <span class="text-danger error-text part_name_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="part_area" class="form-label">Part Area</label>
                            <input type="text" class="form-control" id="part_area" name="part_area">
                            <span class="text-danger error-text part_area_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" class="form-control" id="weight" name="weight" step=".001">
                            <span class="text-danger error-text weight_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="basic_unit_price" class="form-label">Basic Unit Price &dash; Yen</label>
                            <input type="number" class="form-control" id="basic_unit_price" name="basic_unit_price" step=".001"">
                            <span class=" text-danger error-text basic_unit_price_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="cost_price" class="form-label">Cost Price &dash; Yen</label>
                            <input type="number" class="form-control" id="cost_price" name="cost_price" step=".001"">
                            <span class=" text-danger error-text cost_price_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="unit_price" class="form-label">Unit Price</label>
                            <input type="number" class="form-control" id="unit_price" name="unit_price" step=".001"">
                            <span class=" text-danger error-text unit_price_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="selling_price" class="form-label">Selling Price</label>
                            <input type="number" class="form-control" id="selling_price" name="selling_price" step=".001"">
                            <span class=" text-danger error-text selling_price_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="arrival_date" class="form-label">Arrival Date</label>
                            <input type="date" class="form-control" id="arrival_date" name="arrival_date">
                            <span class="text-danger error-text arrival_date_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="expiration_date" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" id="expiration_date" name="expiration_date">
                            <span class="text-danger error-text expiration_date_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="storage_location" class="form-label">Storage Location</label>
                            <select class="form-select" name="storage_location" id="storage_location" aria-label="Default select example">
                                <option value="">Open this select menu</option>
                                <option value="Bistro 8-A">Bistro 8&dash;A</option>
                                <option value="Bistro 8-B">Bistro 8&dash;B</option>
                                <option value="Diamond A">Diamond A</option>
                                <option value="Diamond B">Diamond B</option>
                                <option value="Diamond C">Diamond C</option>
                                <option value="Cubao A">Cubao A</option>
                                <option value="Cubao B">Cubao B</option>
                            </select>
                            <span class="text-danger error-text storage_location_error"></span>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit-->
<div class="modal fade" id="inventoryEditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="inventoryEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="inventoryEditModalLabel">Update Inventory Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{route('update.inventory')}}" method="post" id="inventoryUpdateForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="dataID" name="dataID">
                        <div class="col-md-6">
                            <label for="part_name" class="form-label">Part Name</label>
                            <input type="text" class="form-control" id="part_name" name="part_name">
                            <span class="text-danger error-text part_name_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="part_area" class="form-label">Part Area</label>
                            <input type="text" class="form-control" id="part_area" name="part_area">
                            <span class="text-danger error-text part_area_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" class="form-control" id="weight" name="weight" step=".001"">
                            <span class=" text-danger error-text weight_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="basic_unit_price" class="form-label">Basic Unit Price &dash; Yen</label>
                            <input type="number" class="form-control" id="basic_unit_price" name="basic_unit_price" step=".001"">
                            <span class=" text-danger error-text basic_unit_price_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="cost_price" class="form-label">Cost Price &dash; Yen</label>
                            <input type="number" class="form-control" id="cost_price" name="cost_price" step=".001"">
                            <span class=" text-danger error-text cost_price_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="unit_price" class="form-label">Unit Price</label>
                            <input type="number" class="form-control" id="unit_price" name="unit_price" step=".001"">
                            <span class=" text-danger error-text unit_price_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="selling_price" class="form-label">Selling Price</label>
                            <input type="number" class="form-control" id="selling_price" name="selling_price" step=".001"">
                            <span class=" text-danger error-text selling_price_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="arrival_date" class="form-label">Arrival Date</label>
                            <input type="date" class="form-control" id="arrival_date" name="arrival_date">
                            <span class="text-danger error-text arrival_date_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="expiration_date" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" id="expiration_date" name="expiration_date">
                            <span class="text-danger error-text expiration_date_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="storage_location" class="form-label">Storage Location</label>
                            <select class="form-select" name="storage_location" id="storage_location" aria-label="Default select example">
                                <option value="">Open this select menu</option>
                                <option value="Bistro 8-A">Bistro 8&dash;A</option>
                                <option value="Bistro 8-B">Bistro 8&dash;B</option>
                                <option value="Diamond A">Diamond A</option>
                                <option value="Diamond B">Diamond B</option>
                                <option value="Diamond C">Diamond C</option>
                                <option value="Cubao A">Cubao A</option>
                                <option value="Cubao B">Cubao B</option>
                            </select>
                            <span class="text-danger error-text storage_location_error"></span>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="processModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="processModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="processModalLabel">Process Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{route('process.billing')}}" method="post" id="processForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" for="inventory_id" id="inputGroup-sizing-sm">Part/Product #</span>
                                <input type="text" class="form-control" id="inventory_id" name="inventory_id" readonly>
                                <span class="text-danger error-text part_name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <label class="input-group-text" for="part_name" id="inputGroup-sizing-sm">Part Name</label>
                                <input type="text" class="form-control" id="part_name" name="part_name" readonly >
                                <span class="text-danger error-text part_name_error"></span>
                            </div>
        
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <label class="input-group-text" for="part_area" id="inputGroup-sizing-sm">Part Area</label>
                                <input type="text" class="form-control" id="part_area" name="part_area" readonly>
                                <span class="text-danger error-text part_area_error"></span>
                            </div>

                       
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <label class="input-group-text" for="usage" id="inputGroup-sizing-sm">Total kg/ Weight</label>
                                <input type="number" class="form-control" id="usage" name="usage" step=".001">
                                <span class=" text-danger error-text usage_error"></span>
                            </div>

                 
                        </div>
                         <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="basic_unit" class="input-group-text">Basic Unit Price ¥</label>
                            <input type="text" class="form-control" id="basic_unit" name="basic_unit" readonly>
                            <span class="text-danger error-text basic_unit_error"></span>
                        </div>
                        </div>
                         <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="cost_price" class="input-group-text">Cost Price ¥</label>
                            <input type="text" class="form-control" id="cost_price" name="cost_price" readonly>
                            <span class="text-danger error-text cost_price_error"></span>
                        </div>
                        </div>
                         <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="unit_price" class="input-group-text">Unit Price ₱</label>
                            <input type="text" class="form-control" id="unit_price" name="unit_price" readonly>
                            <span class="text-danger error-text unit_price_error"></span>
                        </div>  </div>
                         <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="selling_price" class="input-group-text">Selling Price ₱</label>
                            <input type="text" class="form-control" id="selling_price" name="selling_price" readonly>
                            <span class="text-danger error-text selling_price_error"></span>
                        </div>  </div>
                         <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="arrival_date" class="input-group-text">Arrival Date</label>
                            <input type="date" class="form-control" id="arrival_date" name="arrival_date" readonly>
                            <span class="text-danger error-text arrival_date_error"></span>
                        </div>  </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="expiration_date" class="input-group-text">Expiration Date</label>
                            <input type="date" class="form-control" id="expiration_date" name="expiration_date" readonly>
                            <span class="text-danger error-text expiration_date_error"></span>
                        </div>  </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="storage_location" class="input-group-text">Storage Location</label>
                            <input type="text" class="form-control" id="storage_location" name="storage_location" readonly>
                            <span class="text-danger error-text storage_location_error"></span>
                        </div>  </div>
                             <div class="col-md-12">
                                <div class="input-group input-group-sm mb-3">
                            <label for="processing" class="input-group-text">Processing</label>
                            <select class="form-select" name="processing" id="processing" aria-label="Select Processing">
                                <option value="">Open this select menu</option>
                                <option value="Steak">Steak</option>
                                <option value="Slice">Slice</option>

                            </select>
                            <span class="text-danger error-text processing_error"></span>
                        </div>  </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="sold_to" class="input-group-text">Sold to</label>
                            <input type="text" class="form-control" id="sold_to" name="sold_to">
                            <span class="text-danger error-text sold_to_error"></span>
                        </div>  </div>

                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="delivery_receipt" class="input-group-text">Delivery Receipt</label>
                            <input type="text" class="form-control" id="delivery_receipt" name="delivery_receipt">
                            <span class="text-danger error-text delivery_receipt_error"></span>
                        </div>  </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="delivered_by" class="input-group-text">Delivery By</label>
                            <input type="text" class="form-control" id="delivered_by" name="delivered_by">
                            <span class="text-danger error-text delivered_by_error"></span>
                        </div>  </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="delivery_date" class="input-group-text">Delivery Date</label>
                            <input type="date" class="form-control" id="delivery_date" name="delivery_date">
                            <span class="text-danger error-text delivery_date_error"></span>
                        </div>  </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="billing_date" class="input-group-text">Billing Date</label>
                            <input type="date" class="form-control" id="billing_date" name="billing_date">
                            <span class="text-danger error-text billing_date_error"></span>
                        </div>  </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="payment_date" class="input-group-text">Payment Date</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date">
                            <span class="text-danger error-text payment_date_error"></span>
                        </div>  </div>
                   
                        
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="payment_date" class="input-group-text">Memo</label>
                            <textarea class="form-control" name="memo" id="memo" cols="30" rows="4"></textarea>
                            <span class="text-danger error-text memo_error"></span>
                        </div>  </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="cut_fee" class="input-group-text">Cut Fee</label>
                            <input type="number" class="form-control" id="cut_fee" name="cut_fee" step=".001">
                            <span class=" text-danger error-text cut_fee_error"></span>
                        </div>  </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                            <label for="final_price" class="input-group-text">Final Price</label>
                            <input type="number" class="form-control" id="final_price" name="final_price" step=".001">
                            <span class=" text-danger error-text final_price_error"></span>
                        </div>  </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="inventoryEditPriceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="inventoryEditPriceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="inventoryEditPriceModalLabel">Update Inventory Price Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{route('update.price')}}" method="post" id="inventoryUpdatePriceForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="dataID" name="dataID">
                        <div class="col-md-6">
                            <label for="basic_unit_price" class="form-label">Basic Unit Price &dash; Yen</label>
                            <input type="number" class="form-control" id="basic_unit_price" name="basic_unit_price" step=".001">
                            <span class="text-danger error-text basic_unit_price_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="cost_price" class="form-label">Cost Price &dash; Yen</label>
                            <input type="number" class="form-control" id="cost_price" name="cost_price" step=".001">
                            <span class="text-danger error-text cost_price_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="unit_price" class="form-label">Unit Price</label>
                            <input type="number" class="form-control" id="unit_price" name="unit_price" step=".001">
                            <span class="text-danger error-text unit_price_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="selling_price" class="form-label">Selling Price</label>
                            <input type="number" class="form-control" id="selling_price" name="selling_price" step=".001">
                            <span class="text-danger error-text selling_price_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="transferItemsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="transferItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="transferItemsModalLabel">Transfer Inventory Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{route('transfer.items')}}" method="post" id="transferInventoryForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="dataID" name="dataID">

                        <div class="col-md-6">
                            <label for="quantity_stocks" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity_stocks" name="quantity_stocks" step=".001">
                            <span class="text-danger error-text quantity_stocks_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="from" class="form-label">From Storage Location</label>
                            <input type="text" class="form-control" id="from" name="from" readonly>
                            <span class="text-danger error-text from_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="to" class="form-label">To Storage Location</label>
                            <select class="form-select" name="to" id="to" aria-label="Default select example">
                                <option value="">Open this select menu</option>
                                <option value="Bistro 8-A">Bistro 8&dash;A</option>
                                <option value="Bistro 8-B">Bistro 8&dash;B</option>
                                <option value="Diamond A">Diamond A</option>
                                <option value="Diamond B">Diamond B</option>
                                <option value="Diamond C">Diamond C</option>
                                <option value="Cubao A">Cubao A</option>
                                <option value="Cubao B">Cubao B</option>
                            </select>
                            <span class="text-danger error-text to_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


@if($checkRole == 1)
<script type="module">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        $('#inventoryTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: "{{ route('show.inventory')}}",
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "ALL"]
            ],
            columns: [{
                    data: 'id',
                    name: 'id',
                    render: function(data) {
                        return `Part &num; ${data}`;
                    }
                },
                {
                    data: 'part_name',
                    name: 'part_name',
                },
                {
                    data: 'part_area',
                    name: 'part_area',
                },
                {
                    data: 'weight',
                    name: 'weight',
                    render: function(data) {
                        return `${data} kg`;
                    }
                },
                {
                    data: 'quantity_stocks',
                    name: 'quantity_stocks',
                    render: function(data) {
                        return `${data} kg`;
                    }
                },
                {
                    data: 'basic_unit_price',
                    name: 'basic_unit_price',
                    render: function(data) {
                        return `¥ ${data}`;
                    }
                },
                {
                    data: 'cost_price',
                    name: 'cost_price',
                    render: function(data) {
                        return `¥ ${data}`;
                    }
                },
                {
                    data: 'unit_price',
                    name: 'unit_price',
                    render: function(data) {
                        return `₱ ${data}`;
                    }
                },
                {
                    data: 'selling_price',
                    name: 'selling_price',
                    render: function(data) {
                        return `₱ ${data}`;
                    }
                },
                {
                    data: 'arrival_date',
                    name: 'arrival_date',
                },
                {
                    data: 'expiration_date',
                    name: 'expiration_date',
                },
                {
                    data: 'storage_location',
                    name: 'storage_location',
                },
                {
                    data: 'notes',

                    name: 'notes',
                },
                {
                    data: 'actions',
                    name: 'actions',
                },
            ],

        });
        $('#inventoryForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to save this record?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({

                        icon: 'info',
                        title: 'Saving',
                        text: "Processing.....",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }

                    })
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            Swal.close();
                            if (data.code == 0) {
                                $.each(data.error, function(prefix, val) {
                                    $(form).find('span.' + prefix + '_error').text(val[0]);
                                });
                            } else if (data.code == 1) {

                                $(form)[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully!',
                                    text: data.msg,
                                    timer: 3500
                                })
                                $('#inventoryTable').DataTable().draw();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oopss..',
                                    text: data.msg,
                                    timer: 3500
                                });
                            }
                        }
                    })



                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        })
        $(document).on('click', '#yesBtn', function() {
        
            const dataID = $(this).data('id');
            
              $.post("{{route('get.inventory')}}", {
                dataID: dataID
            }, function(data) {
                $('#processModal').modal('show');
                $('#processModal').find('#inventory_id').val(dataID);
                $('#processModal').find('#part_name').val(data.details.part_name);
                $('#processModal').find('#part_area').val(data.details.part_area);
                $('#processModal').find('#basic_unit').val(data.details.basic_unit_price);
                $('#processModal').find('#cost_price').val(data.details.cost_price);
                $('#processModal').find('#unit_price').val(data.details.unit_price);
                $('#processModal').find('#selling_price').val(data.details.selling_price);
                $('#processModal').find('#arrival_date').val(data.details.arrival_date);
                $('#processModal').find('#expiration_date').val(data.details.expiration_date);
                $('#processModal').find('#storage_location').val(data.details.storage_location);
            })
        })
        $('#processForm').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to save this record?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({

                        icon: 'info',
                        title: 'Saving',
                        text: "Processing.....",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }

                    })

                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            Swal.close();
                            if (data.code == 0) {
                                $.each(data.error, function(prefix, val) {
                                    $(form).find('span.' + prefix + '_error').text(val[0]);
                                });
                            } else if (data.code == 1) {

                                $(form)[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully!',
                                    text: data.msg,
                                    timer: 3500
                                })
                                $('#inventoryTable').DataTable().draw();
                                $('#processModal').modal('hide');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oopss..',
                                    text: data.msg,
                                    timer: 3500
                                });
                            }
                        }
                    })



                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        })

        $(document).on('click', '#editBtn', function() {
            const dataID = $(this).data('id');

            $.post("{{route('get.inventory')}}", {
                dataID: dataID
            }, function(data) {
                $('#inventoryEditModal').modal('show');
                $('#inventoryEditModal').find('#dataID').val(dataID);
                $('#inventoryEditModal').find('#part_name').val(data.details.part_name);
                $('#inventoryEditModal').find('#part_area').val(data.details.part_area);
                $('#inventoryEditModal').find('#weight').val(data.details.weight);
                $('#inventoryEditModal').find('#basic_unit_price').val(data.details.basic_unit_price);
                $('#inventoryEditModal').find('#cost_price').val(data.details.cost_price);
                $('#inventoryEditModal').find('#unit_price').val(data.details.unit_price);
                $('#inventoryEditModal').find('#selling_price').val(data.details.selling_price);
                $('#inventoryEditModal').find('#arrival_date').val(data.details.arrival_date);
                $('#inventoryEditModal').find('#expiration_date').val(data.details.expiration_date);
                $('#inventoryEditModal').find('#storage_location').val(data.details.storage_location);
            })
        })
        $('#inventoryUpdateForm').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to save this record?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({

                        icon: 'info',
                        title: 'Saving',
                        text: "Processing.....",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }

                    })
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            Swal.close();
                            if (data.code == 0) {
                                $.each(data.error, function(prefix, val) {
                                    $(form).find('span.' + prefix + '_error').text(val[0]);
                                });
                            } else if (data.code == 1) {
                                $('#inventoryEditModal').modal('hide');
                                $(form)[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully!',
                                    text: data.msg,
                                    timer: 3500
                                })
                                $('#inventoryTable').DataTable().draw();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oopss..',
                                    text: data.msg,
                                    timer: 3500
                                });
                            }
                        }
                    })



                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        })

        $(document).on('click', '#deleteBtn', function(e) {
            e.preventDefault();

            const dataID = $(this).data('id');
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to Delete this record?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({

                        icon: 'info',
                        title: 'Process',
                        text: "Processing.....",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }

                    })
                    $.post("{{route('delete.inventory')}}", {
                        dataID: dataID
                    }, function(data) {
                        Swal.close();
                        if (data.code == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully!',
                                text: data.msg,
                                timer: 3500
                            })
                            $('#inventoryTable').DataTable().draw();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss..',
                                text: data.msg,
                                timer: 3500
                            });
                        }
                    })




                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        })

        $(document).on('click', '#updateBtn', function(e) {

            const dataID = $(this).data('id');

            $.post("{{route('get.inventory')}}", {
                dataID: dataID
            }, function(data) {
                $('#inventoryEditPriceModal').modal('show');
                $('#inventoryEditPriceModal').find('#dataID').val(dataID);
                $('#inventoryEditPriceModal').find('#basic_unit_price').val(data.details.basic_unit_price);
                $('#inventoryEditPriceModal').find('#cost_price').val(data.details.cost_price);
                $('#inventoryEditPriceModal').find('#unit_price').val(data.details.unit_price);
                $('#inventoryEditPriceModal').find('#selling_price').val(data.details.selling_price);
            })
        })
        $('#inventoryUpdatePriceForm').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to save this record?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({

                        icon: 'info',
                        title: 'Saving',
                        text: "Processing.....",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }

                    })
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            Swal.close();
                            if (data.code == 0) {
                                $.each(data.error, function(prefix, val) {
                                    $(form).find('span.' + prefix + '_error').text(val[0]);
                                });
                            } else if (data.code == 1) {
                                $('#inventoryEditPriceModal').modal('hide');
                                $(form)[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully!',
                                    text: data.msg,
                                    timer: 3500
                                })
                                $('#inventoryTable').DataTable().draw();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oopss..',
                                    text: data.msg,
                                    timer: 3500
                                });
                            }
                        }
                    })



                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        })
        $(document).on('click', '#transferBtn', function() {

            const dataID = $(this).data('id');

            $.post("{{route('get.inventory')}}", {
                dataID: dataID
            }, function(data) {
                $('#transferItemsModal').modal('show');
                $('#transferItemsModal').find('#dataID').val(dataID);
                $('#transferItemsModal').find('#from').val(data.details.storage_location);
                $('#transferItemsModal').find('#quantity_stocks').val(data.details.quantity_stocks);

            })
        })
        $('#transferInventoryForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to transfer this item?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({

                        icon: 'info',
                        title: 'Saving',
                        text: "Processing.....",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }

                    })
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            Swal.close();
                            if (data.code == 0) {
                                $.each(data.error, function(prefix, val) {
                                    $(form).find('span.' + prefix + '_error').text(val[0]);
                                });
                            } else if (data.code == 1) {

                                $(form)[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully!',
                                    text: data.msg,
                                    timer: 3500
                                })
                                $('#inventoryTable').DataTable().draw();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oopss..',
                                    text: data.msg,
                                    timer: 3500
                                });
                            }
                        }
                    })



                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        })


    });
</script>
@else
<script type="module">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        $('#inventoryTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: "{{ route('show.inventory')}}",
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "ALL"]
            ],
            columns: [{
                    data: 'id',
                    name: 'id',
                    render: function(data) {
                        return `Part # ${data}`;
                    }
                },
                {
                    data: 'part_name',
                    name: 'part_name',
                },
                {
                    data: 'part_area',
                    name: 'part_area',
                },
                {
                    data: 'weight',
                    name: 'weight',
                    render: function(data) {
                        return `${data} kg`;
                    }
                },
                {
                    data: 'quantity_stocks',
                    name: 'quantity_stocks',
                    render: function(data) {
                        return `${data} kg`;
                    }
                },
                {
                    data: 'basic_unit_price',
                    name: 'basic_unit_price',
                    render: function(data) {
                        return `¥ ${data}`;
                    }
                },
                {
                    data: 'cost_price',
                    name: 'cost_price',
                    render: function(data) {
                        return `¥ ${data}`;
                    }
                },
                {
                    data: 'unit_price',
                    name: 'unit_price',
                    render: function(data) {
                        return `₱ ${data}`;
                    }
                },
                {
                    data: 'selling_price',
                    name: 'selling_price',
                    render: function(data) {
                        return `₱ ${data}`;
                    }
                },
                {
                    data: 'arrival_date',
                    name: 'arrival_date',
                },
                {
                    data: 'expiration_date',
                    name: 'expiration_date',
                },
                {
                    data: 'storage_location',
                    name: 'storage_location',
                },
                {
                    data: 'actions',
                    name: 'actions',
                },
            ]
        });
    });
</script>
@endif
@endsection