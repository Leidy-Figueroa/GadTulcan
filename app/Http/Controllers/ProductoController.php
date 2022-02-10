<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Estado;
use App\Models\Marca;
use App\Models\Detalle;
use App\Models\Modelo;
use App\Models\User;
use App\Models\Incident;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductosExport;
Use Auth;

/**
 * Class ProductoController
 * @package App\Http\Controllers
 */
class ProductoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $serie = $request->get('serie');
        $producto = Producto::buscarpor($serie);
        return view('producto.index')->with('productos',$producto);
    }
    public function getProducto(Request $request) {
        $productos=Producto::all(['id', 'user_id', 'incidencia_id', 'imagen','serie','descripcion','estado_id','marca_id','modelo_id','detalle_id','departamento_id']);
        $marcas=Marca::all(['id','nombre']);
        $modelos=Modelo::all(['id','nombre']);
        $estados=Estado::all(['id','nombre']);
        $detalles=Detalle::all(['id','nombre']);
        $users=User::all(['id','name']);
        $incidents=Incident::all(['id','support_id','title']);
        $departamentos=Departamento::all(['id','nombre']);
      
        
        return view('producto.index')->with('productos',$productos)->with('marcas',$marcas)->with('modelos',$modelos)->with('estados',$estados)->with('detalles',$detalles)->with('users',$users)->with('incidents',$incidents)->with('departamentos',$departamentos);
    }

    public function getProductoCreate() {
        $productos=Producto::all(['id', 'user_id', 'incidencia_id', 'imagen','serie','descripcion','estado_id','marca_id','modelo_id','detalle_id','departamento_id']);
        $marcas=Marca::all(['id','nombre']);
        $modelos=Modelo::all(['id','nombre']);
        $estados=Estado::all(['id','nombre']);
        $detalles=Detalle::all(['id','nombre']);
        $users=User::all(['id','name']);
        $incidents=Incident::all(['id','support_id','title']);
        $departamentos=Departamento::all(['id','nombre']);
        
        return view('producto.create')->with('productos',$productos)->with('marcas',$marcas)->with('modelos',$modelos)->with('estados',$estados)->with('detalles',$detalles)->with('users',$users)->with('incidents',$incidents)->with('departamentos',$departamentos);
    }

     public function postProducto(Request $request, producto $productos) 
     {
     $data = $request->validate([
        'serie' => 'required|max:16|min:8|unique:productos',
        'marca'=>'required',
        'modelo'=>'required',
        'detalle'=>'required',
        'descripcion'=>'required',
        'estado'=>'required',
        'incidencia'=>'required',
        'imagen' => 'required',
        'departamento' => 'required'
    ],[
        'serie.required'=>'El número de serie es obligatorio',
        'serie.unique'=>'La serie ya esta en uso',
        'marca.required'=>'La marca es obligatoria',
        'modelo.required'=>'El modelo es obligatorio',
        'detalle.required'=>'El detalle es obligatorio',
        'descripcion.required'=>'El nombre es obligatorio',
        'estado.required'=>'El estado es obligatorio',
        'incidencia.required'=>'La incidencia es obligatoria',
        'departamento.required'=>'El departamento es obligatoria',
        'imagen.required' => 'Subir imagen del producto'
    ]
    );
        $ruta_imagen = $request['imagen']->store('imagenes','public');
        $url = Storage::url($ruta_imagen);

        DB::table('productos')->insert([
            'fecha_ingreso'=>date('Y-m-d H:i:s'),
            'serie'=>$data['serie'],
            'descripcion'=>$data['descripcion'],
            'user_id'=>Auth::user()->id,
            'estado_id'=>$data['estado'],
            'modelo_id'=>$data['modelo'],
            'marca_id'=>$data['marca'],
            "detalle_id"=>$data['detalle'],
            "incidencia_id"=>$data['incidencia'],
            "departamento_id"=>$data['departamento'],
            "imagen"=>$ruta_imagen
            
        ]);
    
        return back()->with('notification', 'Producto registrado existosamente.');
}
public function postProductoCreate(Request $request, producto $productos) 
{
$data = $request->validate([
   'serie' => 'required|max:16|min:8|unique:productos',
   'marca'=>'required',
   'modelo'=>'required',
   'detalle'=>'required',
   'descripcion'=>'required',
   'estado'=>'required',
   'incidencia'=>'required',
   'imagen' => 'required',
   'departamento' => 'required'
],[
   'serie.required'=>'El número de serie es obligatorio',
   'serie.unique'=>'La serie ya esta en uso',
   'marca.required'=>'La marca es obligatoria',
   'modelo.required'=>'El modelo es obligatorio',
   'detalle.required'=>'El detalle es obligatorio',
   'descripcion.required'=>'El nombre es obligatorio',
   'estado.required'=>'El estado es obligatorio',
   'incidencia.required'=>'La incidencia es obligatoria',
   'departamento.required'=>'El departamento es obligatoria',
   'imagen.required' => 'Subir imagen del producto'
]
);
   $ruta_imagen = $request['imagen']->store('imagenes','public');
   $url = Storage::url($ruta_imagen);

   DB::table('productos')->insert([
       'fecha_ingreso'=>date('Y-m-d H:i:s'),
       'serie'=>$data['serie'],
       'descripcion'=>$data['descripcion'],
       'user_id'=>Auth::user()->id,
       'estado_id'=>$data['estado'],
       'modelo_id'=>$data['modelo'],
       'marca_id'=>$data['marca'],
       "detalle_id"=>$data['detalle'],
       "incidencia_id"=>$data['incidencia'],
       "departamento_id"=>$data['departamento'],
       "imagen"=>$ruta_imagen
   ]);
   return back()->with('notification', 'Producto registrado existosamente.');
  
}
public function show($id)
{
    $producto = Producto::find($id);
    return view('producto.show', compact('producto'));
}
/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */

