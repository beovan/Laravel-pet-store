@extends('admin.main')

@section('content')
    <div class="customer mt-3">
        <ul>

            <li>Tên khách hàng: <strong>{{ $customer->name }}</strong></li>
            <li>Số điện thoại: <strong>{{ $customer->phone }}</strong></li>
            <li>Địa chỉ: <strong>{{ $customer->address }}</strong></li>
            <li>Email: <strong>{{ $customer->email }}</strong></li>
            <li>Ghi chú: <strong>{{ $customer->content }}</strong></li>
            <li>Trạng thái đơn hàng: <strong> <a href="#">
                        @if ($order->status === 'cancelled')
                            <p> Đơn hàng đã bị huỷ</p>
                        @elseif($order->status === 'processing')
                            <p> Đang vận chuyển</p>
                        @elseif($order->status === 'delivered')
                            <p> Đã được giao hàng</p>
                        @elseif ($order->status === 'pending')
                            <p> Chờ xác nhận đơn hàng</p>
                        @else
                            <p>Unknown</p>
                        @endif

                    </a></strong></li>

        </ul>

    </div>

    <div class="carts">
        @php $total = 0; @endphp
        <table class="table">
            <tbody>
                <tr class="table_head">
                    <th class="column-1">IMG</th>
                    <th class="column-2">Product</th>
                    <th class="column-3">Price</th>
                    <th class="column-4">Quantity</th>
                    <th class="column-5">Total</th>
                </tr>
                @foreach ($orderItems as $orderItem)
                    @php
                        $price = $orderItem->price * $orderItem->quantity;
                        $total += $price;
                    @endphp
                    <tr>
                        <td class="column-1">
                            <div class="how-itemcart1">
                                <img src="{{ $orderItem->product->thumb }}" alt="IMG" style="width: 100px">
                            </div>
                        </td>
                        <td class="column-2">{{ $orderItem->product->name }}</td>
                        <td class="column-3">{{ number_format($orderItem->price, 0, '', '.') }}</td>
                        <td class="column-4">{{ $orderItem->quantity }}</td>
                        <td class="column-5">{{ number_format($price, 0, '', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right">Tổng Tiền</td>
                    <td>{{ number_format($order->total_amount, 0, '', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="card-footer clearfix">
            <div class="row">
                <div class="col-md-6 text-lefts">
                    {!! $orderItems->links() !!}
                </div>
                <div class="col-md-6 text-right">
                    <div class="row">
                        @if (Auth::user()->level == 0)
                            <form action="{{ route('update', ['order' => $order->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control">
                                    <option value="cancelled">Huỷ đơn hàng</option>
                                    <option value="processing">Tiến hành giao hàng</option>
                                    @if ($order->status == 'processing')
                                        <option value="delivered">Đã giao hàng</option>
                                    @endif
                                </select>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
