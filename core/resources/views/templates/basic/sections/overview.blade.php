@php
    $overview   = getContent('overview.content', true);
    $elements      = getContent('overview.element', false, 4, true);
@endphp

<!-- overview section start -->
<section class="overview-section pt-100 pb-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="section-header text-center">
                    <h2 class="section-title text-white">{{ __(@$overview->data_values->heading) }}</h2>
                    <p class="mt-3 text-white">{{ __(@$overview->data_values->subheading) }}</p>
                </div>
            </div>
        </div><!-- row end -->

        <!-- overview-area end -->
    </div>
</section>
<!-- overview section end -->
