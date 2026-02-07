<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['first_name', 'last_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail']);

        $tel = $request->tel1 . $request->tel2 . $request->tel3;
        $contact['tel'] = $tel;

        $category = Category::find($contact['category_id']);

        return view('confirm', compact('contact', 'category'));
    }

    public function store(ContactRequest $request)
    {
    $contact = $request->only([
        'first_name','last_name','gender','email',
        'tel1','tel2','tel3','address','building','category_id','detail'
    ]);

    $contact['tel'] = $request->tel1.$request->tel2.$request->tel3;

    Contact::create($contact);

    return view('thanks');
    }
}
