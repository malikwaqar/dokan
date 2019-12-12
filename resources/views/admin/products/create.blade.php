@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('admin.product.index')}}">Products</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Product</li>
@endsection
@section('content')
    <h2>Products</h2>
@endsection