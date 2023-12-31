<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Helpers\SidebarHelper;
use App\Helpers\TableHelper;

use App\Models\Material;
use App\Models\SalesPayment;
use App\Models\SalesOrder;
use App\Models\CustomerOrder;
use App\Models\Catalog;


class SalesPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function configDB_new(){
        return New SalesPayment;
    }

    public function configDB_all(){
        $curr_user = Auth::user()->id;
        return SalesPayment::where('user_id','=',$curr_user)->get();
    }

    public function configDB_find($id){
        return SalesPayment::find($id);
    }

    public function configDB_sales_order_all($id){
        return SalesOrder::where('user_id','=',$id)->get();
    }

    public function configDB_sales_order(){
        return SalesOrder::all();
    }

    public function index()
    {
        $menu = SidebarHelper::list(Auth::user()->role_id);
        
        return view(
            'seller.dashboard',
            ['menu'=>$menu]
        );
    }

    public function material_page()
    {        
        // Menu
        $menu = SidebarHelper::list(Auth::user()->role_id);

        $db_all = $this->configDB_all();
        $db_new = $this->configDB_new();
        $curr_user = Auth::user()->id;
        $db_sales_order_all = $this->configDB_sales_order_all($curr_user);        

        // Datatable
        $tableConfig = [
            'field_block' => [
                '',
                'id',
                'user_id',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            'field_rename'=>[
                '',
                'id' => 'No',
                'no_production' => 'No Production'
            ],
            'content' => $db_all,
            'action' => [
                'detail' => [
                    'name' => 'Detail',
                    'modal' => '#ModalDetail',
                    'route' => '/seller/detail-sales-payment',
                    'class' => 'btn btn-secondary text-white btn-sm',
                    'icon' => '',
                ],
                'add' => [
                    'name' => 'Add Data',
                    'modal' => '#ModalAdd',
                    'route' => '/seller/add-sales-payment',
                    'class' => 'btn btn-primary text-white btn-md mb-3',
                    'icon' => '',
                ],
                'edit' => [
                    'name' => 'Edit',
                    'modal' => '#ModalEdit',
                    'route' => '/seller/edit-sales-payment',
                    'class' => 'btn btn-warning text-white btn-sm',
                    'icon' => '',
                ],
                'delete' => [
                    'name' => 'Delete',
                    'modal' => '#ModalDelete',
                    'route' => '/seller/delete-sales-payment',
                    'class' => 'btn btn-danger text-white btn-sm',
                    'icon' => '',
                ],
            ],
            'form-add' => [
                'sales_order_id' => [
                    'name' => 'sales_order_id',
                    'title' => 'sales_order_id',
                    'tag' => 'option',
                    'type' => 'option',
                    'placeholder' => 'sales_order_id',
                    'option-config' => [
                        'option-title' => 'no_sale_invoice',
                        'option-reference' => 'id',
                        'option-content' => $db_sales_order_all,
                    ]
                ],
                'payer_name' => [
                    'name' => 'payer_name',
                    'title' => 'payer_name',
                    'tag' => 'input',
                    'type' => 'text',
                    'placeholder' => 'payer_name'
                ],
                'nominal' => [
                    'name' => 'nominal',
                    'title' => 'nominal',
                    'tag' => 'input',
                    'type' => 'number',
                    'placeholder' => 'nominal'
                ],
                'payment_date' => [
                    'name' => 'payment_date',
                    'title' => 'payment_date',
                    'tag' => 'date',
                    'type' => 'date',
                    'placeholder' => 'payment_date'
                ],
                'status' => [
                    'name' => 'status',
                    'title' => 'Status Data',
                    'tag' => 'option',
                    'type' => 'option',
                    'option-config' => [
                        'option-title' => 'title',
                        'option-reference' => 'id',
                        'option-content' => [
                            [
                                'id' => '1',
                                'name' => 'active',
                                'value' => 'active',
                                'title' => 'Active'
                            ],
                            [
                                'id' => '2',
                                'name' => 'non_active',
                                'value' => 'npn_active',
                                'title' => 'Non Active'
                            ],
                        ],
                    ],
                ],
            ],
            'form-edit' => [
                'sales_order_id' => [
                    'name' => 'sales_order_id',
                    'title' => 'sales_order_id',
                    'tag' => 'option',
                    'type' => 'option',
                    'placeholder' => 'sales_order_id',
                    'option-config' => [
                        'option-title' => 'no_sale_invoice',
                        'option-reference' => 'id',
                        'option-content' => $db_sales_order_all,
                    ]
                ],
                'payer_name' => [
                    'name' => 'payer_name',
                    'title' => 'payer_name',
                    'tag' => 'input',
                    'type' => 'text',
                    'placeholder' => 'payer_name'
                ],
                'nominal' => [
                    'name' => 'nominal',
                    'title' => 'nominal',
                    'tag' => 'input',
                    'type' => 'number',
                    'placeholder' => 'nominal'
                ],
                'payment_date' => [
                    'name' => 'payment_date',
                    'title' => 'payment_date',
                    'tag' => 'date',
                    'type' => 'date',
                    'placeholder' => 'payment_date'
                ],
                'status' => [
                    'name' => 'status',
                    'title' => 'Status Data',
                    'tag' => 'option',
                    'type' => 'option',
                    'option-config' => [
                        'option-title' => 'title',
                        'option-reference' => 'id',
                        'option-content' => [
                            [
                                'id' => '1',
                                'name' => 'active',
                                'value' => 'active',
                                'title' => 'Active'
                            ],
                            [
                                'id' => '2',
                                'name' => 'non_active',
                                'value' => 'npn_active',
                                'title' => 'Non Active'
                            ],
                        ],
                    ],
                ],
            ],
            'form-detail' => [
                'sales_order_id' => [
                    'name' => 'sales_order_id',
                    'title' => 'sales_order_id',
                    'tag' => 'option',
                    'type' => 'option',
                    'placeholder' => 'sales_order_id',
                    'option-config' => [
                        'option-title' => 'no_sale_invoice',
                        'option-reference' => 'id',
                        'option-content' => $db_sales_order_all,
                    ]
                ],
                'payer_name' => [
                    'name' => 'payer_name',
                    'title' => 'payer_name',
                    'tag' => 'input',
                    'type' => 'text',
                    'placeholder' => 'payer_name'
                ],
                'nominal' => [
                    'name' => 'nominal',
                    'title' => 'nominal',
                    'tag' => 'input',
                    'type' => 'number',
                    'placeholder' => 'nominal'
                ],
                'payment_date' => [
                    'name' => 'payment_date',
                    'title' => 'payment_date',
                    'tag' => 'date',
                    'type' => 'date',
                    'placeholder' => 'payment_date'
                ],
                'status' => [
                    'name' => 'status',
                    'title' => 'Status Data',
                    'tag' => 'option',
                    'type' => 'option',
                    'option-config' => [
                        'option-title' => 'title',
                        'option-reference' => 'id',
                        'option-content' => [
                            [
                                'id' => '1',
                                'name' => 'active',
                                'value' => 'active',
                                'title' => 'Active'
                            ],
                            [
                                'id' => '2',
                                'name' => 'non_active',
                                'value' => 'npn_active',
                                'title' => 'Non Active'
                            ],
                        ],
                    ],
                ],
            ],
            
        ];

        $columTable = TableHelper::index($db_new, $tableConfig);

        return view(
            'seller.sales-payment',
            [
                'menu'=>$menu,
                'catalog'=>$db_all,
                'data_table'=>$columTable,
                'tableConfig'=>$tableConfig
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $curr_user = Auth::user()->id;
        $db_new = $this->configDB_new();

        foreach($request->request as $key => $data){
            if($key == '_token')continue;
            $db_new->$key = $data;            
        }
            $db_new->user_id = $curr_user;   
            
            $data = DB::table('sales_orders')
            ->select('sales_orders.*','customer_orders.*','catalogs.*')
            ->join('customer_orders', 'customer_orders.sales_order_id', '=', 'sales_orders.id')
            ->join('catalogs', 'customer_orders.catalog_id', '=', 'catalogs.id')
            ->where('sales_orders.id','=',$db_new->sales_order_id)
            ->get()[0];

            $catalog = Catalog::where('id','=',$data->catalog_id)->get()[0];
            $catalog->stock -= $data->quantity;
            $catalog->save();

            $sales_order = SalesOrder::where('id','=',$data->sales_order_id)->get()[0];
            $sales_order->status = 1;
            $sales_order->save();

            // dd($db_new);

        if($db_new->save()){
            return back()->with('success', 'Selamat Data dimasukan!');
        }else{
            return back()->with('failed', 'Selamat Data dimasukan!');
        }
        // dd($db_new);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $curr_user = Auth::user()->id;
        $db_find = $this->configDB_find($id);

        foreach($request->request as $key => $data){
            if($key == '_token')continue;
            $db_find->$key = $data;            
        }
            $db_find->user_id = $curr_user;   

        if($db_find->save()){
            return back()->with('success', 'Selamat Data dimasukan!');
        }else{
            return back()->with('failed', 'Selamat Data dimasukan!');

        }
        // dd($db_find);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $curr_user = Auth::user()->id;
        $db_find = $this->configDB_find($id);

        foreach($request->request as $key => $data){
            if($data == null )break;
            
            if($db_find->delete()){
                return back()->with('success', 'Selamat Data dimasukan!');
                break;
            }else{
                return back()->with('failed', 'Selamat Data dimasukan!');
                break;
            }
        }       
    }
}
