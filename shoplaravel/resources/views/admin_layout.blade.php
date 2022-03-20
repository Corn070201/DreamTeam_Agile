<!DOCTYPE html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<meta name="csrf-token" content="{{csrf_token()}}">
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 
<link rel="stylesheet" href="{{asset('public/backend/css/morris.css')}}" type="text/css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<!-- calendar -->
<link rel="stylesheet" href="{{asset('public/backend/css/monthly.css')}}">

<!-- //calendar -->
<!-- biểu đồ -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<!-- /biểu đồ -->
<!-- //font-awesome icons -->
<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
<script src="{{asset('public/backend/js/morris.js')}}"></script>

</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="index.html" class="logo">
        ADMIN
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{('public/backend/images/avt1.PNG')}}">
                <span class="username">
					<?php
						$name=Auth::user()->admin_name;
						if($name){
							echo $name;
						}
					?>
				</span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a href="{{URL::to('/logout-auth')}}"><i class="fa fa-key"></i> Đăng xuất</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/manage-order')}}">Quản lý đơn hàng</a></li>

                    </ul>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý mã giảm giá</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/insert-coupon')}}">Thêm mã giảm giá</a></li>
						<li><a href="{{URL::to('/list-coupon')}}">Liệt kê mã giảm giá</a></li>
                       
                    </ul>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Vận chuyển</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/delivery')}}">Quản lý vận chuyển</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-category-product')}}">Thêm danh mục sản phẩm</a></li>
						<li><a href="{{URL::to('/all-category-product')}}">Liệt kê danh mục sản phẩm</a></li>
                       
                    </ul>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Thương hiệu sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-brand-product')}}">Thêm thương hiệu sản phẩm</a></li>
						<li><a href="{{URL::to('/all-brand-product')}}">Liệt kê thương hiệu sản phẩm</a></li>
                       
                    </ul>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a></li>
						<li><a href="{{URL::to('/all-product')}}">Liệt kê sản phẩm</a></li>
                    </ul>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục bài viết</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-cate-post')}}">Thêm danh mục bài viết</a></li>
						<li><a href="{{URL::to('/all-cate-post')}}">Liệt kê danh mục bài viết</a></li>
                    </ul>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Bài viết</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-post')}}">Thêm bài viết</a></li>
						<li><a href="{{URL::to('/all-post')}}">Liệt kê bài viết</a></li>
                    </ul>
                </li>
				<!-- @ hasrole(['admin','user']) -->
				@hasrole('admin')
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-users')}}">Thêm Users</a></li>
						<li><a href="{{URL::to('/all-users')}}">Liệt kê Users</a></li>
                    </ul>
                </li>
				@endhasrole
            </ul>            
		</div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
        @yield('admin_content')
    </section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>...ShopLaravel...</p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>
<<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="{{asset('public/backend/ckeditor/jquery.form-validator.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		load_gallery();
		function load_gallery(){
			var pro_id = $('.pro_id').val();
			var _token = $('input[name="_token"]').val();
			// alert(pro_id);
			$.ajax({
				url:'{{url('/select-gallery')}}',
				method: 'POST',
				data: {pro_id:pro_id,_token:_token},
				success:function(data){
					$('#gallery_load').html(data);
				}
			});
		}
		$('#file_image').change(function(){
			var error = '';
			var files = $('#file_image')[0].files;
			if(files.length > 5){
				error+='<p>Bạn chỉ được chọn tối đa 5 ảnh</p>'
			}
			if(files.length == ''){
				error+='<p>Bạn không được bỏ trống trường này</p>'
			}
			if(files.size > 2000000){
				error+='<p>File ảnh không được lớn hơn 2MB</p>'
			}
			if(error ==''){

			}
			else{
				$('#file').val("");
				$('#error_gallery').html('<span class="text-danger">'+error+'</span>');
				return false;
			}
		});
		$(document).on('blur','.edit_gal_name',function(){
			var gal_id = $(this).data('gal_id');
			var gal_text = $(this).text();
			var _token = $('input[name="_token"]').val();
			$.ajax({
				url:'{{url('/update-gallery-name')}}',
				method: 'POST',
				data: {gal_id:gal_id,gal_text:gal_text,_token:_token},
				success:function(data){
					load_gallery();
					$('#error_gallery').html('<span class="text-danger">Cập nhật tên hình ảnh thành công</span>');

				}
			});
		});	
		$(document).on('click','.delete-gallery',function(){
			var gal_id = $(this).data('gal_id');
			var _token = $('input[name="_token"]').val();
			if(confirm('Bạn muốn xóa hình ảnh này không?')){
				$.ajax({
				url:'{{url('/delete-gallery')}}',
				method: 'POST',
				data: {gal_id:gal_id,_token:_token},
				success:function(data){
					load_gallery();
					$('#error_gallery').html('<span class="text-danger">Xóa hình ảnh thành công</span>');

				}
			});
			}
		});	
		$(document).on('change','.file_image',function(){
			var gal_id = $(this).data('gal_id');
			var image = document.getElementById('file-'+gal_id).files[0];
			var form_data = new FormData();
			form_data.append("file", document.getElementById('file-'+gal_id).files[0]);
			form_data.append("gal_id", gal_id);
		 	$.ajax({
				url:'{{url('/update-gallery')}}',
				method: 'POST',
				headers:{
					'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
				},
				data:form_data,
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					load_gallery();
					$('#error_gallery').html('<span class="text-danger">Cập nhật hình ảnh thành công</span>');
				}
			});	
		});
	});
