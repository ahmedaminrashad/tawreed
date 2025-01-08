<?php

namespace App\Services;

use App\Enums\TenderStatus;
use App\Models\Country;
use App\Models\Tender;
use App\Models\TenderItem;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class TenderService
{
    // list all Tenders function
    public function list() {}

    // list all Tenders function AJAX
    public function listAjax($ajaxData)
    {
        $data = Country::select('*');

        return DataTables::of($data)
            ->filter(function ($query) use ($ajaxData) {
                if ($ajaxData['search']['value']) {
                    $query->whereHas('translations', function ($query) use ($ajaxData) {
                        $search = $ajaxData['search']['value'];
                        $query->where('name', 'like', '%' . $search . '%');
                    });
                }
            }, true)
            ->addIndexColumn()
            ->addColumn('ar_name', function (Country $country) {
                return html_entity_decode($country->translate('ar')->name);
            })
            ->addColumn('vat', function (Country $country) {
                return html_entity_decode($country->vat . '%');
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'ar_name', 'vat'])
            ->make(true);
    }

    // get Tender by ID function
    public function getById($id)
    {
        $tender = Tender::find($id);

        return $tender;
    }

    // Store new Tender
    public function create($data, Tender $tender = null)
    {
        try {
            DB::beginTransaction();

            if ($tender) {
                $tender->update($data);
            } else {
                $tender = Tender::create($data);
            }

            DB::commit();

            return $tender;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Store Tender Items
    public function itemsStore(Tender $tender, $data)
    {
        try {
            DB::beginTransaction();

            $tender->items()->delete();

            foreach ($data['item'] as $item) {
                TenderItem::create([
                    'tender_id' => $tender->id,
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit_id' => $item['unit_id'],
                    'specs' => $item['specs'],
                ]);
            }

            DB::commit();

            $result = $this->updateStatus($tender, TenderStatus::CREATED->value);
            if (is_array($result)) {
                return ['error' => 'Error in update Tender Status'];
            }

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Publish Tender
    public function publish(Tender $tender)
    {
        try {
            $result = $this->updateStatus($tender, TenderStatus::PUBLISHED->value);
            if (is_array($result)) {
                return ['error' => 'Error in publish Tender Status'];
            }

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Update Tender
    public function update(Tender $tender, $data)
    {
        try {
            DB::beginTransaction();

            $tender->update($data);

            DB::commit();

            return $tender;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Update Tender Status
    public function updateStatus(Tender $tender, $status)
    {
        try {
            DB::beginTransaction();

            $tender->update([
                'status' => $status
            ]);

            DB::commit();

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Delete Tender
    public function delete(Tender $tender)
    {
        return $tender->delete();
    }
}
