<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documentation\UpdateDocumentationRequest;
use App\Models\Documentation;
use App\Services\DocumentationService;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function __construct(
        private readonly DocumentationService $documentationService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $documentations = $this->documentationService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];

            return $this->documentationService->listAjax($data);
        }

        return view('admin.documentations.index', compact('documentations'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Documentation $documentation)
    {
        return view('admin.documentations.show', compact('documentation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documentation $documentation)
    {
        $pageTitle = 'Edit Documentation';

        $pageAction = 'Edit';

        $formTitle = 'Edit Documentation';

        return view('admin.documentations.edit', compact('documentation', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentationRequest $request, Documentation $documentation)
    {
        $data = $request->validated();

        $documentation = $this->documentationService->update($documentation, $data);

        return redirect()->route('admin.documentations.show', ['documentation' => $documentation])->with('success', 'Documentation updated successfully');
    }
}
