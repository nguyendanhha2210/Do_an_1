{{-- <div style="margin-top: 16px;text-align: center;">
    <a href="#"><img src="{{ '/frontend/images/logo-sale.jpg' }}" style="height: 91px;width: 88%;" alt=""></a>
</div> --}}

<div class="filter-widget" style="margin-top: 16px; margin-bottom: 10px;">
    <div style="width:100%" class="fb-page" data-href="https://www.facebook.com/Mekhoebexinh02/"
        data-tabs="timeline" data-width="" data-height="40px" data-small-header="false"
        data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
        <blockquote cite="https://www.facebook.com/Mekhoebexinh02/" class="fb-xfbml-parse-ignore"><a
                href="https://www.facebook.com/Mekhoebexinh02/">Fresh Mama - Nguồn dinh dưỡng tự nhiên</a></blockquote>
    </div>
</div>
<hr>

<div class="filter-widget" style="background-color: white; margin-bottom: 20px;">
    <h4 class="fw-title" style="margin-bottom: 6px;font-size:26px;">Categories Product</h4>
    <ul class="filter-catagories c-sidebar-nav">
        @foreach ($type as $key => $dataType)
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                    href="{{ URL::to('/choose-type/' . $dataType->id) }}">{{ $dataType->type }}</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="filter-widget" style="background-color: white; margin-bottom: 20px;">
    <h4 class="fw-title" style="margin-bottom: 6px;font-size:26px;">Descriptions Product</h4>
    <ul class="filter-catagories c-sidebar-nav">
        @foreach ($description as $key => $dataDescription)
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                    href="{{ URL::to('/choose-description/' . $dataDescription->id) }}">{{ $dataDescription->description }}</a>
            </li>
        @endforeach
    </ul>
</div>

<hr>

<div class="filter-widget" style="background-color: white; margin-bottom: 12px;text-align: center;">
    <img src="{{ '/frontend/images/phone.png' }}" style="height: 91px;width: 42%;" alt=""> <br><br>
    <b style="font-weight: 900;">HOTLINE</b> <br>
    <b style="font-weight: 900;color:red;font-size: 21px;">091 2345 678</b>
</div>
<hr>

<div class="filter-widget" style="background-color: white; margin-bottom: 10px;">
    <div class="recent-post">
        <table>
            <tbody>
                @foreach ($post as $key => $data)
                    <tr class="overflow">
                        <td class="si-pic">
                            <a href="{{ URL::to('/blog/' . $data->id . '/detail') }}"><img style="width: 90px;max-width:100%;
                      height: 74px;padding-right:10px;" src="{{ URL::to('uploads/posts/' . $data->images) }}"
                                    alt=""></a>

                        <td class="si-text">
                            <div class="product-selected">
                                <a href="{{ URL::to('/blog/' . $data->id . '/detail') }}">
                                    <h5><b style="
                                        width:166px;
                                        white-space: pre-wrap; 
                                        overflow: hidden;
                                        text-overflow: ellipsis;
                                        -webkit-line-clamp: 1;
                                        -webkit-box-orient: vertical;
                                         display: -webkit-box;
                                         ">{{ $data->title }}</b></h5>
                                </a>
                                <a href="{{ URL::to('/blog/' . $data->id . '/detail') }}">
                                    <h6 style="color:#e7ab3c"> {{ $data->categorypost->name }}</h6>
                                </a>
                                <i style="font-size: 14px;">_{{ $data->created_at->format('d/m/Y') }}_</i>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
