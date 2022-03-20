<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	

    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/prettify.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/lightslider.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/lightgallery.min.css')}}" rel="stylesheet">
	<!------------SEO----------->
    <meta name="description" content="{{$meta_desc}}">
	<meta name="keywords" content="{{$meta_keywords}}"/>
	<meta name="robots" content="INDEX,FOLLOW"/>
    <meta name="author" content="">
	<link rel="canonical" href="{{$url_canonical}}"/>
	<link  rel="icon" type="image/x-icon" href="#" />
	<!------------/SEO---------->
	<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
	<title>{{$meta_title}}</title>
    <link rel="shortcut icon" href="{{('public/frontend/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> 036 2269 453</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
							
								<li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
								<?php
									$customer_id=Session::get('customer_id');
									$shipping_id=Session::get('shipping_id');
									if($customer_id!=NULL && $shipping_id==NULL){
								?>
									<li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
									}elseif($customer_id!=NULL && $shipping_id!=NULL){
										?>
										<li><a href="{{URL::to('/payment')}}"><i class="fa fa-lock"></i> Thanh toán</a></li>
										<?php
									}else{
										?>
										<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Thanh toán</a></li>
										<?php
									}	
								?>
								<li><a href="{{URL::to('/show-cart')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
								<?php
									$customer_id=Session::get('customer_id');
									if($customer_id!=NULL){
								?>
									<li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a></li>
								<?php
									}else{
										?>
										<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
										<?php
									}	
									?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{URL::to('/trang-chu')}}" class="active">Trang chủ</a></li>
								<li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
										@foreach($category as $key =>$danhmuc)
                                        <li><a href="{{URL::to('/danh-muc-san-pham/'.$danhmuc->category_id)}}">{{$danhmuc->category_name}}</a></li>
									@endforeach
									</ul>
                                </li> 
								<li class="dropdown"><a href="#">Bài viết<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										@foreach($cate_post as $key =>$baiviet)
                                        <li><a href="{{URL::to('/danh-muc-bai-viet/'.$baiviet->cate_post_slug)}}">{{$baiviet->cate_post_name}}</a></li>
										@endforeach
									</ul>
                                </li> 
								<li><a href="{{URL::to('/show-cart')}}">Giỏ hàng</a></li>
								<!-- <li><a href="contact-us.html">Liên hệ</a></li> -->
								<li class="dropdown"><a href="#">Liên hệ<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="#">Facebook</a></li>
                                    </ul>
                                </li> 
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
						<form action="{{URL::to('/tim-kiem')}}" method="POST">
						{{csrf_field()}}
						<div class="search_box pull-right">
							<input type="text" name="keywords_submit" placeholder="Tìm kiếm"/>
							<input type="submit" style="margin-top:0;color:#666" name="search_items" class="btn btn-primary btn-sm" value="Tìm kiếm"/>
							
						</div>
						</form>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-5">
									<h1><span>SHOPLARAVEL</span></h1>
									<h2>Đáp ứng thiết kế 100%</h2>
									<p>Siêu SALE thương hiệu - Miễn phí vận chuyển. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-7">
									<!-- <img src="{{('public/frontend/images/slide1.PNG')}}" class="girl img-responsive" alt="" /> -->
									<img src="{{URL::asset('public/frontend/images/slide1.PNG')}}" class="girl img-responsive" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-5">
									<h1><span>SHOPLARAVEL</span></h1>
									<h2>Đáp ứng thiết kế 100%</h2>
									<p>Siêu SALE thương hiệu - Miễn phí vận chuyển. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-7">
									<!-- <img src="{{('public/frontend/images/slide2.PNG')}}" class="girl img-responsive" alt="" /> -->
									<img src="{{URL::asset('public/frontend/images/slide2.PNG')}}" class="girl img-responsive" alt="" />
									
								</div>
							</div>
							
							<div class="item">
								<div class="col-sm-5">
									<h1><span>SHOPLARAVEL</span></h1>
									<h2>Đáp ứng thiết kế 100%</h2>
									<p>Siêu SALE thương hiệu - Miễn phí vận chuyển. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-7">
									<!-- <img src="{{('public/frontend/images/slide3.PNG')}}" class="girl img-responsive" alt="" /> -->
									<img src="{{URL::asset('public/frontend/images/slide3.PNG')}}" class="girl img-responsive" alt="" />
								</div>
							</div>
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh mục sản phẩm</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							@foreach($category as $hay =>$cate)
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">{{$cate->category_name}}</a></h4>
								</div>
							</div>
							@endforeach
						</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Thương hiệu sản phẩm</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									@foreach($brand as $hay =>$brand)
									<li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}"> <span class="pull-right">(50)</span>{{$brand->brand_name}}</a></li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					@yield('content')
				</div>
			</div>
		</div>
	</section>
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>ShopLaravel</span></h2>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<!-- <img src="{{('public/frontend/images/footer.PNG')}}" alt="" /> -->
										<img src="{{URL::asset('public/frontend/images/footer.PNG')}}" alt="" />
									</div>
									
								</a>
								<p>Nhóm Hope - Web</p>
								<h2>04 Member</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
                                     <!-- <img src="{{('public/frontend/images/footer1.PNG')}}" alt="" /> -->
									 <img src="{{URL::asset('public/frontend/images/footer1.PNG')}}" alt="" />
									</div>
									
								</a>
								<p>Nhóm Hope - Web</p>
								<h2>04 Member</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<!-- <img src="{{('public/frontend/images/footer3.PNG')}}" alt="" /> -->
										<img src="{{URL::asset('public/frontend/images/footer3.PNG')}}" alt="" />
									</div>
									
								</a>
								<p>Nhóm Hope - Web</p>
								<h2>04 Member</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
                                        <!-- <img src="{{('public/frontend/images/footer4.PNG')}}" alt="" /> -->
										<img src="{{URL::asset('public/frontend/images/footer4.PNG')}}" alt="" />
									</div>
									
								</a>
								<p>Nhóm Hope - Web</p>
								<h2>04 Member</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">© 2021 ShopLaravel. Tất cả các quyền được bảo lưu</p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

  
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
	<script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
	<script src="{{asset('public/frontend/js/sweetalert.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/lightslider.js')}}"></script>
	<script src="{{asset('public/frontend/js/prettify.js')}}"></script>
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0" nonce="kkpBjOyV"></script>
	<!-- paypal -->
	<script src="https://www.paypalobjects.com/api/checkout.js"></script>
	<script>
		var usd = document.getElementById("vnd_to_usd").value;
		paypal.Button.render({
		// mô trường
		env: 'sandbox',
		client: {
		sandbox: 'AXNRFk0iXIwJ0NK1HAPmuf0R6ovPXq6D9t2mndS03d3zW0E43dpI5khkON74lI_2OR2-CeF6AGZWPOuM',
		production: 'demo_production_client_id'
		},
		//style nút button-paypal
		locale: 'en_US',
		style: {
		size: 'small',
		color: 'gold',
		shape: 'pill',
		},
		// Bật quy trình thanh toán Pay Now (tùy chọn)
		commit: true,
		// Thiết lập một khoản thanh toán
		payment: function(data, actions) {
		return actions.payment.create({
			transactions: [{
			amount: {
				total: `${usd}`,
				currency: 'USD'
			}
			}]
		});
		},
		// Thực hiện thanh toán
		onAuthorize: function(data, actions) {
		return actions.payment.execute().then(function() {
			// Hiển thị thông báo xác nhận cho người mua
			window.alert('Cảm ơn bạn đã sử dụng sản phẩm bên shop!');
		});
		}
	}, '#paypal-button');

