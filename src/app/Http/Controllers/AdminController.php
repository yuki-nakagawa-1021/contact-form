<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
        {
            $contacts = Contact::with('category')
                ->paginate(7);

            $categories = Category::all();

            return view('admin.index', compact('contacts' , 'categories'));
        }
}
