<div class="filter-widget">
    <h4 class="fw-title">Categories</h4>
    <ul class="filter-catagories">
        @foreach ($type as $key => $dataType)
            <li><a href="{{ URL::to('/choose-type/' . $dataType->id) }}">{{ $dataType->type }}</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="filter-widget">
    <h4 class="fw-title">Descriptions</h4>
    <ul class="filter-catagories">
        @foreach ($description as $key => $dataDescription)
            <li><a
                    href="{{ URL::to('/choose-description/' . $dataDescription->id) }}">{{ $dataDescription->description }}</a>
            </li>
        @endforeach
    </ul>
</div>
<div class="filter-widget">
    <h4 class="fw-title">Weights</h4>
    <div class="fw-size-choose">
        @foreach ($weight as $key => $dataWeight)
            <div class="sc-item">
                {{-- <input type="radio" id="s-size"> --}}
                <a href="{{ URL::to('/choose-weight/' . $dataWeight->id) }}"><label
                        for="s-size">{{ $dataWeight->weight }}</label></a>
            </div>
        @endforeach
    </div>
</div>
<!--/brands_products-->
