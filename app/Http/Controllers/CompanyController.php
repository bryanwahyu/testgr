<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company=Company::all();
        return view('admin.company',compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required'],
        ]);
        $data=$request->all();
        if($request->has('base64logo')){
            $image_64=$request->base64logo;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

            $replace = substr($image_64, 0, strpos($image_64, ',')+1);

          // find substring fro replace here eg: data:image/png;base64,

           $image = str_replace($replace, '', $image_64);

           $image = str_replace(' ', '+', $image);

           $imageName = Str::random(10).'.'.$extension;

           Storage::disk('public')->put($imageName, base64_decode($image));

        }
        $data['logo']=$imageName;

        $company=new Company;
        $company->fill($data);
        $company->save();

        $json['code']=200;
        $json['data']=$company;

        return response()->json($json);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $json['data']=$company;
        $json['code']=200;

        return response()->json($json);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'=>"required"
        ]);

        if($request->has('base64logo')){
            $image_64=$request->base64logo;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

            $replace = substr($image_64, 0, strpos($image_64, ',')+1);

          // find substring fro replace here eg: data:image/png;base64,

           $image = str_replace($replace, '', $image_64);

           $image = str_replace(' ', '+', $image);

           $imageName = Str::random(10).'.'.$extension;

           Storage::disk('public')->put($imageName, base64_decode($image));

        }
        $data=$request->all();
        $data['logo']=$imageName;

        $company->fill($data);
        $company->save();


        $json['code']=200;
        $json['data']=$company;

        return response()->json($json);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        $json['code']=201;
        $json['data']="success";

        return response()->json($json);

    }
}
