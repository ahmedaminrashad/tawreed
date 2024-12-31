@extends('web.layouts.master')

@section('title', 'Create Tender - Add Item(s)')

@section('head')
<style></style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span>/</span></li>
            <li>
                <p>Create tender</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding add-tender-main">
        <div class="col-xs-12">
            <h1>Create New Tender bid </h1>
        </div>
        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>General info</h4>
                <p>Add info about your Tender</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 done">
                <span>2</span>
                <h4>Add Item(s)</h4>
                <p>Add one Item or more with details</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 active">
                <span>3</span>
                <h4>Preview</h4>
                <p>Review your Tender info before publish</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>

        <div class="col-md-8">
            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Description</h4>
                    <a href="#">Edit <i class="ri-pencil-line"></i></a>
                </div>
                <div class="col-xs-12">
                    <p>
                        {{ $tender->desc }}
                    </p>
                </div>
            </div>

            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Items list <span>( {{ $tender->items()->count() }} item(s) )</span></h4>
                    <a href="#">Edit <i class="ri-pencil-line"></i></a>
                </div>

                <div class="col-xs-12 table-item">
                    @foreach($tender->items as $key => $item)
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ITEM NAME</th>
                                <th>UNITS</th>
                                <th>QUANTITIES</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="#">{{ $key++ }}</td>
                                <td data-label="item name">{{ $item->name }}</td>
                                <td data-label="Units">{{ $item->unit->translate('ar')->name }}</td>
                                <td data-label="Quantities">{{ $item->quantity }}</td>
                                <td class="collapsed" data-toggle="collapse" data-target="#specs">See more</td>
                            </tr>
                        </tbody>
                    </table>
                    <p id="specs" class="collapse">
                        {{ $item->specs }}
                    </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {});

</script>

@endsection
