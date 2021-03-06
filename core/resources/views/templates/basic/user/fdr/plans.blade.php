@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container">
        <div class="plan-area mb-none-30">
            <div class="row justify-content-center gy-4">
                @foreach($plans as $plan)
                    <div class="col-lg-4 col-md-6">
                        <div class="plan-card rounded-3 wow fadeInUp gy-3">
                            <div class="plan-card__header">
                                <div class="wave-shape"><img src="{{ asset($activeTemplateTrue. 'images/elements/wave.png') }}" alt="img"></div>
                            <h4 class="plan-name">{{ __($plan->name) }}</h4>
                            <div class="plan-price">{{ getAmount($plan->interest_rate) }}%<sub>/ {{ $plan->interest_interval }} @lang('Days')</sub></div>
                            </div>
                            <div class="plan-card__body text-center">
                                <ul class="plan-feature-list">
                                    <li class="d-flex flex-wrap justify-content-between">
                                        <span>@lang('Lock in Period')</span>
                                        {{ $plan->locked_days }} @lang('Days')
                                    </li>

                                    <li class="d-flex flex-wrap justify-content-between">
                                        <span>@lang('Get Profit') @lang('Every')</span>
                                        {{ $plan->interest_interval }} @lang('Days')
                                    </li>

                                    <li class="d-flex flex-wrap justify-content-between">
                                        <span>@lang('Profit Rate')</span>
                                        {{ getAmount($plan->interest_rate) }}%
                                    </li>

                                    <li class="d-flex flex-wrap justify-content-between">
                                        <span>@lang('Minimum') </span>
                                        {{ $general->cur_sym }}{{ showAmount($plan->minimum_amount) }}
                                    </li>
                                    <li class="d-flex flex-wrap justify-content-between">
                                        <span>@lang('Maximum')</span>
                                        {{ $general->cur_sym }}{{ showAmount($plan->maximum_amount) }}
                                    </li>
                                </ul>
                            </div>
                            <div class="plan-card__footer text-center">
                                @auth
                                    <button type="button" data-id="{{ $plan->id }}" data-minimum="{{ $general->cur_sym }}{{ showAmount($plan->minimum_amount) }}" data-maximum="{{ $general->cur_sym }}{{ showAmount($plan->maximum_amount) }}" class="btn btn-md w-100 btn--base fdrBtn">@lang('Apply Now')</button>
                                @else
                                    <a href="{{route('user.login')}}" class="btn btn-md w-100 btn--base">@lang('Apply Now')</a>
                                @endauth
                            </div>
                        </div><!-- plan-card end -->
                    </div>
                @endforeach
            </div>
            {{ $plans->links() }}
        </div>
    </div>
@endsection

@push('modal')
<div class="modal fade" id="fdrModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title method-name" id="exampleModalLabel">@lang('Apply to Open an FDR')</strong>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
            </div>
            <form action="{{route('user.action')}}" method="post">
                @csrf

                <div class="modal-body">
                    <input type="hidden" name="id">
                    <input type="hidden" name="type" value="fdr">

                    <div class="form-group mt-0">
                        <label for="amount">@lang('Amount') *</label>
                        <input type="text" id="amount" name="amount" class="form--control integer-validation" required>
                        <p><small class="text--danger min-limit mt-2"></small></p>
                        <p><small class="text-danger max-limit"></small></p>
                    </div>


                    @if(checkIsOtpEnable($general))
                        @include($activeTemplate.'partials.otp_field')
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-danger text-white" data-bs-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn-md custom--bg text-white">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.fdrBtn').on('click', (e)=> {
                var modal   = $('#fdrModal');
                var button  = $(e.currentTarget);
                modal.find('input[name=id]').val(button.data('id'));
                modal.find('.min-limit').text(`Minimum Amount ${button.data('minimum')}`);
                modal.find('.max-limit').text(`Maximum Amount ${button.data('maximum')}`);

                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush


@push('bottom-menu')
    <li>
        <a href="{{ route('user.fdr.plans') }}" class="active">@lang('FDR Plans')</a>
    </li>
    <li>
        <a href="{{ route('user.fdr.list') }}">@lang('My FDR List')</a>
    </li>
@endpush
