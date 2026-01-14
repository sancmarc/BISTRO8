@extends('layouts.apps')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Billing') }}
                </div>

                <div class="card-body">
                    <table class="table table-hover table-condensed  dt-responsive nowrap" id="billingTable">
                        @php
                        $billing = ['Part Number','Part Name','Sold to','Delivery Receipt','Delivery Date','Delivered By','Billing Date','Payment Date','Processing','Sold /kg','Memo','Cut Fee','Final Price','Returned'];
                        @endphp
                        <thead>
                            <th>&#35;</th>
                            @foreach ($billing as $th)
                            <th>{{$th}}</th>
                            @endforeach
                            <th>actions</th>

                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="returnModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="returnModalLabel">Return Item Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{route('return.items')}}" method="post" id="returnedItemForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="form-control" id="inventory_id" name="inventory_id">
                            <input type="hidden" class="form-control" id="billing_id" name="billing_id">
                            <div class="col-md-12">
                                <label for="quantity_stocks" class="form-label">Quantity</label>
                                <input class="form-control" type="numeric" id="quantity_stocks" name="quantity_stocks" readonly>
                            </div>
                            <div class="col-md-12">
                                <label for="returned_by" class="form-label">Return By</label>
                                <input class="form-control" type="text" id="returned_by" name="returned_by">
                            </div>
                            <div class="col-md-12">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea class="form-control" name="reason" id="reason" cols="30" rows="4"></textarea>
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
    <script type="module">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {

            $('#billingTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: "{{ route('list.billing')}}",
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "ALL"]
                ],
                columns: [{
                        data: 'billedID',
                        name: 'billedID',
                    },
                    {
                        data: 'inventoryID',
                        name: 'inventoryID',
                        render: function(data) {
                            return `Part &num; ${data}`;
                        }
                    },
                    {
                        data: 'partName',
                        name: 'partName',
                    },
                    {
                        data: 'soldTo',
                        name: 'soldTo',
                    },
                    {
                        data: 'deliveryReceipt',
                        name: 'deliveryReceipt',
                    },
                    {
                        data: 'deliveryDate',
                        name: 'deliveryDate',
                    },
                    {
                        data: 'deliveredBy',
                        name: 'deliveredBy',
                    },
                    {
                        data: 'billingDate',
                        name: 'billingDate',
                    },
                    {
                        data: 'paymentDate',
                        name: 'paymentDate',
                    },
                    {
                        data: 'processing',
                        name: 'processing',
                    },
                    {
                        data: 'brought',
                        name: 'brought',
                    },
                    {
                        data: 'memo',
                        name: 'memo',
                    },
                    {
                        data: 'cutFee',
                        name: 'cutFee',
                    },
                    {
                        data: 'finalPrice',
                        name: 'finalPrice',
                    },
                    {
                        data: 'returned',
                        name: 'returned',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                    },

                ]
            });
            $(document).on('click', '#returnBtn', function(e) {
                const billingId = $(this).data('id');
                const inventoryId = $(this).val();
                $('#returnModal').modal('show');
                $('#inventory_id').val(inventoryId);
                $('#billing_id').val(billingId);
                $.get('{{route("get.billing")}}', {
                    billingId: billingId
                }, function(data) {

                    $('#returnModal').find('#quantity_stocks').val(data.details.usage);
                })
            })
            $('#returnedItemForm').on('submit', function(e) {
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
                                    $('#returnModal').modal('hide');
                                    $(form)[0].reset();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Successfully!',
                                        text: data.msg,
                                        timer: 3500
                                    })
                                    $('#billingTable').DataTable().draw();
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
    @endsection