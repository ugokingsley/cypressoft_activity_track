<div class="row justify-content-center my-5">
    <div class="col-md-12">
        <div class="card shadow bg-light">
            <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                <div class="mx-3 my-3">

                    <h3 class="h3 my-4">
                        Latest PHED Transactions
                    </h3>

                    <table class="table table-bordered mb-5">
                <thead>
                    <tr class="table-success">
                        <th scope="col">Customer Number</th>
                        <th scope="col">Meter Number</th>
                        <th scope="col">Receipt Number</th>
                        <th scope="col">Account Type</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latest_transactions as $data)
                    <tr>
                        <th scope="row">{{ $data->customer_number }}</th>
                        <td>{{ $data->meter_number }}</td>
                        <td>{{ $data->receipt_number }}</td>
                        <td>{{ $data->account_type }}</td>
                        <td>{{ $data->amount }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $latest_transactions->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
