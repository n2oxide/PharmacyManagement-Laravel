<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\client;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**验证输入的顾客信息
     * @param $clientInformation
     */
    private function validate_Input_Client_Information($clientInformation)
    {
        $this->validate($clientInformation, [
            'clientName' => 'required|string|max:8',
            'clientPhone' => 'required|numeric|digits_between:8,12|unique:users,phone',
            'sex' => 'required|max:1|string',
            'password' => 'required|string|min:6|confirmed',
            'cbirthday' => 'required|date',
            'clientProvince' => 'required|string',
            'clientCity' => 'required|string',
            'clientArea' => 'required|string',
            'clientStreet' => 'required|max:32|string',
            'clientSymptom' => 'required|max:50|string',
            'remark' => 'max:49'
        ]);
    }

    //用户页面
    public function clientPage($cno)
    {
        $client = User::join('clients', 'users.cno', 'clients.cno')
            ->select('*')
            ->where('users.cno',$cno)
            ->addSelect(DB::raw("year(curdate())-year(clients.cbirthday) cage"))->first();
        //取得顾客曾购药物
        //订单
        $orderForms = client::where('cno',$cno)->first()->orderForms()->orderBy('created_at','desc')->get();
        //对应药物
        for ($medicines = [], $i = 0, $orderFormsLength = count($orderForms); $i < $orderFormsLength; $i++) {
            $medicines[$i] = '';
        }
        $i = 0;

        foreach ($orderForms as $orderForm)
        {
            $medicines[$i] = $orderForm->sellMedicines;
            $i++;
        }

        $orderForms = client::where('cno',$cno)->first()->orderForms()->orderBy('created_at','desc')->paginate(8);

        return view('clients.clientPage',['client'=>$client,'orderForms'=>$orderForms,'medicines'=>$medicines]);
    }

    /**录入顾客信息
     * @param Request $clientInformation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function entryClient(Request $clientInformation)
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
        /*
         * 验证数据
         */
        $this->validate_Input_Client_Information($clientInformation);

        /*
         * 创建顾客信息
         */
        $client = client::create([
            'cbirthday' => $clientInformation->cbirthday,
            'province' => $clientInformation->clientProvince,
            'city' => $clientInformation->clientCity,
            'area' => $clientInformation->clientArea,
            'street' => $clientInformation->clientStreet,
            'csymptom' => $clientInformation->clientSymptom
        ]);
        /*
         * 联系、创建用户信息
         */
        $client->cno = $client->id;

        $client->user()->create([
            'name' => $clientInformation->clientName,
            'phone' => $clientInformation->clientPhone,
            'sex' => $clientInformation->sex,
            'remark' => $clientInformation->remark,
            'password' => bcrypt($clientInformation->password),
        ]);

        session()->flash('success', '成功录入顾客信息');

        return redirect()->back();/*return view（name）无法刷新url*/
    }

    /*修改顾客信息
     *
     */
    public function modifyClientPage()
    {
        return view('clients.modifyClientInformation');
    }

    public function modifyClient(Request $clientInformation)
    {
        $this->validate($clientInformation, [
            'cno' => 'required|numeric',
            'clientName' => 'required|string|max:8',
            'clientPhone' => 'required|numeric|digits_between:8,12',
            'sex' => 'required|max:1|string',
            'cbirthday' => 'required|date',
            'clientProvince' => 'required|string|max:8',
            'clientCity' => 'required|string|max:8',
            'clientArea' => 'required|string|max:8',
            'clientStreet' => 'required|string',
            'clientSymptom' => 'required|string|max:50',
            'remark' => 'max:49|nullable',
        ]);

        $clientUser = User::where('cno', $clientInformation->cno)->first();
        if ($clientInformation->clientPhone != $clientUser->phone && User::where('phone', $clientInformation->clientPhone)->first() !== null)
            return response()->json(['warning' => '此手机号码已被注册']);
        $clientUser->update([
            'name' => $clientInformation->clientName,
            'phone' => $clientInformation->clientPhone,
            'sex' => $clientInformation->sex,
            'remark' => $clientInformation->remark == null ? $clientUser->remark : $clientInformation->remark
        ]);

        $client = $clientUser->client;
        client::where('cno', $client->cno)->update([
            'cbirthday' => $clientInformation->cbirthday,
            'province' => $clientInformation->clientProvince,
            'city' => $clientInformation->clientCity,
            'area' => $clientInformation->clientArea,
            'street' => $clientInformation->clientStreet,
            'csymptom' => $clientInformation->clientSymptom
        ]);

        $updateResult = User::join('clients', 'users.cno', 'clients.cno')
            ->select('*')
            ->where('clients.cno', $clientInformation->cno)->addSelect(DB::raw("year(curdate())-year(clients.cbirthday) cage"))
            ->first();

        if ($clientInformation->has('ajax')) {
            return response()->json($updateResult);
        } else {
            session()->flash('success', '修改成功');
            return redirect()->back();
        }
    }
    /**查询顾客信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    //页面
    public function retrieveClientPage()
    {
        //权限检查
        if (!Auth::check()) {
            session()->flash('info', '请先登录');
            return redirect()->route('loginPage');
        } else if (Auth::user()->permission_token == 2) {
            session()->flash('danger', '权限不足');
            return redirect()->route('home');
        }
        return view('clients.retrieveClientPage');
    }

    //查询
    public function retrieveClient(Request $clientInformation)
    {
        $this->validate($clientInformation,[
           'clientPhone'=>['nullable','digits_between:8,12','numeric'],
           'clientName'=>'nullable|string|max:8',
           'clientProvince'=>'nullable|string',
           'clientCity'=>'nullable|string',
           'clientArea'=>'nullable|string',
           'clientStreet'=>'nullable|string',
           'clientSymptom'=>'nullable|string|max:50'
        ]);
        //查询顾客信息
        $retrieveResult = User::join('clients', 'users.cno', 'clients.cno')
            ->select('*')
            ->where([
                ['users.phone', 'like', $clientInformation->clientPhone == null ? '%' : $clientInformation->clientPhone],
                ['users.name', 'like', $clientInformation->clientName == null ? '%' : $clientInformation->clientName],
                ['clients.province', 'like', $clientInformation->clientProvince == null ? '%' : '%' . $clientInformation->clientProvince . '%'],
                ['clients.city', 'like', $clientInformation->clientCity == null ? '%' : '%' . $clientInformation->clientCity . '%'],
                ['clients.area', 'like', $clientInformation->clientArea == null ? '%' : '%' . $clientInformation->clientArea . '%'],
                ['clients.street', 'like', $clientInformation->clientStreet == null ? '%' : '%' . $clientInformation->clientStreet . '%'],
                ['clients.csymptom', 'like', $clientInformation->clientSymptom == null ? '%' : '%' . $clientInformation->clientSymptom . '%']
            ])->addSelect(DB::raw("year(curdate())-year(clients.cbirthday) cage"))->get();

        return response()->json($retrieveResult);
    }

    /*删除顾客信息
     *
     */
    public function deleteClient($clientNo)
    {
        if (!Auth::check()) {
            session()->flash('info', '请先登录');
            return redirect()->route('loginPage');
        }
        if ((int)Auth::user()->permission_token > 1 && (int)Auth::user()->cno != (int)$clientNo) {
            session()->flash('danger', '权限不足');
            return redirect()->route('home');
        }

        $client = Client::where('cno', $clientNo)->first();

        if ($client != null) {
            Client::where('cno', $clientNo)->delete();
            session()->flash('success', '成功删除');
            return redirect()->back();
        } else {
            session()->flash('danger', '删除失败，用户不存在');
            return redirect()->back();
        }
    }
}
