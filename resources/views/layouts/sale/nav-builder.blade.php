<div class="filter-widget" style="margin-top: 15px; margin-bottom: 10px;">
    <img src="{{ '/frontend/images/sale-logo-1.jpg' }}" style="height: 86px;width: 100%;" alt="">
</div>
<hr>

<div class="filter-widget" style="background-color: white; margin-bottom: 38px;">
    <h4 class="fw-title" style="margin-bottom: 6px;font-size:26px;">Categories Product</h4>
    <ul class="filter-catagories c-sidebar-nav">
        @foreach ($type as $key => $dataType)
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                    href="{{ URL::to('/choose-type/' . $dataType->id) }}">{{ $dataType->type }}</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="filter-widget" style="background-color: white; margin-bottom: 38px;">
    <h4 class="fw-title" style="margin-bottom: 6px;font-size:26px;">Descriptions Product</h4>
    <ul class="filter-catagories c-sidebar-nav">
        @foreach ($description as $key => $dataDescription)
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                    href="{{ URL::to('/choose-description/' . $dataDescription->id) }}">{{ $dataDescription->description }}</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="filter-widget" style="background-color: white; margin-bottom: 38px;">
    <h4 class="fw-title" style="margin-bottom: 6px;font-size:26px;">Weights Product</h4>
    <ul class="filter-catagories c-sidebar-nav">
        @foreach ($weight as $key => $dataWeight)
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                    href="{{ URL::to('/choose-weight/' . $dataWeight->id) }}">{{ $dataWeight->weight }}</a>
            </li>
        @endforeach
    </ul>
</div>
<hr>

<div class="filter-widget" style="background-color: white; margin-bottom: 10px;text-align: center;">
    <img src="{{ '/frontend/images/phone.png' }}" style="height: 91px;width: 42%;" alt=""> <br><br>
    <b style="font-weight: 900;">HOTLINE</b> <br>
    <b style="font-weight: 900;color:red;font-size: 21px;">091 2345 678</b>
</div>
<hr>

<div class="filter-widget" style="background-color: white; margin-bottom: 10px;text-align: center;">

    <div class="fb-page" data-href="https://www.facebook.com/Mekhoebexinh02/" data-tabs="timeline" data-width="" data-height="40px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Mekhoebexinh02/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Mekhoebexinh02/">Fresh Mama - Nguồn dinh dưỡng tự nhiên</a></blockquote></div>
</div>