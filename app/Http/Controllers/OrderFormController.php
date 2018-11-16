<?php

namespace App\Http\Controllers;

use App\Medicine;
use Illuminate\Http\Request;
use App\agency;
use App\sellMedicines;
use App\OrderForm;
use Illuminate\Support\Facades\DB;
use Auth;


class OrderFormController extends Controller
{
    //
    public function entryOrderFormPage()
    {
        return view('orderForms.entryOrderFormPage');
    }

    //录入订单信息
    public function entryOrderForm(Request $orderFormInformation)
    {
        //待实现权限检查
        if (Auth::check())
            $agency = Auth::user()->agency;
        else
            return redirect()->route('loginPage');

        //录入orderForm
        $orderForm = $agency->orderForms()->create([
            'cno' => $orderFormInformation->cno,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        //录入sell_medicines
        $ono = $orderForm->id;
        $nullSureBuyMno = 0;
        $i = -1;
        foreach ($orderFormInformation->sureBuyMnos as $sureBuyMno) {
            $i++;
            if ($sureBuyMno == null) {
                $nullSureBuyMno++;
                continue;
            }
            sellMedicines::create([
                'ono' => $ono,
                'mno' => $sureBuyMno,
                'sellNum' => $orderFormInformation->sellNum[$i] == "" ? 1 : $orderFormInformation->sellNum[$i]
            ]);
            $medicine = Medicine::where('mno', $sureBuyMno);
            $medicineF = $medicine->first();
            $medicine->update([
                'mnum' => $medicineF->mnum - ($orderFormInformation->sellNum[$i] == "" ? 1 : $orderFormInformation->sellNum[$i])
            ]);
        }
        $num = count($orderFormInformation->sureBuyMnos) - $nullSureBuyMno;
        session()->flash('success', '录入购药信息成功，共' . $num . '种药物');
        return redirect()->back();
    }

    //统计
    public function total()
    {
        //近30天订单统计
        $orderForms[] = DB::raw(' * from order_forms where DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= created_at');

        $orderForms = orderForm::get($orderForms);
        //得到订单号
        for ($i = 0,$ono_s=[];$i<count($orderForms);$i++)
        {
            $ono_s[$i] = $orderForms[$i]->first()->ono;
        }

        $medicines = sellMedicines::select(DB::raw('mno,sum(sellNum) sellSum'))->whereIn ('ono',$ono_s)
                                                                               ->groundBy('mno')
                                                                                ->orderBy(DB::raw('sum(sellNum)'),'desc')
                                                                                ->limit(3)
                                                                                ->get();

        return view('total',['medicines'=>$medicines]);
    }
}
