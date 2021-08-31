<?php

namespace App\Http\Controllers\Sale;

use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $breadcrumbs = ['Contact'];
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->get();
        return view("sale.contact.index", ['breadcrumbs' => $breadcrumbs], compact('type'));
    }
}
