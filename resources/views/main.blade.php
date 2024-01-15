<!DOCTYPE html>
<html lang="en">
<head>
    @include('head')
</head>

<body > <!--class="animsition" -->

<!-- Header -->
@include('header')
<!-- Cart -->
{{-- Remember to 
     $products = $this->cartService->getProduct();
    rerun in view 
     'products' => $products,
    --}}
@include('cart')
{{-- @dd('hello') --}}

@yield('content')

@include('footer')

</body>
</html>
