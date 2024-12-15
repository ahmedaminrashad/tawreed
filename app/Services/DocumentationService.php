<?php

namespace App\Services;

use App\Models\Documentation;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class DocumentationService
{
    // list all Documentations function
    public function list()
    {
        $documentations = Documentation::all();
        return $documentations;
    }

    // list all Documentations function AJAX
    public function listAjax($ajaxData)
    {
        $data = Documentation::select('*')->orderBy($ajaxData['orderBy'], $ajaxData['orderDir']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'value', 'key'])
            ->make(true);
    }

    // Update Documentation
    public function update(Documentation $documentation, $data)
    {
        DB::beginTransaction();

        $documentation->translation()->delete();

        $documentationTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $documentationTranslations[] = [
                'locale' => $locale,
                'page' => $data[$locale . '_page'],
            ];
        }

        $documentation->translation()->createMany($documentationTranslations);

        DB::commit();

        return $documentation;
    }
}