public function edit($id, Request $request)
{
        $producto = Producto::findOrFail($id);
        $marcas=Marca::all(['id','nombre']);
        $modelos=Modelo::all(['id','nombre']);
        $estados=Estado::all(['id','nombre']);
        $detalles=Detalle::all(['id','nombre']);
        $incidents=incident::all(['id','support_id','title']);
        $users=user::all(['id','name']);
        $departamentos=Departamento::all(['id','nombre']);
        return view('producto.edit')->with(compact('producto', 'marcas','modelos','estados','detalles', 'incidents','users', 'departamentos'));
}

    public function update($id, Request $request)
    {
        $data = $request->validate([
           'serie' => 'required',
           'marca'=>'required',
           'modelo'=>'required',
           'detalle'=>'required',
           'descripcion'=>'required',
           'estado'=>'required',
           'incidencia'=>'required',
           'imagen' => 'required',
           'departamento' => 'required'
       ],[
           'serie.required'=>'El número de serie es obligatorio',
           'serie.unique'=>'La serie ya esta en uso',
           'marca.required'=>'La marca es obligatoria',
           'modelo.required'=>'El modelo es obligatorio',
           'detalle.required'=>'El detalle es obligatorio',
           'descripcion.required'=>'El nombre es obligatorio',
           'estado.required'=>'El estado es obligatorio',
           'incidencia.required'=>'La incidencia es obligatoria',
           'imagen.required' => 'Subir imagen del producto es obligatoria',
           'departamento.required' => 'El departamento es obligatorio',  
       ]
       );
    	$producto = Producto::find($id);
        $producto->descripcion = $request->input('descripcion');
    	$producto->serie = $request->input('serie');
        $producto->user_id = $request->input('user_id');
        $producto->marca_id = $request->input('marca');
        $producto->estado_id = $request->input('estado');
        $producto->modelo_id = $request->input('modelo');
        $producto->detalle_id = $request->input('detalle');
        $producto->incidencia_id = $request->input('incidencia');
        $producto->departamento_id = $request->input('departamento');
        $productos = $request['imagen']->store('imagenes','public');
        $producto->imagen = $productos;
    	$producto->save();
        
    	return back()->with('notification', 'Producto modificado exitosamente.');
    }

    public function delete($id)
    {
        Producto::find($id)->delete();

        return back()->with('notification', 'El producto se ha deshabilitado correctamente.');
    }
    public function restore($id)
    {
        Producto::withTrashed()->find($id)->restore();

        return back()->with('notification', 'El producto se ha habilitado correctamente.');
    }
public function imprimir(){
    $productos = Producto::get();
    $pdf = \PDF::loadView('producto.pdf', compact('productos'));
    return $pdf->download('ReporteGeneral.pdf');
}
public function exportExcel(){
    return Excel::download(new ProductosExport, 'productos.xlsx');
}
}