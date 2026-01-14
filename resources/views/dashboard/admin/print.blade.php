@extends('layouts.apps')
<style>
    /* style sheet for "index card" printing */
    @media print and (width: 12.7cm) and (height: 7.62cm) {
        @page {
            size: landscape;
           
        }
    }

    @media print {
        @page {
            size: auto;
            margin: 0mm;
        }


        body {
            margin: 0;
            visibility: hidden;
        }

        #divToPrint {
            top: 0;
            left: 0;
            visibility: visible;
            position: absolute;
            margin-top: -110;
            padding: 0;
        
        
        }


    }
</style>
@section('content')
<div class="container" onload="printOnload">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Print') }}</div>

                <div class="card-body">
                    <div class="card">
                        @php
                        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                        $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                        $partNumber = 'Part Number '.$printData->id;
                        @endphp

                        <table class="table table-bordered print-container" id="divToPrint">
                             <tr>
                                <td>Sold to &colon; {{$printData->sold_to}}</td>
                                <td><h1><b>Bistro 8</b></h1></td>
                               
                            </tr>
                            <tr>
                    
                                <td>Part Name &colon; {{$printData->part_name}}</td>
                                <td>Part Area &colon; {{$printData->part_area}}</td>
                            </tr>
                            <tr>
                                <td colspan='2' class="text-center"><img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($printData->id, $generatorPNG::TYPE_CODE_128)) }}"></td>
                            </tr>
                            <tr>
                                 <td>Weight &colon; {{$printData->usage}} kg</td>
                                <td>Delivery Date &colon; {{$printData->delivery_date}}</td>
                             
                            </tr>
                              <tr>
                      
                                <td>Expiration Date &colon; {{$printData->expiration_date}}</td>
                                <td>Total &colon; {{$printData->final_price}}</td>
                            </tr>
                        </table>
                        <div class="card-footer">
                            <!-- <input class="btn btn-primary float-end" type='button' id='btn' value='Print'> -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    window.print();
    $(document).ready(function() {
        $(document).on('click', '#btn', function() {
            let divToPrint = document.getElementById('divToPrint');
            console.log(divToPrint);
            let popupWin = window.open('', '_blank', 'width=1000,height=1000');
            popupWin.document.open();
            popupWin.document.write('<html><style>@media print{@page{size:auto; margin:0mm;}{body{margin:0;}}}body{text-align:center;margin:auto;}table{border:2px solid; padding:5px;margin:5px;}td{border:1px solid;padding:10px;margin:10px;}.text-center{text-align:center; margin:10px}</style><body onload="window.print()" style="padding:8px;">' + divToPrint.outerHTML + '</html>');
            popupWin.document.close();
        })
    })
</script>
@endsection