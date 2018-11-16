<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\agency;
use App\User;
use Auth;

class AgencyController extends Controller
{
    /*
     * 录入经办人信息
     */
    public function entryAgency(Request $agencyInformation)
    {
        /**
         * 权限检查
         */
        if (!Auth::check()) {
            session()->flash('info', '请先登录');
            return redirect()->route('loginPage');
        } else if (Auth::user()->permission_token > 0) {
            session()->flash('danger', '权限不足');
            return redirect()->route('home');
        }

        //验证数据
        $this->validate($agencyInformation, [
            'agencyName' => 'required|string|max:8',
            'agencyPhone' => 'required|numeric|digits_between:8,12|unique:users,phone',
            'sex' => 'required|max:1|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $agency = agency::create();

        $agency->ano = $agency->id;
        //录入
        $agency->user()->create([
            'name' => $agencyInformation->agencyName,
            'phone' => $agencyInformation->agencyPhone,
            'sex' => $agencyInformation->sex,
            'permission_token' => 1,
            'password' => bcrypt($agencyInformation->password),
        ]);

        session()->flash('success', '成功录入经办人信息');
        return redirect()->route('home');
    }

    //经办人信息页面
    public function agencyPage($ano)
    {
        $agency = agency::join('users', 'agencies.ano', '=', 'users.ano')
            ->select('*')
            ->where('agencies.ano', $ano)
            ->first();
        //取得经办人所有销售药物
        //订单
        $orderForms = $agency->orderForms()->orderBy('created_at','desc')->get();
        //对应药物
        for ($sellMedicines = [], $i = 0, $orderFormsLength = count($orderForms); $i < $orderFormsLength; $i++) {
            $sellMedicines[$i] = '';
        }
        $i = 0;

        foreach ($orderForms as $orderForm)
        {
            $sellMedicines[$i] = $orderForm->sellMedicines;
            $i++;
        }

        $orderForms = $agency->orderForms()->orderBy('created_at','desc')->paginate(8);
        //取得经办人所有购入药物
        $medicines = $agency->medicines()
                            ->orderBy('mouttime','asc')
                            ->paginate(8,['*'],'pageM');

        return view('agencies.modifyAgencyInformation',['agency'=>$agency,'orderForms'=>$orderForms,'sellMedicines'=>$sellMedicines,'medicines'=>$medicines]);
    }

    /*修改经办人信息
     *
     */
    //视图
    public function modifyAgencyPage()
    {
        return view('agencies.modifyAgencyInformation');
    }

    //修改
    public function modifyAgency(Request $agencyInfoRequest)
    {
        $this->validate($agencyInfoRequest, [
            'id' => 'required|numeric',
            'agencyName' => 'required|string|max:8',
            'agencyPhone' => 'required|numeric|digits_between:8,12',
            'sex' => 'required|max:1|string',
            'remark' => 'max:49',
        ]);
        $user = User::where('id', $agencyInfoRequest->id)->first();
        if ($agencyInfoRequest->agencyPhone != $user->phone && User::where('phone', $agencyInfoRequest->agencyPhone)->first() !== null)
            return response()->json(['warning' => '此手机号码已被注册']);
        $user->update([
            'name' => $agencyInfoRequest->agencyName,
            'phone' => $agencyInfoRequest->agencyPhone,
            'sex' => $agencyInfoRequest->sex,
            'remark' => $agencyInfoRequest->remark == null ? $user->remark : $agencyInfoRequest->remark
        ]);
        $modifyResult = $user;
        if (!$agencyInfoRequest->has('ajax'))
            return redirect()->back();
        elseif ($agencyInfoRequest->has('ajax'))
            return response()->json($modifyResult);
    }

    /**
     * 查询经办人信息
     */
    public function retrieveAgencyPage()
    {
        //权限检查
        /*if (!Auth::check()) {
            session()->flash('info', '请先登录');
            return redirect()->route('loginPage');
        } else if (Auth::user()->permission_token == 2) {
            session()->flash('danger', '权限不足');
            return redirect()->route('home');
        }*/
        return view('agencies.retrieveAgencyPage');
    }

    public function retrieveAgency(Request $agencyInformation)
    {
        $this->validate($agencyInformation, [
            'agencyPhone' => 'nullable|numeric|digits_between:8,12',
            'agencyName' => 'nullable|string|max:8',
            'agencyAno' => 'nullable|numeric'
        ]);
        $retrieveResult = agency::join('users', 'agencies.ano', '=', 'users.ano')
            ->select('*')
            ->where([
                ['phone', 'like', $agencyInformation->agencyPhone == null ? '%' : $agencyInformation->agencyPhone],
                ['name', 'like', $agencyInformation->agencyName == null ? '%' : '%' . $agencyInformation->agencyName . '%'],
                ['agencies.ano', 'like', $agencyInformation->agencyAno == null ? '%' : $agencyInformation->agencyAno],
            ])->get();
        return response()->json($retrieveResult);
    }

    public function deleteAgency($id)
    {
        if (!Auth::check()) {
            session()->flash('info', '请先登录');
            return redirect()->route('loginPage');
        }
        if ((int)Auth::user()->permission_token > 0) {
            session()->flash('danger', '权限不足');
            return redirect()->route('home');
        }
        $agency = User::where('id', $id)->first()->agency;

        $canDelete = true;
        if ($agency->orderForms()->first() != null) {
            session()->flash('warning','还有订单记录的经办人不允许删除！');
            $canDelete = false;
        }
        if ($agency->medicines()->first() != null) {
            session()->flash('warning', '还有录入药物记录的经办人不允许删除！');
            $canDelete = false;
        }
        if ($canDelete) {
            session()->flash('success', '删除成功！');
            agency::where('ano', $agency->ano)->delete();
        }
        return redirect()->back();
    }
}
