@extends('Layout.app')
@section('content')
<div class="new-wrapper">
    <div id="main">
        <div class="main_card">
            <div class="neuphormic_shadow" style="padding:10px"><a class="black_anchor" href="javascript:history.back()"><i class="fa fa-chevron-left" aria-hidden="true" style="font-size: 18px;margin-right: 20px;"></i>Back</a></div>
        </div>
        <div class="flip-card-3D-wrapper" style="width: 100% !important;">
            <div class="columns">
                <div class="inner-column" id="flip-card">
                    <div class="flip-card-front" style="padding-top: 10px;">
                        <div class="">
                            <div class="row">
                                <div class="col-md-10">
                                    <h1 class="left_border font_grey" style="float: left;font-size: 35px;">Edit Products</h1>
                                </div>
                            </div>
                            <form name="companyinfo" id="companyinfo" enctype="multipart/form-data" class="form_class" data-parsley-validate autocomplete="off">
                                <div class="padding_20" style="padding: 0px 35px;">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 col-md-12">
                                            <div class="text-field-filled">
                                                <input class="effect-16" type="text" placeholder="" style="clear:both" id="product_name" name="product_name" data-parsley-trigger="blur" required="" value="{{ $details[0]->product_name }}" data-parsley-errors-container=".errorscompany">
                                                <label>Product Name</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12 col-md-12">
                                            <div class="text-field-filled">
                                                <input class="effect-16" type="number" placeholder="" style="clear:both" id="product_price" name="product_price" data-parsley-trigger="blur" required="" value="{{ $details[0]->product_price }}" data-parsley-errors-container=".errorsindustry">
                                                <label>Product Price</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12 col-md-12">
                                            <div class="text-field-filled">
                                                <input class="effect-16" type="text" placeholder="" style="clear:both" id="product_description" name="product_description" data-parsley-trigger="blur" required="" value="{{ $details[0]->product_desccription }}" data-parsley-errors-container=".errorsheadadd">
                                                <label>Product Description</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12 col-md-12">
                                            <div class="upload__box">
                                                <?php
                                                    $i = 0;
                                                    foreach($imageBase64 as $file){
                                                    ?>
                                                        <div class='upload__img-box'>
                                                            <div style='background-image: url("<?php print_r($file); ?>")' data-number='x' data-file='' class='img-bg'>
                                                                <div class='upload__img-close' onclick="removedimages(<?php print_r($i); ?>)"></div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $i++;
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12 col-md-12">
                                            <div class="upload__box">
                                                <div class="upload__btn-box">
                                                    <label class="upload__btn">
                                                        <p>Upload images</p>
                                                        <input type="file" id="files" name="files[]" multiple="" data-max_length="20" class="upload__inputfile">
                                                    </label>
                                                </div>
                                                <div class="upload__img-wrap"></div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="product_id" name="product_id" value="{{ $details[0]->id }}">
                                    </div>
                                </div>
                                <div style="margin: 15px 0px;text-align: center;">
                                    <button type="button" class="btn btn-dark" id="EditProduct" style="border: none;">Submit</button><img src="{{ asset('public/asset/images/pageloader.gif') }}" id="loading-image" style="display:none; width: 40px;">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{ asset('public/asset/js/jquery_213.min.js') }}"></script>
<script src="{{ asset('public/asset/js/SweetAlert_Function.js') }}"></script>
<script src="{{ asset('public/asset/js/SweetAlert.js') }}"></script>
<script>
    var deletedimage = [];
    var base_url = {!!json_encode(url('/')) !!};

    function removedimages(id){
        deletedimage.push(id);
    }

    $("#EditProduct").on("click", function(e) {
        var product_id = $('#product_id').val();
        var product_name = $('#product_name').val();
        var product_price = $('#product_price').val();
        var product_description = $('#product_description').val();
        var images = $('#files').val();
        if (product_name != '') {
            if (product_name && product_price) {
                var ProductDetails = new FormData();
                ProductDetails.append('product_id', product_id);
                ProductDetails.append('product_name', product_name);
                ProductDetails.append('product_price', product_price);
                ProductDetails.append('product_description', product_description);
                ProductDetails.append('deletedimage', deletedimage);
                let TotalFiles = $('#files')[0].files.length; //Total files
                let files = $('#files')[0];
                for (let i = 0; i < TotalFiles; i++) {
                    ProductDetails.append('files' + i, files.files[i]);
                }
                ProductDetails.append('TotalFiles', TotalFiles);
                $('#loading-image').show();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: base_url + '/EditProducts',
                    type: 'POST',
                    data: ProductDetails,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        console.log('Data', data)
                        return;
                    },
                    complete: function(data) {
                        $('#loading-image').hide();
                        // console.log('Data', data)
                        // return;
                        reurl = '/ShowProducts';
                        redirect = base_url + reurl
                        Message = 'Product Edited Successfully'
                        SuccessAlert(Message, redirect)
                    }
                })
            }
        } else {
            Message = 'Please Insert Shift Begin Time!'
            InfoAlert(Message)
        }
    });

</script>
@endsection