</script>


	<script type ="text/javascript">
		$(document).ready(function() {
			$('#imageGallery').lightSlider({
				gallery:true,
				item:1,
				loop:true,
				thumbItem:3,
				slideMargin:0,
				enableDrag: false,
				currentPagerPosition:'left',
				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#imageGallery .lslide'
					});
				}   
			});  
		});
	</script>
	<script type ="text/javascript">
		$(document).ready(function(){	
			$('.send_order').click(function(){	
				swal({
					title: "Xác nhậnđơn hàng",
					text: "Đơn hàng sẽ không hoàn trả khi đặt, bạn có muốn đặt không?",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Đặt hàng!",
					cancelButtonText: "Không, Cảm ơn!",
					closeOnConfirm: false,
					closeOnCancel: false
					},
					function(isConfirm) {
					if (isConfirm) {
						var shipping_name = $('.shipping_name').val();
						var shipping_email = $('.shipping_email').val();
						var shipping_phone = $('.shipping_phone').val();
						var shipping_address = $('.shipping_address').val();
						var order_coupon = $('.order_coupon').val();
						var shipping_notes = $('.shipping_notes').val();
						var shipping_method = $('.payment_select').val();
						var _token = $('input[name="_token"]').val();
						
						$.ajax({
							url: '{{url('/confirm-order')}}',
							method: 'POST',
							data:{shipping_name:shipping_name,shipping_email:shipping_email,
								shipping_phone:shipping_phone,shipping_address:shipping_address,
								shipping_notes:shipping_notes,shipping_method:shipping_method,
								order_coupon:order_coupon,_token:_token},
							success:function(){
								swal("Đơn hàng", "Đơn hàng của bạn đặt thành công", "success");
							}
						});
						//Sau khi đặt hàng reset trang checkout sau 3s
					window.setTimeout(function(){
						location.reload();
					} ,3000);
					} else {
						swal("Đóng", "Đơn hàng chưa được gửi :)", "error");
					}
				});
				
			});
		});
	</script>
	<script type ="text/javascript">
		$(document).ready(function(){
			$('.add-to-cart').click(function(){
				
				var id = $(this).data('id_product');
			
				var cart_product_id = $('.cart_product_id_' + id).val();
				var cart_product_name = $('.cart_product_name_' + id).val();
				//alert(cart_product_name);
				var cart_product_image = $('.cart_product_image_' + id).val();
				var cart_product_price = $('.cart_product_price_' + id).val();
				var cart_product_qty = $('.cart_product_qty_' + id).val();
				var _token = $('input[name="_token"]').val();
				$.ajax({
					url: '{{url('/add-cart-ajax')}}',
					method: 'POST',
					data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,
					cart_product_image:cart_product_image,cart_product_price:cart_product_price,
					cart_product_qty:cart_product_qty,_token:_token},
					success:function(){
						swal({
                                title: "Đã thêm sản phẩm vào giỏ hàng",
                                text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                showCancelButton: true,
                                cancelButtonText: "Xem tiếp",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Đi đến giỏ hàng",
                                closeOnConfirm: false
                            },
                            function() {
                                window.location.href = "{{url('/gio-hang')}}";				
						});
					}
				});
			});
		});
	</script>
	<script type ="text/javascript">
		$(document).ready(function(){
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
					url: '{{url('/select-delivery-home')}}',
					method: 'POST',
					data:{action:action,ma_id:ma_id,_token:_token},
					success:function(data){
						$('#'+result).html(data);
					}
				});
			});
		});
	</script>
</body>
</html>