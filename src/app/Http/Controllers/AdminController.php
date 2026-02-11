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

    public function export()
    {
        $contacts = Contact::with('category')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="contacts.csv"',
        ];

        $callback = function () use ($contacts) {
            $out = fopen('php://output', 'w');

            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, ['ID', '姓', '名', '性別', 'メール','お問い合わせの種類']);

            foreach ($contacts as $c) {
                fputcsv($out, [
                    $c->id,
                    $c->last_name,
                    $c->first_name,
                    $c->gender,
                    $c->email,
                    optional($c->category)->content,
                ]);
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->back()->with('message', '削除しました');
    }

}
