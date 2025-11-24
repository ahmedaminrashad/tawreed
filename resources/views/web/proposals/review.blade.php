@extends('web.layouts.master')

@section('title', 'Create Proposal - Review Proposal')

@section('head')
<style>
</style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('home') }}">{{ __('web.home') }}</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.index') }}">{{ __('web.tenders') }}</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.show', ['tender' => $tender->id]) }}">{{ __('web.show_tender') }} - {{ $tender->subject }}</a></li>
            <li><span>/</span></li>
            <li>
                <p>{{ __('web.create_proposal') }} - {{ __('web.review_proposal') }}</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding add-tender-main add-tender-review">
        <div class="col-xs-12">
            <h1>{{ __('web.send_proposal_to') }} <span>( {{ $tender->subject . ' . ' . $tender->tender_uuid }} )</span></h1>
        </div>
        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>{{ __('web.item_price') }}</h4>
                <p>{{ __('web.unit_price_for_each_item') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>{{ __('web.general_info') }}</h4>
                <p>{{ __('web.add_details_of_proposal') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 active">
                <span>3</span>
                <h4>{{ __('web.preview') }}</h4>
                <p>{{ __('web.review_proposal_info_before_publish') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>

        <div class="col-md-8">
            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>{{ __('web.description') }}</h4>
                    @if(!$proposal->isFinallyAccepted())
                    <a href="#">{{ __('web.edit') }} <i class="ri-pencil-line"></i></a>
                    @endif
                </div>
                <div class="col-xs-12">
                    <p>{{ $proposal->proposal_desc }}</p>
                </div>
            </div>

            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>{{ __('web.items_list') }} <span>( {{ $proposal->items()->count() }} {{ __('web.items') }} )</span></h4>
                    @if(!$proposal->isFinallyAccepted())
                    <a href="#">{{ __('web.edit') }} <i class="ri-pencil-line"></i></a>
                    @endif
                </div>

                @foreach($proposal->items as $key => $item)
                <div class="col-xs-12 table-item">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('web.item_name')}}</th>
                                <th>{{__('web.unit')}}</th>
                                <th>{{__('web.price')}}</th>
                                <th>{{__('web.quantity')}}</th>
                                <th>{{ __('web.total_price') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="#">{{ $key + 1 }}</td>
                                <td data-label="{{__('web.item_name')}}">{{ $item->name }}</td>
                                <td data-label="{{__('web.unit')}}">{{ $item->unit->translate('ar')->name }}</td>
                                <td data-label="{{__('web.price')}}">{{ $item->price }}</td>
                                <td data-label="{{__('web.quantity')}}">{{ $item->quantity }}</td>
                                <td data-label="{{__('web.total_price')}}">{{ $item->quantity * $item->price }}</td>
                                <td class="collapsed toggle-collapse" data-toggle="collapse"
                                    data-target="#media_{{ $key }}">
                                    <i class="ri-file-list-2-line"></i>
                                </td>

                            </tr>
                        </tbody>
                    </table>

                    @if($proposal->media->count() > 0)
                        <p>
                        {{__('web.technical_specifications')}}<br>
                        {{ $item->item_specs }}
                    </p>
                        <div class="item-media collapse" id="media_{{ $key }}">
                            <span>{{ __('web.files') }}</span>
                            <div class="media-files">
                                @foreach($proposal->media as $media)
                                    <div class="media-file gallery">
                                        <div class="media-preview">
                                            @if(isImage($media->url))
                                                <img src="{{ $media->url }}" alt="Preview"
                                                     class="gallery-item">
                                            @else
                                                <a href="{{ $media->url }}" target="_blank">
                                                    <i class="ri-{{ isImage($media->url) ? 'image-line' : 'file-line' }}"></i>
                                                    {{ basename($media->file) }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4">
            <div class="review-item Proposal-Overview  col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12 ">
                    <h4>{{__('web.proposal_overview')}}</h4>
                    <a href="#"><i class="ri-pencil-line"></i></a>
                </div>
                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/10.svg') }}">
                    <h5>{{__('web.contract_duration')}}</h5>
                    <h3>{{ $proposal->contract_duration }} {{__('web.days')}}</h3>
                </div>


                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/42.svg') }}">
                    <h5>{{__('web.proposal_total_price')}}</h5>
                    <h3>{{ $proposal->total }} {{__('web.usd')}}</h3>
                </div>
                <div class="col-xs-12">
                    <img src="{{ asset('/assets/front/img/44.svg') }}">
                    <h5>{{__('web.the_proposal_validity_period')}}</h5>
                    <h3>{{ $proposal->proposal_end_date_text }}</h3>
                </div>

                @if($proposal->payment_terms != 'NA')
                <div class="col-xs-12">
                    <img src="{{ asset('/assets/front/img/44.svg') }}">
                    <h5>{{__('web.payment_terms')}}</h5>
                    <h3>{{ $proposal->payment_terms }}</h3>
                </div>
                @endif
            </div>
        </div>

        @if(!$proposal->isFinallyAccepted())
        <div class="col-xs-12 tender-review-bottom">
            <ul>
                <li><a href="#" data-toggle="modal" data-target="#back-tender">{{__('web.back')}}</a></li>
                <li><a href="#" data-toggle="modal" data-target="#Pulish-tender">{{__('web.publish')}}</a></li>
            </ul>
        </div>
        @endif
    </div>
</div>

<div id="Pulish-tender" class="modal fade tender-model" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('tenders.proposals.publish', ['tender' => $tender, 'proposal' => $proposal]) }}" method="POST">
            @csrf
        <div class="modal-content">
            <h4>{{__('web.publish_tender')}}</h4>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <div class="clearfix"></div>
            <img src="{{ asset('/assets/front/img/14.svg') }}">
            <h1>{{__('web.are_you_sure_you_want_to_submit_this_proposal')}}</h1>
            <h5>
                {{__('web.if_you_submit_your_proposal_you_still_have_the_option_to_edit_or_delete_it_till_the_closing_date')}}
            </h5>
            <ul>
                <li><a href="#" data-dismiss="modal">{{__('web.cancel')}}</a></li>
                <li><input type="submit" value="{{__('web.publish')}}"></li>
                {{-- <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#done-tender">Submit</a></li> --}}
            </ul>
        </div>
        </form>
    </div>
</div>

<div id="back-tender" class="modal fade tender-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/15.svg') }}">
            <h1>{{__('web.if_you_go_back_you_ll_lose_all_the_data_you_ve_inputted_into_the_porpsal')}}</h1>
            <h5>
                {{__('web.if_you_cancel_the_tender_all_unsaved_data_will_be_lost_you_have_the_option_to_either_complete_your_proposal_or_lose_all_the_data_you_ve_inputted_into_it')}}
            </h5>
            <ul>
                <li><a href="#" data-dismiss="modal">{{__('web.cancel_proposal')}}</a></li>
                <li><a href="#">{{__('web.complete_your_proposal')}}</a></li>
            </ul>
        </div>

    </div>
</div>

<div id="done-tender" class="modal fade tender-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/16.svg') }}">
            <h1>{{__('web.your_proposal_is_submitted_successfully')}}</h1>
            <h5>
                {{__('web.you_still_have_the_option_to_edit_or_delete_it_from_my_proposal')}}
            </h5>
            <ul>
                    <li><a href="#" data-dismiss="modal">{{__('web.done')}}</a></li>
            </ul>
        </div>

    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
</script>

@endsection
