<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use DateTimeZone;

class ProductController extends Controller
{
    public function index()
    {
        return view('Home_v', [
            'data' => DB::table("product")->select('product.*', "nama_kategori", "nama_status")
                ->join("kategori", "kategori.id", "=", "product.kategori_id")
                ->join("status", "status.id", "=", "product.status_id")
                ->orderBy("product.id")->paginate(10)
        ]);
    }

    public function getData(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);
        $offset = ($page - 1) * $perPage;

        $query = DB::table("product")->select('product.*', "nama_kategori", "nama_status","kategori.id as kat_id","status.id as sta_id")
            ->join("kategori", "kategori.id", "=", "product.kategori_id")
            ->join("status", "status.id", "=", "product.status_id")
            ->where("status.nama_status","bisa dijual")
            ->orderBy("product.id");
        $totalItems = $query->count(); 
        $data = $query->skip($offset)->take($perPage)->get();

        $totalPages = ceil($totalItems / $perPage);

        $getSta = DB::table("status")->get();
        $getkat = DB::table("kategori")->get();

        return response()->json([
            'data' => $data,
            'current_page' => $page,
            'per_page' => $perPage,
            'total_pages' => $totalPages,
            'total_items' => $totalItems,
            'getsta' => $getSta,
            'getkat' => $getkat
        ]);
    }

    public function callApi()
    {
        $waktuSekarang = Carbon::now(new DateTimeZone('Asia/Jakarta'));
        $waktuDitambah1Jam = $waktuSekarang->addHours(1);
        $tanggalDmy = $waktuDitambah1Jam->format('dmy');
        $jam = $waktuDitambah1Jam->format('H');

        $username = 'tesprogrammer' . $tanggalDmy . 'C' . $jam;
        $password = 'bisacoding-' . date('d-m-y');

        $data = [
            'username' => $username,
            'password' => md5($password)
        ];

        $url = "https://recruitment.fastprint.co.id/tes/api_tes_programmer";

        $response = Http::asForm()->post($url, [
            'username' => $username,
            'password' => md5($password)
        ]);

        $apiResponse = $response->json();

        if ($apiResponse['error'] == 0) {
            $count = $this->InsertDataFromApi($apiResponse['data']);
            return response()->json(['status' => 0, 'count' => $count]);
        } else {
            return response()->json(['status' => 1]);
        }

    }

    public function InsertDataFromApi($apiResponse)
    {
        $count = 0;
        foreach ($apiResponse as $val) {
            $cekKat = DB::table("kategori")->where('nama_kategori', $val['kategori'])->get();
            if (count($cekKat) == 0) {
                $kategori_id = DB::table('kategori')->insertGetId([
                    "nama_kategori" => $val['kategori']
                ], 'id');
            } else {
                $kategori_id = $cekKat[0]->id;
            }
            $ceksta = DB::table("status")->where('nama_status', $val['status'])->get();
            if (count($ceksta) == 0) {
                $status_id = DB::table('status')->insertGetId([
                    "nama_status" => $val['status']
                ], 'id');
            } else {
                $status_id = $ceksta[0]->id;
            }
            $cekProd = DB::table("product")->where("id", $val['id_produk'])->count();
            if ($cekProd == 0) {
                $product = [
                    "id" => $val["id_produk"],
                    "nama_produk" => $val['nama_produk'],
                    "harga" => $val["harga"],
                    "kategori_id" => $kategori_id,
                    "status_id" => $status_id
                ];
                DB::table("product")->insert($product);
                $count++;
            }
        }
        return $count;
    }

    public function AddData(Request $request){

        $validatedData = $request->validate([
            'product' => 'required|string',
            'harga' => 'required|integer',
            'ketegori' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $data = [
            "nama_produk" => $validatedData['product'],
            "harga" => $validatedData['harga'],
            "kategori_id" => $validatedData['ketegori'],
            "status_id" => $validatedData['status'],
        ];
        DB::table("product")->insert($data);

        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $validatedData]);
    }

    public function EditData(Request $request, $id){

        $validatedData = $request->validate([
            'product' => 'required|string',
            'harga' => 'required|integer',
            'ketegori' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $data = [
            "nama_produk" => $validatedData['product'],
            "harga" => $validatedData['harga'],
            "kategori_id" => $validatedData['ketegori'],
            "status_id" => $validatedData['status'],
        ];
        DB::table("product")->where("id",$id)->update($data);

        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $validatedData]);
    }

    public function HapusData($id){

        DB::table("product")->where("id",$id)->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

}