<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\BrandModel;
use App\Models\SmartPhoneModel;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    { 
        $model=BrandModel::all();

        return view('brands.index',compact('model'));
    }
    public function addForm()
    {
        return view('brands.add');
    }
    public function saveAdd(BrandRequest $request)
    {
        $model=new BrandModel();
        $model->fill($request->all());
        if ($request->hasFile('uploadfile')) {
            $path = 'uploads/logo';
            $model->logo = $request->file('uploadfile')->storeAs($path, uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }
        $model->save();

        return redirect(route('brand.index'));
    }
    public function editForm($id)
    { $model=BrandModel::find($id);
        return view('brands.edit',compact('model'));
    }
    public function saveEdit($id,BrandRequest $request)
    {
        $model=BrandModel::find($id);
        $model->fill($request->all());
        if($request->hasFile('uploadfile')){
            $model->logo = $request->file('uploadfile')->storeAs('upload/logo', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }
        $model->save();
        return redirect(route('brand.index'));
    }
    public function remove($id){
        BrandModel::destroy($id);
        return redirect()->back();


    }
}
