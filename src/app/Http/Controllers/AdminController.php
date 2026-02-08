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

    public function export(Request $request): StreamedResponse
    {
        $query = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->date)
            ->latest();

        $fileName = 'contacts_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['お名前', '性別', 'メールアドレス', 'お問い合わせの種類', 'お問い合わせ内容', '作成日']);

            $query->chunk(500, function ($contacts) use ($handle) {
                foreach ($contacts as $c) {
                    $genderText = $c->gender == 1 ? '男性' : ($c->gender == 2 ? '女性' : 'その他');

                    fputcsv($handle, [
                        $c->last_name . ' ' . $c->first_name,
                        $genderText,
                        $c->email,
                        optional($c->category)->content,
                        $c->detail,
                        optional($c->created_at)->format('Y-m-d'),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

}
