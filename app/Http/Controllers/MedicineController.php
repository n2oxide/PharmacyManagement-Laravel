<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\agency;
use App\Medicine;
use Auth;

class MedicineController extends Controller
{
    //录入药物页面
    public function entryMedicinePage()
    {
        return view('medicines.entryPage');
    }

    /**录入药物信息
     * @param Request $medicineInformation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function entryMedicine(Request $medicineInformation)
    {
        /**
         * 权限检查
         */
        if (!Auth::check()) {
            session()->flash('info', '请先登录');
            return redirect()->route('loginPage');
        } else if (Auth::user()->permission_token == 2) {
            session()->flash('danger', '权限不足');
            return redirect()->route('home');
        }
        /**
         * 验证数据
         */
        $this->validate($medicineInformation,
            [
                'mno' => 'required|max:12|unique:medicines',
                'mname' => 'required|max:50',
                'mmode' => 'required|max:2',
                'mefficacy' => 'required|max:50',
                'mnum' => 'required|max:5',
                'mouttime' => 'required'
            ]);
        /**
         * 录入
         */
        Auth::user()->agency->medicines()->create([
            'mno' => $medicineInformation->mno,
            'mname' => $medicineInformation->mname,
            'mmode' => $medicineInformation->mmode,
            'mefficacy' => $medicineInformation->mefficacy,
            'mnum' => $medicineInformation->mnum,
            'mouttime' => $medicineInformation->mouttime
        ]);
        
        session()->flash('success','成功录入');
        return redirect()->back();
    }

    /*修改药物信息
     *
     */
    public function modifyMedicinePage()
    {
        return view('medicines.modifyMedicineInformation');
    }

    //修改
    public function modifyMedicine(Request $medicineInformation)
    {
        $this->validate($medicineInformation,
            [
                'mno' => 'required|max:12',
                'mname' => 'required|max:50',
                'mmode' => 'required|max:2',
                'mefficacy' => 'required|max:50',
                'mnum' => 'required|max:5',
                'mouttime' => 'required'
            ]);
        $medicine = Medicine::where('mno', $medicineInformation->mno);
        $medicine->update([
            'mname' => $medicineInformation->mname,
            'mmode' => $medicineInformation->mmode,
            'mefficacy' => $medicineInformation->mefficacy,
            'mnum' => $medicineInformation->mnum,
            'mouttime' => $medicineInformation->mouttime
        ]);

        $modifyResult = $medicine->first();
        if ($medicineInformation->has('ajax')) {
            return response()->json($modifyResult);
        } else
            return view('welcome');
    }

    //药物页面
    public function medicinePage($mno)
    {
        //得到药物信息
        $medicine = Medicine::where('mno',$mno)->first();
        /*
        //得到顾客信息
        $sellMedicines = $medicine->sellMedicines()->orderBy('ono','desc')->get();
        for ($i=0,$orderForms=[];$i<count($sellMedicines);$i++)
            $orderForms[$i]='';
        $i=0;
        foreach ($sellMedicines as $sellMedicine)
        {
            $orderForms[$i]=$sellMedicine->orderForm;
            $i++;
        }
        for ($i=0,$clientNos=[];$i<count($orderForms);$i++)
            $clientNos[$i]=$orderForms[$i]->cno;
        */
        return view('medicines/modifyMedicineInformation',['medicine'=>$medicine]);
    }
    /**查询页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function retrieveMedicinePage()
    {
        return view('medicines.retrievePage');
    }

    /**查询
     * @param Request $retrieveMedicine
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveMedicine(Request $retrieveMedicine)
    {
        $retrieveResult = '';
        if (!is_array($retrieveMedicine->mno)) {
	    $this->validate($retrieveMedicine,[
            'ano'=>'nullable|numeric',
            'mname'=>'nullable|max:50|string',
            'mno'=>'nullable|string|max:12',
            'mefficacy'=>'nullable|string|max:50'
        ]);
            $retrieveResult = Medicine::where([
                ['ano', 'like', $retrieveMedicine->ano == null ? '%' : $retrieveMedicine->ano],
                ['mname', "like", $retrieveMedicine->mname == null ? '%' : '%' . $retrieveMedicine->mname . '%'],
                ['mno', "like", $retrieveMedicine->mno == null ? '%' : $retrieveMedicine->mno],
                ['mefficacy', 'like', $retrieveMedicine->mefficacy == null ? '%' : '%' . $retrieveMedicine->mefficacy . '%'],
            ])->orderBy('mouttime', 'asc')->get();
        } else {
	    $this->validate($retrieveMedicine,[
            'mno.*.*'=>'nullable|max:12|string'
        ]);
            $retrieveResult = [];
            for ($i = 0, $n = count($retrieveMedicine->mno); $i < $n; $i++) {
                $retrieveResult[$i] = Medicine::where('mno', $retrieveMedicine->mno[$i])->first();
            }
        }
        return response()->json($retrieveResult);
    }

    public function deleteMedicine($mno)
    {
        if (!Auth::check()) {
            session()->flash('info', '请先登录');
            return redirect()->route('loginPage');
        }
        if ((int)Auth::user()->permission_token > 1) {
            session()->flash('danger', '权限不足');
            return redirect()->route('home');
        }
        $medicine = Medicine::where('mno', $mno)->first();
        if ($medicine->sellMedicines()->first() != null) {
            session()->flash('warning', '还有订单记录的药物不允许删除！');
        } else {
            session()->flash('success', '删除成功！');
            Medicine::where('mno', $mno)->delete();
        }
        return redirect()->back();
    }

    /**ajax测试
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        /*$this->validate($request,[
            'date' => 'required|min:20|email'
        ]);*/
        $msg = $request->date;
        return response()->json(array('msg' => $msg), 200);
    }

}
