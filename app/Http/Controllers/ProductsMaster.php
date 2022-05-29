<?php

namespace App\Http\Controllers;

use File;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class ProductsMaster extends Controller
{
    public function ShowProducts()
    {
        return view('ShowProducts');
    }

    public function FetchProductsData()
    {
        $details = DB::table('products')->get();
        return Datatables::of($details)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                $id = Crypt::encrypt($query->id);
                return '<a href="' . action('ProductsMaster@EditProductsView', Crypt::encrypt($query->id)) . '" id="userform' . $query->id . '"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp; <a onclick="deleteproduct(' . $query->id . ')" id="userform' . $query->id . '"> <i class="fa fa-trash-o" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function AddProductsView()
    {
        return view('AddProducts');
    }

    public function AddProducts(Request $data)
    {
        $product_name = $data->product_name;
        $product_price = $data->product_price;
        $product_description = $data->product_description;
        $files = $data->files;
        $TotalFiles = $data->TotalFiles;

        $images = [];
        if ($data->TotalFiles > 0) {
            for ($x = 0; $x < $data->TotalFiles; $x++) {
                if ($data->hasFile('files' . $x)) {
                    $file = $data->file('files' . $x);
                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/files/', $name);
                    $images[] = $name;
                }
            }
        }

        $InsertData['product_name'] = $product_name;
        $InsertData['product_price'] = $product_price;
        $InsertData['product_desccription'] = $product_description;
        $InsertData['product_image'] = serialize($images);

        $CheckDuplicate = DB::table('products')->where(['product_name' => $product_name])->count();
        if ($CheckDuplicate < 1) {
            $Responce = DB::table('products')->insert($InsertData);
            if ($Responce) {
                $Responce = 'Success';
            } else {
                $Responce = 'Something Went Wrong';
            }
        } else {
            $Responce = 'Already Exists';
        }
        return json_encode($Responce);
    }

    public function EditProductsView($id)
    {
        $id = Crypt::decrypt($id);
        $details = DB::table('products')->where('id', $id)->get();
        $Oproduct_image = unserialize($details[0]->product_image);
        $imageBase64 = [];
        foreach ($Oproduct_image as $key => $value) {
            $path = public_path() . '/files/' . $value;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $imageBase64[] = $base64;
        }
        return view('EditProducts', compact('id', 'details', 'imageBase64'));
    }


    public function EditProducts(Request $data)
    {
        $product_id = $data->product_id;
        $product_name = $data->product_name;
        $product_price = $data->product_price;
        $product_description = $data->product_description;
        $deletedimage = explode(',', $data->deletedimage);
        $files = $data->files;
        $TotalFiles = $data->TotalFiles;

        $images = [];
        if ($data->TotalFiles > 0) {
            for ($x = 0; $x < $data->TotalFiles; $x++) {
                if ($data->hasFile('files' . $x)) {
                    $file = $data->file('files' . $x);
                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/files/', $name);
                    $images[] = $name;
                }
            }
        }

        $Oproduct_image = [];
        $getProductDetails = DB::table('products')->where('id', $product_id)->get();
        $Oproduct_name = $getProductDetails[0]->product_name;
        $Oproduct_price = $getProductDetails[0]->product_price;
        $Oproduct_desccription = $getProductDetails[0]->product_desccription;
        $GetProductimage = unserialize($getProductDetails[0]->product_image);
        foreach ($GetProductimage as $key => $Image) {
            if(!in_array($key,$deletedimage )){
                $Oproduct_image[] = $Image;
            }
        }

        $UpdateData['product_name'] = $product_name;
        $UpdateData['product_price'] = $product_price;
        $UpdateData['product_desccription'] = $product_description;
        $UpdateData['product_image'] = serialize(array_merge($Oproduct_image, $images));

        $Responce = DB::table('products')->where('id', $product_id)->update($UpdateData);
        if ($Responce) {
            $Responce = 'Success';
        } else {
            $Responce = 'Something Went Wrong';
        }
        return json_encode($Responce);
    }


    public function DeleteProducts($id)
    {
        $Responce = DB::table('products')->where('id', $id)->delete();
        if ($Responce) {
            $Responce = 'Done';
        } else {
            $Responce = 'Something Went Wrong';
        }
        return json_encode($Responce);
    }
}
