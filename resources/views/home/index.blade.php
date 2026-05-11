@extends("layouts.main")

@section('content')

@include("layouts.category-navbar")
@include("layouts.carts")



<!-- TOAST -->
<div class="toast-wrap" id="tw"></div>


<!-- =============================================================== -->
<!-- PAGE: HOME -->
<!-- =============================================================== -->
<div class="pg on" id="pgHome">

  @include("home.partials.hero-slider")
  @include("home.partials.category-shortcut")
  @include("home.partials.promo")
  @include("home.partials.trust-bar")
  @include("home.partials.product-section")
  @include("home.partials.news-features")
  @include("home.partials.services-section")
  @include("home.partials.buy-segment-section")
  @include("home.partials.partner-section")


  @include("../layouts/footer")




</div><!-- /pgHome -->
@endsection