</script>
<script type="text/javascript">
	$('.update_quantity_order').click(function(){
		var order_product_id = $(this).data('product_id');
		var order_qty = $('.order_qty_'+ order_product_id).val();
		var order_code = $('.order_code').val();
		var _token = $('input[name="_token"]').val();
		$.ajax({
			url: '{{url('/update-qty')}}',
			method: 'POST',
			data:{_token:_token,order_product_id:order_product_id,order_qty:order_qty,order_code:order_code},
			success:function(data){
				alert('Cập nhật số lượng thành công');
				location.reload();
			}
		});
	});
</script>
<script type="text/javascript">
	$('.order_details').change(function(){
		var order_status = $(this).val();
		var order_id = $(this).children(":selected").attr("id");
		var _token = $('input[name="_token"]').val();
		quantity = [];
		$("input[name='product_sales_quantit']").each(function(){
			quantity.push($(this).val());

		});
		order_product_id=[];
		$("input[name='order_product_id']").each(function(){
			order_product_id.push($(this).val());

		});
		j=0;
		for(i=0; i<order_product_id.length; i++){
			//số lượng khách đặt
			var order_qty = $('.order_qty_'+ order_product_id[i]).val();
			//số lượng tồn kho
			var order_qty_storage = $('.order_qty_storage_'+ order_product_id[i]).val();
			//parseInt - chuyển về kiểu int
			if(parseInt(order_qty)>parseInt(order_qty_storage)){
				j=j+1;
				if(j==1){
					alert('Số lượng bán trong kho không đủ');
				}
				$('.color_qty_' + order_product_id[i]).css('background','#FFD700');
			}
		}
		if(j==0){
				$.ajax({
					url: '{{url('/update-order-qty')}}',
					method: 'POST',
					data:{_token:_token,order_status:order_status,order_id:order_id,quantity:quantity,order_product_id:order_product_id},
					success:function(data){
						alert('Thay đổi tình trạng đơn hàng thành công');
						location.reload();
					}
				});
		}
		
	});
</script>
<!-- biểu đồ thống kê sản phẩm,.. -->
<script type="text/javascript" >
	$(document).ready(function() {
		var colorDanger = "#FF1744";
		//var donut =
		Morris.Donut({
		element: 'donut',
		resize: true,
		colors: [
			'#ce616a',
			'#006400',
			'#f5b942',
			'#4842f5'
		],
		//labelColor:"#cccccc", // text color
		//backgroundColor: '#333333', // border color
		data: [
			{label:"Sản phẩm", value:<?php echo $app_product ?>, color:colorDanger},
			{label:"Bài viết", value:<?php echo $app_post ?>},
			{label:"Đơn hàng", value:<?php echo $app_order ?>},
			{label:"Khách hàng", value:<?php echo $app_customer?>},
			//{label:"Dato Ej.5", value:357}
		]
		});	
	});
