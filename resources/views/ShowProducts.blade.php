@extends('Layout.app')
@section('content')
<div class="new-wrapper">
    <div id="main">
        <div id="main">
            <div class="main_card">
                <div class="neuphormic_shadow fst_card">
                    <div class="fst_card_cntnt">
                        <h3 class="h3_header_prt" style=""><label class="ralway_font">Products Master</label>
                        </h3>
                    </div>
                    <div style="float:right;">
                        <a href="{{ url('AddProductsView') }}" class="btnn"><i class="fa fa-plus" style="padding-right: 10px;" aria-hidden="true"></i>Add Products</a>
                    </div>
                </div>
            </div>
            <div>
            </div>
            <br>
            <img src="{{ asset('public/asset/images/pageloader.gif') }}" id="loading-image" style="display:none; width: 40px;">
            <div class="margin_left_right">
                <table id="product-table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Products Name</th>
                            <th>Product Price</th>
                            <th>Products Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('public/asset/js/jquery.js') }}"></script>
<script src="{{ asset('public/asset/js/datatables.min.js') }}"></script>
<script src="{{ asset('public/asset/js/SweetAlert_Function.js') }}"></script>
<script src="{{ asset('public/asset/js/SweetAlert.js') }}"></script>
<script>
    var path = {!!json_encode(url('/')) !!};
    $(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#product-table').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Search records",
                search: "<i class='fa fa-search' aria-hidden='true'></i>",
                paginate: {
                    next: '<span class="typcn typcn-arrow-right-outline"></span>', // or '→'
                    previous: '<span class="typcn typcn-arrow-left-outline"></span>' // or '←'
                }
            },
            processing: true,
            serverSide: true,
            searchable: true,
            ajax: {
                url: path + '/FetchProductsData',
                type: 'post',
                data: {
                    _token: CSRF_TOKEN
                },
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'product_price',
                    name: 'product_price'
                },
                {
                    data: 'product_desccription',
                    name: 'product_desccription'
                },
                // {
                //     data: 'product_image',
                //     name: 'product_image'
                // },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    });

    function deleteproduct(id) {
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: path + '/DeleteProduct/' + id,
                    type: 'get',
                    success: function(data) {
                        // console.log('Data', data);
                        // return;
                        var response = data.trim();
                        if (response == 'Done') {
                            Message = 'Product Deleted Sucessfully'
                            DeleteAlert(Message)
                        } else {
                            Message = 'Something Went Wrong'
                            InfoAlert(Message)
                        }
                        location.reload();
                    },
                    complete: function() {
                        $('#loading-image').hide();
                    }
                })
            }
        });
    };
</script>

@endsection
