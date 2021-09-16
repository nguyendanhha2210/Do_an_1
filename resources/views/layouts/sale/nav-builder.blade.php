<div class="filter-widget" style="margin-top: 4px; margin-bottom: 19px;">
    <img src="{{ '/frontend/images/sale-logo-1.jpg' }}" style="height: 86px;width: 100%;" alt="">
</div>

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
