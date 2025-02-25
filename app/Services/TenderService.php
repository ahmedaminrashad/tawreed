<?php

namespace App\Services;

use App\Enums\TenderStatus;
use App\Models\Tender;
use App\Models\TenderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

readonly class TenderService
{
    // list all Tenders function
    public function list($data)
    {
        $today = Carbon::today()->format('Y-m-d');

        $tenders = Tender::where('closing_date', '>', $today);
        
        if ($data['userId']) {
            $tenders = $tenders->where('user_id', $data['userId']);
        }

        if($data['status']){
            $tenders = $tenders->where('status', $data['status']);
        }

        return $tenders->orderBy('created_at', 'DESC')->get();
    }

    // list all Published Tenders function
    public function listPublished()
    {
        $today = Carbon::today()->format('Y-m-d');

        return Tender::where('status', TenderStatus::IN_PROGRESS->value)
            ->where('closing_date', '>', $today)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    // list all Published Tenders With filters function
    public function listFilterPublished($filters)
    {
        $today = Carbon::today()->format('Y-m-d');

        $filterCount = 0;

        $query = Tender::with('user', 'country', 'city', 'workCategoryClassification', 'activityClassification')
            ->where('status', TenderStatus::IN_PROGRESS->value)
            ->where('closing_date', '>', $today);

        if (isset($filters['range_from'])) {
            $query = $query->where('contract_duration', '>=', $filters['range_from']);
            $filterCount++;
        }

        if (isset($filters['range_to'])) {
            $query = $query->where('contract_duration', '<=', $filters['range_to']);
            $filterCount++;
        }

        if (isset($filters['category_filter']) && !in_array('all', $filters['category_filter'])) {
            $query = $query->whereIn('category_id', $filters['category_filter']);
            $filterCount++;
        }

        if (isset($filters['country_filter']) && !in_array('all', $filters['country_filter'])) {
            $query = $query->whereIn('country_id', $filters['country_filter']);
            $filterCount++;
        }

        if (isset($filters['classification_filter']) && !in_array('all', $filters['classification_filter'])) {
            $query = $query->whereIn('activity_id', $filters['classification_filter']);
            $filterCount++;
        }

        if (isset($filters['user_type_filter']) && !in_array('all', $filters['user_type_filter'])) {
            $userType = $filters['user_type_filter'];
            $query = $query->whereHas('user', function ($qry) use ($userType) {
                $qry->where('users.type', $userType);
            });
            $filterCount++;
        }

        if (isset($filters['recent_filter']) && $filters['recent_filter'] == 1) {
            $query = $query->orderBy('created_at', 'DESC');
            $filterCount++;
        }

        if (isset($filters['closing_filter']) && $filters['closing_filter'] == 1) {
            $query = $query->orderBy('closing_date', 'ASC');
            $filterCount++;
        }

        $data['tenders'] = $query->get();
        $data['filterCount'] = $filterCount;

        return $data;
    }

    // list all Tenders function AJAX
    public function listAjax($ajaxData) {}

    // get Tender by ID function
    public function getById($id)
    {
        $tender = Tender::find($id);

        return $tender;
    }

    // get Tender Item by ID function
    public function getItemById($id)
    {
        $tenderItem = TenderItem::find($id);

        return $tenderItem;
    }

    // Store new Tender
    public function create($data, Tender $tender = null)
    {
        try {
            DB::beginTransaction();

            if ($tender->id) {
                $tender->update($data);

                $tender->update([
                    'tender_uuid' => Carbon::now()->format('Y') . Carbon::now()->format('m') . $tender->user_id . $tender->id
                ]);

            } else {
                $tender = Tender::create($data);

                $tender->update([
                    'tender_uuid' => Carbon::now()->format('Y') . Carbon::now()->format('m') . $tender->user_id . $tender->id
                ]);
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
            $result = $this->updateStatus($tender, TenderStatus::IN_PROGRESS->value);
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
