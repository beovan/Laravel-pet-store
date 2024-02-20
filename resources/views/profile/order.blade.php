<div class="tab-pane" id="order">
    <div class="timeline timeline-inverse">
        @foreach ($orders as $order)
            @if ($order->customer->user_id === $user_id)
                <div class="time-label">
                    <span class="bg-success">
                        {{ $order->order_date }}
                    </span>
                </div>

                <div>
                    <i class="fas fa-envelope bg-primary"></i>
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Thông tin đơn hàng</h3>
                            {{-- <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Mã số đơn hàng</th>
                                            <th>Họ và tên</th>
                                            <th>Trạng thái đơn hàng</th>
                                            <th>Tổng đơn hàng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a>{{ $order->order_number }}</a></td>
                                            <td><a>{{ $order->customer->name }}</a></td>
                                            <td>
                                                @if ($order->status === 'cancelled')
                                                    <span class="badge badge-danger">
                                                        <p>Huỷ đơn hàng</p>
                                                    </span>
                                                @elseif($order->status === 'processing')
                                                    <span class="badge badge-info">
                                                        <p>Bắt đầu giao hàng</p>
                                                    </span>
                                                @elseif($order->status === 'delivered')
                                                    <span class="badge badge-success">
                                                        <p>Đã được giao hàng</p>
                                                    </span>
                                                @elseif ($order->status === 'pending')
                                                    <span class="badge badge-warning">
                                                        <p>Chờ xác nhận đơn hàng</p>
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">
                                                        <p>Unknown</p>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                    {{ $order->total_amount }} VNĐ
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All
                                Orders</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
            @endif
        @endforeach
        <div>
            <i class="fas fa-clock bg-gray">
                {{ $orders->links() }}
            </i>
        </div>
    </div>
</div>
