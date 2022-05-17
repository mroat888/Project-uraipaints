<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ApiController extends Controller
{
    public function apiToken(){
        // -----  API
        // dd(env("API_LINK"));
        $response = Http::post(env("API_LINK").'api/auth/login', [
            'username' => env("API_USER"),
            'password' => env("API_PASS"),
        ]);
        $res = $response->json();
        $api_token = $res['data'][0]['access_token'];

        return $api_token;
    }

    public function getAllSellers(){
        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers');
        $res_api = $response->json();
        return $res_api;
    }

    public function fetch_subgroups($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/subgroups/');
        $res_api = $response->json();
        $subgroups = array();
        foreach($res_api['data'] as $value){
            if($value['group_id'] == $id){
                $subgroups[] = [
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                    'group_id' => $value['group_id']
                ];
            }
        }
        return response()->json([
            'status' => 200,
            'id' => $id,
            'subgroups' => $subgroups
        ]);

    }

    public function fetch_pdglists($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists/');
        $res_api = $response->json();
        $pdglists = array();
        foreach($res_api['data'] as $value){
            if($value['sub_code'] == $id){
                $pdglists[] = [
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                    'sub_code' => $value['sub_code']
                ];
            }
        }
        return response()->json([
            'status' => 200,
            'id' => $id,
            'pdglists' => $pdglists
        ]);

    }

    public function fetch_amphur_api($path,$id){
        if($path != "admin"){
            $path_search = "/".$path."/".Auth::user()->api_identify."/amphures?province_id=".$id;
        }else{
            $path_search = "/provinces/".$id."/amphures/";
        }
        $api_token = $this->apiToken();
        //$response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces/'.$id.'/amphures/');   
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);   
        $res_api = $response->json();
        $amphures = array();
        foreach($res_api['data'] as $value){
            if($value['province_id'] == $id){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        // dd($amphures);

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_products($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/products?sort_by=product_code",[
            'productlist_id' => $id
        ]);

        $res_api = $response->json();
        if($res_api['code'] == 200){
            $products = array();
            foreach($res_api['data'] as $value){
                if($value['list_code'] == $id){
                    $products[] = [
                        'identify' => $value['identify'],
                        'name' => $value['name'],
                        'url_image' => $value['url_image'],
                        'pack_unit' => $value['pack_unit'],
                        'pack_ratio' => $value['pack_ratio'],
                    ];
                }
            }
        }

        return Datatables::of($products)
        ->addIndexColumn()
        ->editColumn('url_image',function($row){
            if($row['url_image'] != ""){
                $img = "<img src='".$row['url_image']."' style='width:100%'>";
            }else{
                $img = "";
            }
            return $img;
        })
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['name'];
        })
        ->make(true);

    }

    //-- สำหรับ Seller--
    public function fetch_provinces_products($id){

        $api_token = $this->apiToken();
        $path_search = "/sellers/".Auth::user()->api_identify."/pdglists/".$id."/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $provinces[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'region_id' => $value['region_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'provinces' => $provinces
        ]);
    }

    public function fetch_amphur_products($pdgid, $id){

        $api_token = $this->apiToken();
        $path_search = "/sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/amphures?province_id=".$id;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_datatable_customer_sellers($pdgid,$pvid,$ampid){
        $api_token = $this->apiToken();
        $path_search = "sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers?province_id=".$pvid."&amphoe_id=".$ampid;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_sellers_pdglist($pdgid){
        $api_token = $this->apiToken();
        $path_search = "sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);

    }

    public function fetch_datatable_customer_sellers_pdglist_pvid($pdgid, $pvid){
        $api_token = $this->apiToken();
        $path_search = "sellers/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'province_id' => $pvid,
        ]);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }
    //-- จบ สำหรับ Seller--


    /**
     *
     */

    //-- สำหรับ Leader--

    public function fetch_provinces_products_leaders($id){

        $api_token = $this->apiToken();
        $path_search = "/saleleaders/".Auth::user()->api_identify."/pdglists/".$id."/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $provinces[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'region_id' => $value['region_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'provinces' => $provinces
        ]);
    }

    public function fetch_amphur_products_leaders($pdgid, $id){

        $api_token = $this->apiToken();
        $path_search = "/saleleaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/amphures?province_id=".$id;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_datatable_customer_leaders($pdgid,$pvid,$ampid){
        $api_token = $this->apiToken();
        $path_search = "saleleaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers?province_id=".$pvid."&amphoe_id=".$ampid;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }
        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_leaders_pdglist($pdgid){
        $api_token = $this->apiToken();
        $path_search = "saleleaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_leaders_pdglist_pvid($pdgid, $pvid){
        $api_token = $this->apiToken();
        $path_search = "saleleaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'province_id' => $pvid,
        ]);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }
        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }
    //-- จบ สำหรับ Leader--


    /**
     *
     */

    //-- สำหรับ Header--

    public function fetch_provinces_products_headers($id){

        $api_token = $this->apiToken();
        $path_search = "/saleheaders/".Auth::user()->api_identify."/pdglists/".$id."/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $provinces[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'region_id' => $value['region_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'provinces' => $provinces
        ]);
    }

    public function fetch_amphur_products_headers($pdgid, $id){

        $api_token = $this->apiToken();
        $path_search = "/saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/amphures?province_id=".$id;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_datatable_customer_headers($pdgid,$pvid,$ampid){
        $api_token = $this->apiToken();
        $path_search = "saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers?province_id=".$pvid."&amphoe_id=".$ampid;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }


        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_headers_pdglist($pdgid){
        $api_token = $this->apiToken();
        $path_search = "saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_headers_pdglist_pvid($pdgid, $pvid){
        $api_token = $this->apiToken();
        $path_search = "saleheaders/".Auth::user()->api_identify."/pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'province_id' => $pvid,
        ]);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }


        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }
    //-- จบ สำหรับ Header--

    //-- สำหรับ Admin--

    public function fetch_provinces_products_admin($id){

        $api_token = $this->apiToken();
        $path_search = "/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $provinces[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'region_id' => $value['region_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'provinces' => $provinces
        ]);
    }

    public function fetch_amphur_products_admin($id){

        $api_token = $this->apiToken();
        $path_search = "/provinces/".$id."/amphures";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        $provinces = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $amphures[] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'province_id' => $value['province_id']
                ];
            }
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $amphures
        ]);
    }

    public function fetch_datatable_customer_admin($ampid){
        $api_token = $this->apiToken();
        $path_search = "amphures/".$ampid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }

        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_admin_pdglist($pdgid){
        $api_token = $this->apiToken();
        $path_search = "pdglists/".$pdgid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();

        if($res_api['code'] == 200){
            foreach($res_api['data'] as $key => $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }


        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    public function fetch_datatable_customer_admin_pdglist_pvid($pvid){
        $api_token = $this->apiToken();
        $path_search = "provinces/".$pvid."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        $customer = array();
        
        if($res_api['code'] == 200){
            foreach($res_api['data'] as $key => $value){
                $customer[] = [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'amphoe_name' => $value['amphoe_name'],
                    'province_name' => $value['province_name'],
                    'telephone' => $value['telephone'],
                    'mobile' => $value['mobile']
                ];
            }
        }


        return Datatables::of($customer)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['title']." ".$row['name'];
        })
        ->editColumn('province_name',function($row){
            return $row['amphoe_name'].", ".$row['province_name'];
        })
        ->editColumn('telephone',function($row){
            return $row['telephone'].", ".$row['mobile'];
        })
        ->make(true);
    }

    //-- จบ สำหรับ Admin--






}
