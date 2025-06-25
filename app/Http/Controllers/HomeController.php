<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Chef;
use App\Models\Food;
use App\Models\User;
use App\Models\Foodchef;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    public function index(){

        $data=Food::all();
        $data2=Chef::all();
        $user_i=Auth::id();
        $user_id=Auth::id();
        $count=cart::where('user_id',$user_id)->count();
   
        return view("home",compact("data","data2","count"));
    }
    //Funcion para redireccionar la vista del administrado a la de un usuario normal
    public function redirects(Request $request)
{
    $data = Food::all();
    $data2 = Foodchef::all();
    $usertype = Auth::user()->usertype;
    $tables = Table::all();
    $table = Table::all();

    $viewOption = $request->get('viewOption', 'area');

    if ($usertype == 'admin') {
        return view('admin.adminhome');
    } elseif ($usertype == 'chef') {
        
        return view('chef.chefhome', compact('data', 'data2',)); // Vista para chef
    } elseif ($usertype == 'mesero') {
        $user_id = Auth::id();
        $count = Cart::where('user_id', $user_id)->count();
        return view('mesero.meserohome', compact('data', 'data2', 'count','tables','viewOption','table')); // Vista para mesero
    }else {
        return redirect('/'); // Redirección para roles no reconocidos
    }
}
    public function addcart(Request $request,$id){
        if(Auth::id()){
            $user_id=Auth::id();
            $foodid=$id;
            $quantity=$request->quantity;

            $cart=new Cart;
            $cart->user_id=$user_id;
            $cart->food_id=$foodid;
            $cart->quantity=$quantity;
            $cart->save();
           
            return redirect()->back();
        }else{
            return redirect('/login');
        }
    }
    //Funcion para ver los productos del carrito
    public function showcart(Request $request, $id){
        $count=Cart::where('user_id',$id)->count();
        $data2=Cart::select('*')->where('user_id','=',$id)->get();

        $data=Cart::where('user_id',$id)->join('food','carts.food_id','=','food.id')->get();
        
        return view('showcart',compact('count','data','data2'));
    }

    //Funcion para eliminar el carrito
    public function remove($id){
        $data=Cart::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function orderconfirm(Request $request)
    {
        foreach($request->foodname as $key=>$foodname){

        }
        $data=new Order();
        $data->foodname=$foodname;
        $data->price=$request->price[$key];
        $data->quantity=$request->quantity[$key];
        $data->name=$request->name;
        $data->phone=$request->phone;
        $data->address=$request->address;
    
        $data->save();
        return redirect()->back();
        
    }
    public function updateStatus(Request $request)
{
    $table = Table::find($request->id);
    
    if ($table) {
        // Actualizar el estado de la mesa
        $table->status = $request->status;
        $table->save();

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Estado de la mesa actualizado correctamente.');
    }

    // Redirigir en caso de que no se haya encontrado la mesa
    return redirect()->back()->with('error', 'No se pudo encontrar la mesa.');
}
public function comidaview()
{
    // Obtén todos los alimentos
    $foods = Food::all();
    $user_id = Auth::id();
    $count = Cart::where('user_id', $user_id)->count();

    // Retorna la vista 'comidaview' con todas las comidas
    return view('comidaview', compact('foods', 'count'));
}

// Controlador actualizado

public function infocomida($id)
{
    // Obtén la comida específica por ID
    $food = Food::findOrFail($id);
    // Retorna la vista con los detalles de la comida
    return view('infocomida', compact('food'));
}


}
