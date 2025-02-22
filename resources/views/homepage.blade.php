@extends('layout.navbar')
@section('title', 'Homepage')
@section('content')
    <h1>Homepage</h1>
    <br>
    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('fail'))
        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
    @endif
    @if ($products->count() > 0)
        <div class="container p-0">
            <div class="card px-4">

                <p class="h8 py-3">Product List</p>
                <div class="row gx-3">

                    <form action="" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <label>Filter by Status</label>
                                <select name="status" class="form-select">
                                    <option value="all" {{ Request::get('status') == 'all' ? 'selected' : '' }}>All
                                    </option>
                                    <option value="online" {{ Request::get('status') == 'online' ? 'selected' : '' }}>Online
                                    </option>
                                    <option value="bidding" {{ Request::get('status') == 'bidding' ? 'selected' : '' }}>
                                        Bidding</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <br />
                                <button type="submit" class="btn btn-primary btn-sm" style="width: 70px;">Filter</button>
                            </div>
                        </div>

                    </form>

                    <div class="container mt-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Starting Price</th>
                                    @if ($data->user_type == '1')
                                        <th>Selling Price</th>
                                    @else
                                        <th>Current Price</th>
                                    @endif
                                    <th>Buyout Price</th>
                                    <th colspan="3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr onclick="window.location.href='{{ url('view-product/' . $product->pid) }}';"
                                        style="background-color: #fff;" onmouseover="this.style.backgroundColor='#f0f0f0';"
                                        onmouseout="this.style.backgroundColor='#fff';">

                                        <td><img src="{{ asset('uploads/' . $product->image_path) }}" width=150px
                                                height=150px alt="Product Image" class="img-fluid"></td>
                                        <td>{{ $product->product_name }}</td>
                                        @php
                                            $bidding = \App\Models\Bidding::where([['pid', '=', $product->pid], ['uid', '=', $data->id]])->first();
                                        @endphp
                                        @if ($data->id == $product->bought_by && $product->status == 'bidding')
                                            <td><a class="btn btn-outline-success btn-sm">Winning</a></td>
                                        @elseif ($data->id == $product->bought_by && $product->status == 'carted')
                                            <td><a href="{{ route('cart', $product->pid) }}"
                                                    class="btn btn-outline-success btn-sm">Carted</a>
                                            </td>
                                        @elseif ($bidding && $product->status == 'bidding')
                                            <td><a href="{{ route('bid', $product->pid) }}"
                                                    class="btn btn-outline-danger btn-sm">Outbidded</a></td>
                                        @elseif ($bidding && $product->status == 'carted')
                                            <td><a href="{{ route('view-product', $product->pid) }}"
                                                    class="btn btn-outline-danger btn-sm">Carted</a></td>
                                        @else
                                            <td>{{ $product->status }}</td>
                                        @endif
                                        <td>{{ $product->start_price }}</td>
                                        <td>{{ $product->current_price }}</td>
                                        <td>{{ $product->buyout_price }}</td>
                                        @if ($data->user_type == '1')
                                            <td><a href="{{ url('edit-product/' . $product->pid) }}"
                                                    class="btn btn-primary btn-sm" style="width: 70px;">Edit</a></td>
                                            <td><a href="{{ url('delete-product/' . $product->pid) }}"
                                                    class="btn btn-danger btn-sm" style="width: 70px;">Delete</a></td>
                                            <td><a href="{{ url('sell-product/' . $product->pid) }}"
                                                    class="btn btn-success btn-sm" style="width: 70px;">Sell</a></td>
                                        @else
                                            <td><a href="{{ route('bid', $product->pid) }}" class="btn btn-success btn-sm"
                                                    style="width: 70px;">Bid</a>
                                            </td>
                                            <td><a href="{{ route('buyout-payment', $product->pid) }}"
                                                    class="btn btn-dark btn-sm" style="width: 70px;">Buyout</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection
