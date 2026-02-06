<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['first_name', 'last_name', 'gender', 'email', 'address', 'building', 'category_id', 'detail']);

        $tel = $request->tel1 . $request->tel2 . $request->tel3;
        $contact['tel'] = $tel;

        $category = Category::find($contact['category_id']);

        return view('confirm', compact('contact', 'category'));
    }

    public function store(ContactRequest $request)
    {
        $contact = $request->only(['first_name', 'last_name', 'gender', 'email', 'address', 'building', 'category_id', 'detail']);

        $tel = $request->tel1 . $request->tel2 . $request->tel3;
        $contact['tel'] = $tel;

        Contact::create($contact);

        return view('thanks');
    }
}
