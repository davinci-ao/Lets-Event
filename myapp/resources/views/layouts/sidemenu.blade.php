

<section id='sidebar'>

	<a href="{{url('/shoppingcart/')  }}" ><button>View Shopping Cart</button></a>
	<a href="{{url('/order/index')  }}"> <button>view  orders</button></a>

	<h2>Categories</h2>
	<a href="{{url('/home/')  }}" ><button>Home</button></a>
	@foreach($categories  as $category)
	<a href="{{ url('/home/' .  $category->category_id) }}"><button>{{$category->category_name}}</button></a>
	@endforeach
</section>