</script>
<!-- biểu đồ Thống kê doanh số -->
<script type="text/javascript" >
	$(document).ready(function() {
		
		var chart=new Morris.Bar({
		element: 'chart',
		lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766B56'],
		hideHover: 'auto',
		parseTime: false,
		xkey: 'period',
		ykeys: ['order','sales','profit','quantity'],
		labels: ['Đơn hàng','Doanh số','Lợi nhuận','Số lượng']
	});
		
		$('#btn-dashboard-filter').click(function(){
			var _token = $('input[name="_token"]').val();
			var from_date = $('#datepicker').val();
			var to_date = $('#datepicker2').val();
			$.ajax({
				url:'{{url('/filter-by-date')}}',
				method:"POST",
				dataType:"JSON",
				data:{from_date:from_date,to_date:to_date,_token:_token},
				success:function(data){
					chart.setData(data);
				}
			});
		});
	});
</script>
<!-- Vận chuyển -->
<script type="text/javascript">
	$(document).ready(function(){
		fetch_deliery();
		function fetch_deliery(){
			var _token = $('input[name="_token"]').val();
			$.ajax({
				url: '{{url('/select-feeship')}}',
				method: 'POST',
				data:{_token:_token},
				success:function(data){
					$('#load_delivery').html(data);
				}
			});
		}
		$(document).on('blur','.fee_feeship_edit',function(){
			var feeship_id = $(this).data('feeship_id');
			var fee_value = $(this).text();
			var _token = $('input[name="_token"]').val();
			// alert(feeship_id);
			// alert(fee_value);
			$.ajax({
				url: '{{url('/update-delivery')}}',
				method: 'POST',
				data:{_token:_token,feeship_id:feeship_id,fee_value:fee_value},
				success:function(data){
					fetch_deliery();
				}
			});
		});
		$('.add_delivery').click(function(){
			var city =$('.city').val();
			var province =$('.province').val();
			var wards =$('.wards').val();
			var fee_ship =$('.fee_ship').val();
			var _token = $('input[name="_token"]').val();
			// alert(city);
			// alert(province);
			// alert(wards);
			// alert(fee_ship);
			$.ajax({
				url: '{{url('/insert-delivery')}}',
				method: 'POST',
				data:{city:city,_token:_token,wards:wards,province:province,fee_ship:fee_ship},
				success:function(data){
					fetch_deliery();
				}
			});

		})
		$('.choose').on('change',function(){
			var action = $(this).attr('id');
			var ma_id = $(this).val();
			var _token = $('input[name="_token"]').val();
			var result = '';
			if(action == 'city'){
				result = 'province';
			}else{
				result = 'wards';
			}
			$.ajax({
				url: '{{url('/select-delivery')}}',
				method: 'POST',
				data:{action:action,ma_id:ma_id,_token:_token},
				success:function(data){
					$('#'+result).html(data);
				}
			});
		});
	})
</script>
<script type="text/javascript">
	$.validate({

	});
</script>
<script type="text/javascript">
	CKEDITOR.replace('ckeditor');
	CKEDITOR.replace('ckeditor1');
	CKEDITOR.replace('ckeditor2');
	CKEDITOR.replace('ckeditor3');
	CKEDITOR.replace('ckeditor4');
	CKEDITOR.replace('ckeditor5');
	CKEDITOR.replace('ckeditor6');
	CKEDITOR.replace('ckeditor7');
	CKEDITOR.replace('ckeditor8');
	CKEDITOR.replace('ckeditor9');
	CKEDITOR.replace('ckeditor10');
	CKEDITOR.replace('ckeditor11');
	CKEDITOR.replace('ckeditor12');
	CKEDITOR.replace('ckeditor13');
	CKEDITOR.replace('ckeditor14');

</script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<!-- morris JavaScript -->	
<script type="text/javascript">
	$(function(){
		$("#datepicker").datepicker({
			prevText:"Tháng trước",
			nextText:"Tháng sau",
			dateFormat:"yy-mm-dd",
			dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4","Thứ 5","Thứ 6","Thứ 7","Chủ nhật"],
			duration: "slow"
		});
		$("#datepicker2").datepicker({
			prevText:"Tháng trước",
			nextText:"Tháng sau",
			dateFormat:"yy-mm-dd",
			dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4","Thứ 5","Thứ 6","Thứ 7","Chủ nhật"],
			duration: "slow"
		});
	});
</script>
<script type="text/javascript" >
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
	
	<!-- calendar -->
	<script type="text/javascript" src="{{asset('public/backend/js/monthly.js')}}"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->

</body>
</html>
