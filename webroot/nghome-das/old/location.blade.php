@extends('layouts.app')
@section('content')

   <div class="container-fluid">
<div class="row bg-title">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <h4 class="page-title page_description">{{ trans('app.Location Type')}}</h4>
		  
		  <?php $userid = Auth::user()->id;
		if(getActivestatus('location',$userid)=='yes'){ ?>
		  
		  <button  value="" alt="default" data-toggle="modal"  data-target="#responsive-modal" class="model_img img-responsive btn button_of_add  btn-info btn-rounded" > {{ trans('app.Add new')}}</button>     
		<?php } ?>
        </div>
    </div>
	@if(session('message'))
				<div class="row massage">
			 <div class="col-sm-12">
				<div class="checkbox checkbox-success checkbox-circle">
                  <input id="checkbox-10" type="checkbox" checked="">
                  <label for="checkbox-10 colo_success">  {{session('message')}} </label>
                </div>
				</div>
				</div>
 
 
@endif
      <!-- /row -->
      <div class="row admin_users">
	  
        <div class="col-sm-12">
          <div class="white-box">
		  <?php $userid = Auth::user()->id;
		if(getActivestatus('location',$userid)=='yes'){ ?>
		  
		   <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="{!! url('location') !!}"><span class="visible-xs"><i class="ti-info-alt"></i></span> <span class="hidden-xs">{{ trans('app.Location List')}}</span></a></li>
			
            </ul>
			
			
            <div class="table-responsive table_margin_content">
            <table id="myTable" class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
				<th>{{ trans('app.Location Name')}}</th>
				<th>{{ trans('app.Action')}}</th>
                </tr>
              </thead>
              <tbody>
								<?php $i=1; ?>
                               @foreach($tbl_locations as $tbl_location)
								  <tr>
									<td>{{ $i }}</td>
									<td>{{$tbl_location->locname}}</td>
								   <td class="min_width">
								  <a href="{{ url('location/edit/'.$tbl_location->id)}}"><button class="btn  btn-info btn-rounded" alt="default"   value="Edit">{{ trans('app.Edit')}}</button></a>
								  <a url="location/destroy/{{$tbl_location->id}}" class="sa-warning"><button class="btn  btn-danger btn-rounded" value="Delete">{{ trans('app.Delete')}}</button></a>
								  </td>
									
								  </tr>
								   <?php $i++; ?>
                                @endforeach
							  
								</tbody>
            </table>
            </div>
			
		<?php }else{ ?>
		{{ trans('app.You Are Not authorize This page.')}}
		<?php }?>
          </div>
        </div>
        </div>
      <!-- /.row -->
     <div class="col-md-4">
        <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">{{ trans('app.Add Location')}}</h4>
                  </div>
                  <div class="modal-body">
                   <form class="form-horizontal" action="add_location" method="post">
						
                      <div class="form-group data_popup">
									<label>{{ trans('app.Location Name')}} : <span class="text-danger">*</span></label>
								
								  <input type="text" class="form-control" name="location_name" placeholder="{{ trans('app.Enter Location Name')}}" required>
								  <input type="hidden" name="_token" value="{{csrf_token()}}">
								  </div>
								  </div>
								  <div class="modal-footer padding_dec">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">{{ trans('app.Close')}}</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">{{ trans('app.Submit')}}</button>
                  </div>
                    </form>
                  
                  
                </div>
              </div>
            </div>
            
        </div>
		
		
    </div>
   
 













<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')}}"></script>
<!--slimscroll JavaScript -->


<script>

    $(document).ready(function(){
      $('#myTable').DataTable();
      $(document).ready(function() {
        var table = $('#example').DataTable({
			"columnDefs": [
          { "visible": false, "targets": 2 }
          ],
          "order": [[ 2, 'asc' ]],
          "displayLength": 25,
          "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
              if ( last !== group ) {
                $(rows).eq( i ).before(
                  '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                  );

                last = group;
              }
            } );
          }
        } );

    // Order by the grouping
    $('#example tbody').on( 'click', 'tr.group', function () {
      var currentOrder = table.order()[0];
      if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
        table.order( [ 2, 'desc' ] ).draw();
      }
      else {
        table.order( [ 2, 'asc' ] ).draw();
      }
    });
  });
  
  
  
    });
   $('.sa-warning').click(function(){
	  var url =$(this).attr('url');
	  
	  
        swal({   
            title: "Are You Sure?",
			text: "You will not be able to recover this data afterwards!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#297FCA",   
            confirmButtonText: "Yes, delete!",   
            closeOnConfirm: false 
        }, function(){
			window.location.href = url;
             
        });
    }); 
  </script>
<!--Style Switcher -->

@endsection
