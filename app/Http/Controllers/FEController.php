<?php

namespace App\Http\Controllers;

class FEController extends Controller
{
    public function company()
    {
        return view('admin.company');
    }
    public function employees()
    {
        return view('admin.employees');
    }
    public function login()
    {
        return view('login');
    }
}
