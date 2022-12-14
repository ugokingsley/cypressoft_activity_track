<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <!--


<br />
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                </div>
            </div>
            <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="phed_stamp_duty">
           <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Item</th>
                <th>Value</th>
                            <th>Date</th>
            </tr>
           </thead>
       </table>
   </div>
  </div>

  <script>
$(document).ready(function(){
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
 });

 load_data();

 function load_data(from_date = '', to_date = '')
 {
  $('#phed_stamp_duty').DataTable({
   processing: true,
   serverSide: true,
   ajax: {
    url:'{{ route("dashboard") }}',
    data:{from_date:from_date, to_date:to_date}
   },
   columns: [
    {
     data:'customer_number',
     name:'customer_number'
    },
    {
     data:'meter_number',
     name:'meter_number'
    },
    {
     data:'receipt_number',
     name:'receipt_number'
    },
    {
     data:'account_type',
     name:'account_type'
    },
    {
     data:'amount',
     name:'amount'
    }
   ]
  });
 }

 $('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  if(from_date != '' &&  to_date != '')
  {
   $('#phed_stamp_duty').DataTable().destroy();
   load_data(from_date, to_date);
  }
  else
  {
   alert('Both Date is required');
  }
 });

 $('#refresh').click(function(){
  $('#from_date').val('');
  $('#to_date').val('');
  $('#phed_stamp_duty').DataTable().destroy();
  load_data();
 });

});
</script>
-->
</x-app-layout>
