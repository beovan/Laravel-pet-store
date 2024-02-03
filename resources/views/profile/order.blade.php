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
                    <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> {{ $order->created_at ? $order->created_at->format('H:i') : 'N/A' }}</span>
                        <h3 class="timeline-header"><a href="#">Thông tin đơn hàng</a></h3>
                        <div class="timeline-body">
                            <!-- Display order-related information here -->
                            <ul>
                                <li> Tên: {{ $order->customer->name }}</li>
                                <li> Trạng thái đơn hàng 
                                    <div class="timeline-footer">
                                        <a href="#" class="btn btn-primary btn-sm">
                                            @if ($order->status === 'cancelled')
                                                <p>Huỷ đơn hàng</p>
                                            @elseif($order->status === 'processing')
                                                <p>Bắt đầu giao hàng</p>
                                            @elseif($order->status === 'delivered')
                                                <p> Đã được giao hàng</p>
                                            @elseif ($order->status === 'pending')
                                                <p>Chờ xác nhận đơn hàng</p>
                                            @else
                                                <p>Unknown</p>
                                            @endif
                                        </a>
                                    </div>
                                </li>
                            </ul>
                            <!-- Add more order information here -->
                        </div>
                      
                    </div>
                </div>
            @endif
        @endforeach
        <div>
            <i class="fas fa-clock bg-gray">
                {{$orders->links()}}
            </i>
        </div>
    </div>
</div>
