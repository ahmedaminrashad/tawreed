@extends('web.layouts.master')

@section('title', 'Profile - My Proposals')

@section('head')
<style>
</style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container profile-main remove-padding">
        @include('web.profile.aside', ['active' => "proposals"])

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="col-md-8 col-xs-12 proposal-main-cont">
            @if(auth()->user()->proposals->count() > 0)
            <ul class="proposal-tabs-first">
                <li class="active"><a href="javascript:void(0);"><i class="ri-flashlight-line"></i> Current</a></li>
                <li>
                    <p><i class="ri-skip-right-fill"></i> Previous</p>
                </li>
            </ul>
            <ul class="proposal-tabs" role="tablist">
                <li class="active"><a id="tabAll" href="javascript:void(0);">All</a></li>
                @foreach($statuses as $key => $status)
                <li>
                    <a href="#{{ $key }}" role="tab" data-toggle="tab">
                        {{ $status }}
                    </a>
                </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($statuses as $key => $status)
                @if(count($proposals[$key]) > 0)
                @foreach($proposals[$key] as $proposal)
                <div class="tab-pane fade active in" id="{{ $key }}">
                    <div class="col-xs-12 remove-padding propoal-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="ri-more-line"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);">Edit</a></li>
                                <li><a href="javascript:void(0);">Withdraw</a></li>
                                <li><a href="javascript:void(0);">Sample sent</a></li>
                                <li><a href="javascript:void(0);">Print</a></li>
                            </ul>
                        </div>
                        <p>{{ $proposal->tender->subject . ' . ' . $proposal->tender->tender_uuid }}<span>In Progress</span></p>
                        <h4>Proposal Validity Period : <b>{{ $proposal->proposal_end_date }}</b></h4>
                        <h3><span class="tag {{ $status }}-tag">{{ $proposal->status }}</span>Contract Duration by Seller : <b> {{ $proposal->contract_duration }} Day(s)</b></h3>
                        <div class="col-xs-12 remove-padding propoal-img">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <h6>{{ $proposal->tender->user->displayed_name }} . <span>{{ $proposal->tender->user->user_type }}</span></h6>
                        </div>
                        <h5>
                            <span>Total Price </span><br>
                            <b>{{ $proposal->total }} SAR</b>
                        </h5>
                        <a href="{{ route('proposals.show', ['proposal' => $proposal]) }}" class="details">View Details</a>
                    </div>

                </div>    
                @endforeach
                @else
                <div class="tab-pane fade active in" id="{{ $key }}">
                </div>
                @endif
                @endforeach
            </div>
            @else
            <div class="proposal-empty col-xs-12 text-center remove-padding">
                <img src="{{ asset('/assets/front/img/46.svg') }}">
                <p>The is No Proposal Created Yet</p>
            </div>
            @endif
        </div>
    </div>
</div>

<div id="Sample" class="modal fade proposal-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>Sample requested</h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <h2>The Description of request a sample </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur. Pellentesque maecenas vitae nibh eget.
                Lorem ipsum dolor sit amet consectetur. Pellentesque maecenas vitae nibh eget
            </p>
            <ul>
                <li><button data-dismiss="modal">Cancel</button></li>
                <li><a href="javascript:void(0);">Done</a></li>
            </ul>
        </div>
    </div>
</div>

<div id="withdrow" class="modal fade proposal-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>withdraw proposal</h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/41.svg') }}">
            <h2>Are you sure you want to withdraw this proposal ? </h2>
            <ul>
                <li><button data-dismiss="modal">Cancel</button></li>
                <li><a href="javascript:void(0);">Accept</a></li>
            </ul>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('/assets/front/js/profile.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabAll').on('click', function() {
            $('#tabAll').parent().addClass('active');
            $('.tab-pane').addClass('active in');
            $('[data-toggle="tab"]').parent().removeClass('active');
        });
    });

</script>

@endsection
